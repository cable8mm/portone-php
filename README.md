# PortOne PHP

PortOne V2 REST API용 PHP 서버 SDK입니다. 공식 JVM 서버 SDK의 클라이언트와
operation을 PHP에서 사용할 수 있으며, PortOne webhook 서명 검증과 비동기
operation도 지원합니다.

- Composer 패키지: `cable8mm/portone-php`
- PHP: `^8.2`
- HTTP: Guzzle 8
- 네임스페이스: `Cable8mm\PortonePhp`
- 라이선스: MIT

## 요구 사항

- PHP 8.2 이상
- Composer
- `ext-curl`
- `ext-json`

CI에서는 PHP 8.2, 8.3, 8.4, 8.5를 사용합니다.

## 설치

패키지를 사용하는 애플리케이션에서 다음을 실행합니다.

```sh
composer require cable8mm/portone-php
```

저장소에서 개발하려면 다음과 같이 의존성을 설치합니다.

```sh
git clone https://github.com/cable8mm/portone-php.git
cd portone-php
composer install --no-interaction --prefer-dist
```

이 저장소는 `composer.lock`을 커밋하지 않습니다. 개발 환경에서 Composer가
생성한 lockfile은 `.gitignore` 대상입니다.

## 기본 사용법

라이브러리 자체는 환경변수를 읽지 않습니다. 애플리케이션이 secret을 읽어
생성자에 전달해야 합니다.

### 동기 operation

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Cable8mm\PortonePhp\PortOneClient;

$client = new PortOneClient($apiSecret);
$payment = $client->payment->getPayment($paymentId);

var_dump($payment->data);
```

모든 operation은 JVM SDK와 같은 camelCase 이름을 사용하며, 동기 메서드와
`Async` 접미사가 붙은 비동기 메서드를 함께 제공합니다.

### 비동기 operation

```php
$future = $client->payment->getPaymentsAsync([
    'number' => 0,
    'size' => 10,
]);

if (! $future->isComplete()) {
    // 다른 애플리케이션 작업을 수행할 수 있습니다.
}

$payments = $future->wait();
```

`wait()`는 동기 operation과 같은 typed response를 반환하며, 같은
`PortOneException` 계열 예외를 발생시킵니다. HTTP 요청은 connection timeout
10초, total timeout 30초이며 자동 재시도를 하지 않습니다.

### Webhook 검증

Webhook은 JSON으로 decode하기 전에 반드시 원본 request body를 검증해야
합니다.

```php
$body = file_get_contents('php://input');
$headers = getallheaders();

$verifier = new \Cable8mm\PortonePhp\WebhookVerifier($webhookSecret);
$webhook = $verifier->verify(
    $body,
    $headers['webhook-id'] ?? null,
    $headers['webhook-signature'] ?? null,
    $headers['webhook-timestamp'] ?? null,
);

if ($webhook instanceof \Cable8mm\PortonePhp\WebhookTransactionPaid) {
    $paymentId = $webhook->data->paymentId;
}
```

지원하지 않는 webhook type은 실패하지 않고
`UnrecognizedWebhook`으로 반환됩니다. 서명이 올바르지 않거나 timestamp가
허용 범위를 벗어나면 `WebhookVerificationException`이 발생합니다.

## 로컬 개발 환경

### Secret 설정

`dotenv` 라이브러리는 사용하지 않습니다. 로컬 shell에서만 사용할
`.env` 파일을 만들고 직접 export합니다. `.env`는 Git에 포함되지 않습니다.

```dotenv
PORTONE_API_SECRET=여기에_API_Secret
PORTONE_WEBHOOK_SECRET=whsec_여기에_Webhook_Secret
```

현재 shell에 적용합니다.

```sh
set -a
source .env
set +a
```

Secret을 README, source, fixture, 로그에 넣거나 commit하지 마세요.

## 테스트

### 단위 테스트와 형식 검사

```sh
composer validate --no-check-publish
vendor/bin/pint --test
vendor/bin/phpunit
```

전체 PHPUnit 테스트에는 client hierarchy, operation 계약, sync/async
요청, 오류 분류, webhook 검증, samples 내부 로직이 포함됩니다.

### JVM 계약 검증

기준 JVM 소스는 기본적으로
`/Users/cable8mm/Herd/server-sdk/jvm`에서 읽습니다. 다른 경로라면
`--jvm`으로 지정합니다.

```sh
php tools/reference_contract_probe.php --verify-record
php tools/reference_contract_probe.php \
  --verify-public-contract=tests/fixtures/jvm-v0.24.0-contract.json
```

이 검증은 JVM `jvm-v0.24.0`의 client, operation, parameter, async method,
webhook type과 PHP public contract가 일치하는지 확인합니다.

## Live E2E 테스트

Live E2E는 실제 `https://api.portone.io`와 실제 webhook secret을 사용합니다.
따라서 test store/API Secret을 사용하고, 결과에 secret을 출력하지 마세요.

### API와 transport E2E

먼저 `.env`를 export한 뒤 다음 probe를 실행합니다.

```sh
set -a
source .env
set +a

php tools/portone_boundary_probe.php
php tools/portone_operation_probe.php
php tools/portone_auth_probe.php
php tools/portone_payment_operations_probe.php
php tools/portone_identity_verification_probe.php
php tools/portone_pg_specific_probe.php
php tools/portone_reconciliation_probe.php
php tools/portone_platform_core_probe.php
php tools/portone_platform_bulk_payout_probe.php
php tools/portone_platform_partner_transfer_probe.php
php tools/portone_policy_probe.php
php tools/portone_tax_invoice_probe.php
php tools/portone_counterparty_probe.php
```

Webhook까지 포함해 한 번에 실행하려면 다음을 사용합니다.

```sh
for probe in \
  tools/portone_boundary_probe.php \
  tools/portone_operation_probe.php \
  tools/portone_auth_probe.php \
  tools/portone_payment_operations_probe.php \
  tools/portone_identity_verification_probe.php \
  tools/portone_pg_specific_probe.php \
  tools/portone_reconciliation_probe.php \
  tools/portone_platform_core_probe.php \
  tools/portone_platform_bulk_payout_probe.php \
  tools/portone_platform_partner_transfer_probe.php \
  tools/portone_policy_probe.php \
  tools/portone_tax_invoice_probe.php \
  tools/portone_counterparty_probe.php \
  tools/portone_webhook_probe.php
do
  php "$probe" || exit 1
done
```

일부 operation은 test store의 기능 활성화 여부나 존재하지 않는 resource에
따라 `InvalidRequestException`, `PlatformNotEnabledException`,
`UnknownException`을 기록할 수 있습니다. 이것은 probe가 의도한 controlled
failure이며, 스크립트가 성공적으로 종료되고 JSON 결과를 기록하는지 확인해야
합니다.

### Webhook E2E와 ngrok

1. PHP sample 서버를 실행합니다.

   ```sh
   set -a
   source .env
   set +a
   php -S 127.0.0.1:8080 -t samples samples/index.php
   ```

2. 다른 terminal에서 ngrok을 실행합니다.

   ```sh
   ngrok http 8080
   ```

3. PortOne 관리자 콘솔의 webhook endpoint를 다음 주소로 등록합니다.

   ```text
   https://<ngrok-domain>/webhook-capture.php
   ```

   `webhook-capture.php`는 raw body와 세 webhook header를
   `WebhookVerifier`로 검증한 뒤, 성공한 요청을
   `tests/fixtures/live-webhook.json`에 기록합니다. 잘못된 서명은 400으로
   거부됩니다.

4. PortOne에서 test webhook을 전송하거나 test 결제를 진행합니다. 응답에
   다음과 같은 결과가 나오면 capture가 성공한 것입니다.

   ```json
   {
     "verified": true,
     "type": "Transaction.Paid",
     "fixtureRecorded": true
   }
   ```

5. capture가 끝난 뒤 다음 probe를 실행합니다.

   ```sh
   php tools/portone_webhook_probe.php
   php tools/portone_boundary_probe.php
   ```

   `portone_webhook_probe.php`는 known webhook, unknown webhook, raw body
   변조, signature 변조를 확인합니다. `portone_boundary_probe.php`는
   timestamp tolerance와 live signature 규칙을 추가로 확인합니다.

   capture fixture의 원래 timestamp가 오래된 경우에도 probe는 캡처된 live
   body를 보존하면서 현재 timestamp로 검증용 signature를 재생성합니다.
   실제 webhook endpoint 검증에서는 PortOne이 보낸 원본 timestamp가 그대로
   사용됩니다.

### PHP sample E2E

Sample endpoint를 실행한 뒤 다음을 확인할 수 있습니다.

```sh
curl http://127.0.0.1:8080/api/item

curl -X POST http://127.0.0.1:8080/api/payment/complete \
  -H 'Content-Type: application/json' \
  -d '{"paymentId":"<test-payment-id>"}'
```

Webhook URL은 다음과 같습니다.

```text
POST /api/payment/webhook
```

샘플의 상세 설명은 [samples/README.md](samples/README.md)를 참고하세요.

## CI

GitHub Actions는 push와 pull request마다 PHP 8.2, 8.3, 8.4, 8.5 각각에
대해 다음을 실행합니다.

```sh
composer install --no-interaction --prefer-dist
vendor/bin/pint --test
vendor/bin/phpunit
```

## 예외 처리

모든 SDK runtime failure는 `PortOneException`에서 파생됩니다.

- `InvalidArgumentException`: 빈 secret 등 생성자 입력 오류
- `InvalidRequestException`: PortOne API의 정의된 잘못된 요청
- `UnauthorizedException`: 인증 실패
- `ForbiddenException`: 권한 부족
- `PlatformNotEnabledException`: Platform 기능 미활성화
- `UnknownException`: 정의되지 않은 API 오류
- `UnrecognizedResponseException`: 성공 응답을 decode할 수 없음
- `TransportException`: 네트워크 또는 timeout
- `WebhookVerificationException`: webhook 검증 실패

## 라이선스

MIT License
