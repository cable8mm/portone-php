<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Client\PaymentClient;
use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\Exception\UnknownException;
use Cable8mm\PortonePhp\Model\CancelPaymentResponse;
use Cable8mm\PortonePhp\Model\PayInstantlyResponse;
use Cable8mm\PortonePhp\Model\Payment;
use Cable8mm\PortonePhp\Model\PaymentCancellation;
use Dotenv\Dotenv;

/**
 * T-052 Partial cancellation and refund paths — live E2E probe.
 *
 * Flow:
 *  1. payInstantly  (1 000 KRW, skipWebhook=true)
 *  2. getPayment    verify PAID
 *  3. cancelPayment partial (amount=400, currentCancellableAmount=1000) → PARTIAL_CANCELLED
 *  4. getPayment    verify PARTIAL_CANCELLED
 *  5. cancelPayment final (amount=600, currentCancellableAmount=600) → CANCELLED
 *  6. getPayment    verify CANCELLED
 *  7. Error obs: CANCEL_AMOUNT_EXCEEDS_CANCELLABLE_AMOUNT  (fresh payment, over-cancel)
 *  8. Error obs: CANCELLABLE_AMOUNT_CONSISTENCY_BROKEN     (same payment, wrong guard amount)
 *  9. Error obs: PAYMENT_ALREADY_CANCELLED                (double cancel on already-cancelled payment)
 */

require __DIR__.'/../vendor/autoload.php';

$root = dirname(__DIR__);
Dotenv::createImmutable($root)->safeLoad();

foreach (array_keys($_ENV) as $name) {
    if (is_string($_ENV[$name])) {
        putenv($name.'='.$_ENV[$name]);
    }
}

/** @return non-empty-string */
function requiredEnv(string $name): string
{
    $value = getenv($name);
    if ($value === false || $value === '') {
        throw new RuntimeException($name.' is not set in .env.');
    }

    return $value;
}

function optionalEnv(string $name): ?string
{
    $value = getenv($name);

    return $value === false || $value === '' ? null : $value;
}

/** @param array<string,mixed> $record */
function writeObservation(array $record): void
{
    $path = __DIR__.'/../tests/fixtures/partial-cancellation-boundary-observations.json';
    if (file_put_contents($path, json_encode($record, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
        throw new RuntimeException('Could not write partial-cancellation observation.');
    }
}

/**
 * Pay 1 000 KRW instantly and return the paymentId.
 *
 * @return non-empty-string
 */
function payInstantly(PaymentClient $client, string $channelKey, array $credential, ?string $storeId): string
{
    $paymentId = 'codex-e2e-partial-'.bin2hex(random_bytes(8));
    $created = $client->payInstantly(
        $paymentId,
        $channelKey,
        null,
        ['card' => ['credential' => $credential]],
        'portone-php partial cancel E2E',
        false,
        false,
        null,
        'codex-e2e',
        ['total' => 1000, 'taxFree' => 0],
        'KRW',
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        true,   // skipWebhook
        $storeId,
    );
    if (! $created instanceof PayInstantlyResponse || $created->payment->pgTxId === '') {
        throw new UnexpectedValueException('payInstantly did not return a typed InstantPaymentSummary.');
    }

    return $paymentId;
}

// ─── initialise ──────────────────────────────────────────────────────────────

$record = [
    'status' => 'failed',
    'operations' => [],
    'errors' => [],
];

try {
    $apiSecret = requiredEnv('PORTONE_API_SECRET');
    $channelKey = requiredEnv('PORTONE_E2E_CHANNEL_KEY');
    $cardNumber = requiredEnv('PORTONE_E2E_CARD_NUMBER');
    $expiryYear = requiredEnv('PORTONE_E2E_CARD_EXPIRY_YEAR');
    $expiryMonth = requiredEnv('PORTONE_E2E_CARD_EXPIRY_MONTH');
    $storeId = optionalEnv('PORTONE_E2E_STORE_ID');

    $credential = ['number' => $cardNumber, 'expiryYear' => $expiryYear, 'expiryMonth' => $expiryMonth];
    if (($bbn = optionalEnv('PORTONE_E2E_BIRTH_OR_BUSINESS_NUMBER')) !== null) {
        $credential['birthOrBusinessRegistrationNumber'] = $bbn;
    }
    if (($pwd = optionalEnv('PORTONE_E2E_PASSWORD_TWO_DIGITS')) !== null) {
        $credential['passwordTwoDigits'] = $pwd;
    }

    $client = new PaymentClient($apiSecret);

    // ── STEP 1: pay 1 000 KRW ─────────────────────────────────────────────
    $paymentId = payInstantly($client, $channelKey, $credential, $storeId);
    $record['operations']['payInstantly'] = ['status' => 'success', 'paymentId' => $paymentId];

    // ── STEP 2: verify PAID ───────────────────────────────────────────────
    $payment = $client->getPayment($paymentId, $storeId);
    if (! $payment instanceof Payment || $payment->variant !== 'PAID') {
        throw new UnexpectedValueException('Expected PAID after payInstantly, got '.$payment->variant.'.');
    }
    $record['operations']['getPayment_after_pay'] = [
        'status' => 'success',
        'paymentStatus' => $payment->variant,
    ];

    // ── STEP 3: partial cancel 400 of 1000 ───────────────────────────────
    $step1 = $client->cancelPayment(
        paymentId: $paymentId,
        amount: 400,
        taxFreeAmount: 0,
        vatAmount: 0,
        reason: 'portone-php partial cancel E2E step-1',
        requester: 'CUSTOMER',
        currentCancellableAmount: 1000,
        skipWebhook: true,
        storeId: $storeId,
    );
    if (! $step1 instanceof CancelPaymentResponse || ! $step1->cancellation instanceof PaymentCancellation) {
        throw new UnexpectedValueException('cancelPayment step-1 did not return typed CancelPaymentResponse.');
    }
    $record['operations']['cancelPayment_partial_step1'] = [
        'status' => 'success',
        'resultType' => $step1::class,
        'cancellationStatus' => $step1->cancellation->variant,
        'totalAmount' => $step1->cancellation->data['totalAmount'],
    ];

    // ── STEP 4: verify PARTIAL_CANCELLED ─────────────────────────────────
    $paymentAfterPartial = null;
    for ($i = 0; $i < 10; $i++) {
        $paymentAfterPartial = $client->getPayment($paymentId, $storeId);
        if ($paymentAfterPartial->variant === 'PARTIAL_CANCELLED') {
            break;
        }
        usleep(2_000_000);
    }
    if (! $paymentAfterPartial instanceof Payment || $paymentAfterPartial->variant !== 'PARTIAL_CANCELLED') {
        throw new UnexpectedValueException('Expected PARTIAL_CANCELLED after step-1, got '.$paymentAfterPartial->variant.'.');
    }
    $record['operations']['getPayment_after_partial'] = [
        'status' => 'success',
        'paymentStatus' => $paymentAfterPartial->variant,
    ];

    // ── STEP 5: cancel remaining 600 ────────────────────────────────────
    $step2 = $client->cancelPayment(
        paymentId: $paymentId,
        amount: 600,
        taxFreeAmount: 0,
        vatAmount: 0,
        reason: 'portone-php partial cancel E2E step-2 final',
        requester: 'CUSTOMER',
        currentCancellableAmount: 600,
        skipWebhook: true,
        storeId: $storeId,
    );
    if (! $step2 instanceof CancelPaymentResponse || ! $step2->cancellation instanceof PaymentCancellation) {
        throw new UnexpectedValueException('cancelPayment step-2 did not return typed CancelPaymentResponse.');
    }
    $record['operations']['cancelPayment_final_step2'] = [
        'status' => 'success',
        'resultType' => $step2::class,
        'cancellationStatus' => $step2->cancellation->variant,
        'totalAmount' => $step2->cancellation->data['totalAmount'],
    ];

    // ── STEP 6: verify fully CANCELLED ──────────────────────────────────
    $finalPayment = null;
    for ($i = 0; $i < 10; $i++) {
        $finalPayment = $client->getPayment($paymentId, $storeId);
        if ($finalPayment->variant === 'CANCELLED') {
            break;
        }
        usleep(2_000_000);
    }
    if (! $finalPayment instanceof Payment || $finalPayment->variant !== 'CANCELLED') {
        throw new UnexpectedValueException('Expected CANCELLED after step-2, got '.$finalPayment->variant.'.');
    }
    $record['operations']['getPayment_after_final'] = [
        'status' => 'success',
        'paymentStatus' => $finalPayment->variant,
    ];

    // ── STEP 7: error obs — CANCEL_AMOUNT_EXCEEDS_CANCELLABLE_AMOUNT ────
    // A fresh payment is required (the previous one is fully cancelled already).
    $paymentIdForErrors = payInstantly($client, $channelKey, $credential, $storeId);
    $record['operations']['payInstantly_for_errors'] = ['status' => 'success', 'paymentId' => $paymentIdForErrors];

    try {
        $client->cancelPayment(
            paymentId: $paymentIdForErrors,
            amount: 99999,   // way more than 1000
            reason: 'over-cancel probe',
            skipWebhook: true,
            storeId: $storeId,
        );
        $record['errors']['cancel_amount_exceeds'] = ['status' => 'no-error-raised'];
    } catch (UnknownException $exception) {
        $record['errors']['cancel_amount_exceeds'] = [
            'status' => 'observed',
            'exception' => $exception::class,
            'errorType' => $exception->errorType,
            'httpStatus' => $exception->status,
        ];
    }

    // ── STEP 8: error obs — CANCELLABLE_AMOUNT_CONSISTENCY_BROKEN ───────
    // Provide a wrong currentCancellableAmount (500 instead of 1000).
    try {
        $client->cancelPayment(
            paymentId: $paymentIdForErrors,
            amount: 200,
            currentCancellableAmount: 500,  // actual is 1000 → mismatch
            reason: 'mismatch guard probe',
            skipWebhook: true,
            storeId: $storeId,
        );
        $record['errors']['cancellable_amount_consistency_broken'] = ['status' => 'no-error-raised'];
    } catch (UnknownException $exception) {
        $record['errors']['cancellable_amount_consistency_broken'] = [
            'status' => 'observed',
            'exception' => $exception::class,
            'errorType' => $exception->errorType,
            'httpStatus' => $exception->status,
        ];
    }

    // Clean up the error-probe payment (full cancel, ignore failures).
    try {
        $client->cancelPayment(
            paymentId: $paymentIdForErrors,
            reason: 'error-probe cleanup',
            skipWebhook: true,
            storeId: $storeId,
        );
    } catch (PortOneException) {
        // already cancelled or other transient issue — acceptable
    }

    // ── STEP 9: error obs — PAYMENT_ALREADY_CANCELLED ───────────────────
    // The original paymentId is now CANCELLED — cancel it again.
    try {
        $client->cancelPayment(
            paymentId: $paymentId,
            reason: 'double-cancel probe',
            skipWebhook: true,
            storeId: $storeId,
        );
        $record['errors']['payment_already_cancelled'] = ['status' => 'no-error-raised'];
    } catch (UnknownException $exception) {
        $record['errors']['payment_already_cancelled'] = [
            'status' => 'observed',
            'exception' => $exception::class,
            'errorType' => $exception->errorType,
            'httpStatus' => $exception->status,
        ];
    }

    $record['status'] = 'observed';
} catch (PortOneException $exception) {
    $record['status'] = 'portone-failure';
    $record['exception'] = $exception::class;
    $record['statusCode'] = $exception->status;
    $record['message'] = $exception->getMessage();
} catch (Throwable $exception) {
    $record['exception'] = $exception::class;
    $record['message'] = $exception->getMessage();
}

writeObservation($record);
echo json_encode($record, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;

exit($record['status'] === 'observed' ? 0 : 1);
