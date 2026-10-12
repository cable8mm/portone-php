# PortOne PHP

[![CI](https://github.com/cable8mm/portone-php/actions/workflows/ci.yml/badge.svg)](https://github.com/cable8mm/portone-php/actions/workflows/ci.yml)
[![update-changelog](https://github.com/cable8mm/portone-php/actions/workflows/update-changelog.yml/badge.svg)](https://github.com/cable8mm/portone-php/actions/workflows/update-changelog.yml)
[![PHP Version](https://img.shields.io/packagist/php-v/cable8mm/portone-php.svg)](https://packagist.org/packages/cable8mm/portone-php)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/cable8mm/portone-php.svg)](https://packagist.org/packages/cable8mm/portone-php)
[![License](https://img.shields.io/github/license/cable8mm/portone-php.svg)](https://github.com/cable8mm/portone-php/blob/main/LICENSE)

PortOne V2 REST API용 PHP 서버 SDK입니다. 공식 OpenAPI 명세의 전체 operation을 PHP에서 호출할 수 있으며, PortOne webhook 서명 검증과 비동기 operation도 지원합니다.

- Composer 패키지: `cable8mm/portone-php`
- PHP: `^8.2`
- HTTP: Guzzle 8
- 네임스페이스: `Cable8mm\PortonePhp`
- 라이선스: MIT

## 지원 범위

이 패키지의 API 범위와 요청·응답 스키마의 기준은 [PortOne V2 OpenAPI 문서](https://developers.portone.io/api/schema/v2/openapi.json)입니다.

- 115개 path, 147개 operation
- 모든 operation에 동기 메서드와 `Async` 메서드 제공
- 응답은 PHP typed response object로 decode
- `PortOneException` 계열로 API, transport, decode, webhook 오류 전달
- `PortOneClient`의 `payment`, `identityVerification`, `pgSpecific`, `auth`, `reconciliation`, `platform`, `b2b`, `common`, `checkout`, `paymentSession` accessor 제공

명세에 없는 operation이나 V1 API는 지원 범위가 아닙니다.

## 패키지 구조

이 패키지는 MVC 프레임워크의 HTTP 응답 구조가 아니라 PortOne API 스키마를 기준으로 구성됩니다.

- `Client`: PortOne API 호출 클라이언트
- `Model`: API 응답과 중첩 데이터 객체
- `Async`: 비동기 호출 결과
- `Webhook`: 웹훅 검증과 데이터 객체
- `Exception`: 예외
- `Http`: HTTP 전송 처리

`Model`에는 최상위 응답 객체와 여러 응답에서 재사용되는 중첩 객체가 함께 포함될 수 있습니다.

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

이 저장소는 `composer.lock`을 커밋하지 않습니다. 개발 환경에서 Composer가 생성한 lockfile은 `.gitignore` 대상입니다.

## 기본 사용법

라이브러리 자체는 환경변수를 읽지 않습니다. 애플리케이션이 secret을 읽어 생성자에 전달해야 합니다.

### 동기 operation

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Cable8mm\PortonePhp\Client\PortOneClient;

$apiSecret = $config['apiSecret'];
$client = new PortOneClient($apiSecret);
$payment = $client->payment->getPayment($paymentId);

var_dump($payment->data);
```

모든 operation은 OpenAPI `operationId`의 camelCase 이름을 사용하며, 동기 메서드와 `Async` 접미사가 붙은 비동기 메서드를 함께 제공합니다.

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

`wait()`는 동기 operation과 같은 typed response를 반환하며, 같은 `PortOneException` 계열 예외를 발생시킵니다. HTTP 요청은 connection timeout 10초, total timeout 30초이며 자동 재시도를 하지 않습니다.

### Webhook 검증

Webhook은 JSON으로 decode하기 전에 반드시 원본 request body를 검증해야 합니다.

```php
$body = file_get_contents('php://input');
$headers = getallheaders();

$verifier = new \Cable8mm\PortonePhp\Webhook\WebhookVerifier($webhookSecret);
$webhook = $verifier->verify(
    $body,
    $headers['webhook-id'] ?? null,
    $headers['webhook-signature'] ?? null,
    $headers['webhook-timestamp'] ?? null,
);

if ($webhook instanceof \Cable8mm\PortonePhp\Webhook\WebhookTransactionPaid) {
    $paymentId = $webhook->data->paymentId;
}
```

지원하지 않는 webhook type은 실패하지 않고 `UnrecognizedWebhook`으로 반환됩니다. 서명이 올바르지 않거나 timestamp가 허용 범위를 벗어나면 `WebhookVerificationException`이 발생합니다.

## 로컬 개발 환경

### Secret 설정

SDK 본체는 환경변수를 읽지 않습니다. 개발용 E2E runner와 `samples/`의 로컬 서버만 `vlucas/phpdotenv`를 사용해 `.env`를 읽습니다. `.env`는 Git에 포함되지 않습니다.

```sh
cp .env.example .env
```

`.env`를 열고 test store의 값을 입력합니다.

```dotenv
PORTONE_API_SECRET=여기에_API_Secret
PORTONE_WEBHOOK_SECRET=whsec_여기에_Webhook_Secret

# 결제·빌링키 lifecycle E2E에 필요한 test store 설정
PORTONE_E2E_CHANNEL_KEY=여기에_테스트_채널키
PORTONE_E2E_CHANNEL_GROUP_ID=여기에_스마트_라우팅_채널그룹_ID
PORTONE_E2E_STORE_ID=여기에_테스트_상점아이디
PORTONE_E2E_CARD_NUMBER=여기에_테스트_카드번호
PORTONE_E2E_CARD_EXPIRY_YEAR=유효기간_연도_2자리
PORTONE_E2E_CARD_EXPIRY_MONTH=유효기간_월_2자리
PORTONE_E2E_BIRTH_OR_BUSINESS_NUMBER=생년월일_6자리_또는_사업자번호_10자리
PORTONE_E2E_PASSWORD_TWO_DIGITS=카드비밀번호_앞_2자리
```

Secret을 README, source, fixture, 로그에 넣거나 commit하지 마세요.

### E2E 키를 얻는 방법

위 설정은 SDK 본체가 읽지 않고, 개발용 live E2E probe만 읽습니다. 모든 값은 테스트 환경의 값만 사용하세요.

| 변수 | 얻는 위치와 용도 |
| --- | --- |
| `PORTONE_API_SECRET` | PortOne 관리자 콘솔의 `결제 연동 → 연동 관리 → 식별코드·API Keys`에서 V2 API Secret을 발급합니다. 서버와 `.env`에서만 사용합니다. |
| `PORTONE_WEBHOOK_SECRET` | 관리자 콘솔의 테스트 webhook 설정에서 확인합니다. Webhook E2E와 `WebhookVerifier` 검증에 사용합니다. |
| `PORTONE_E2E_STORE_ID` | 관리자 콘솔의 `결제 연동 → 연동 관리`에서 테스트 상점 ID를 복사합니다. |
| `PORTONE_E2E_CHANNEL_KEY` | `결제 연동 → 연동 정보`를 테스트 모드로 전환한 뒤 등록된 테스트 결제 채널의 채널 키를 복사합니다. `payInstantly`와 billing-key 결제에 사용합니다. |
| `PORTONE_E2E_CHANNEL_GROUP_ID` | `연동 관리 → 스마트 라우팅`에서 테스트 그룹을 생성하고, 저장 후 자동으로 생성된 그룹 ID를 복사합니다. billing-key 발급 시 `channelGroupId`로 사용합니다. |
| `PORTONE_E2E_CARD_NUMBER` | 선택한 테스트 PG가 제공하는 테스트 카드 번호입니다. 실제 카드 번호를 사용하지 않습니다. |
| `PORTONE_E2E_CARD_EXPIRY_YEAR` / `PORTONE_E2E_CARD_EXPIRY_MONTH` | 위 테스트 카드의 유효기간입니다. 연도와 월을 각각 2자리로 입력합니다. |
| `PORTONE_E2E_BIRTH_OR_BUSINESS_NUMBER` | PG 테스트 카드가 요구하는 생년월일 `YYMMDD` 6자리 또는 사업자등록번호 10자리입니다. |
| `PORTONE_E2E_PASSWORD_TWO_DIGITS` | PG 테스트 카드가 요구하는 카드 비밀번호 앞 2자리입니다. PG가 요구하지 않으면 비워둘 수 있습니다. |

`PORTONE_E2E_CHANNEL_GROUP_ID`는 PG에서 발급하는 정기자동결제 그룹 ID나 PG 상점 ID가 아닙니다. PortOne의 스마트 라우팅 그룹을 테스트 환경에서 생성한 뒤 PortOne이 자동으로 만든 ID입니다. 채널 그룹을 사용하지 않는 일반 결제는 `PORTONE_E2E_CHANNEL_KEY`를 사용합니다.

Billing key 자체는 `.env`에 직접 넣지 않습니다. billing-key lifecycle 테스트는 테스트 카드와 `PORTONE_E2E_CHANNEL_GROUP_ID`로 매번 발급한 값을 메모리에만 보관하고, 결제·취소 검증이 끝나면 삭제해야 합니다.

## 테스트

### 단위 테스트와 형식 검사

```sh
composer validate --no-check-publish
composer lint
composer test
```

전체 PHPUnit 테스트에는 client hierarchy, operation 계약, sync/async 요청, 오류 분류, webhook 검증, samples 내부 로직이 포함됩니다.

### OpenAPI 계약 검증

operation·path·parameter·응답 스키마의 계약 검증은 OpenAPI fixture를 대상으로 실행합니다.

```sh
composer openapi:check
composer openapi:signatures
```

## Live E2E 테스트

Live E2E는 실제 `https://api.portone.io`와 실제 webhook secret을 사용합니다.
따라서 test store/API Secret을 사용하고, 결과에 secret을 출력하지 마세요.

### API와 transport E2E

`.env`의 값을 자동으로 로드하려면 다음 명령 하나로 모든 live probe를 실행합니다.

```sh
composer e2e
```

`composer e2e`는 개발 전용 `vlucas/phpdotenv`로 `.env`를 읽은 뒤 각 probe를 별도 PHP 프로세스로 실행합니다. SDK 본체나 production runtime에는 dotenv가 들어가지 않습니다. API Secret은 출력하지 않습니다.

`composer e2e`에는 OpenAPI 전체 matrix probe도 포함됩니다. 이 probe는 OpenAPI의 147개 operation을 각각 실제 API에 호출하고, `tests/fixtures/portone-v2-openapi-matrix-observations.json`에 operation별 JSON 결과를 기록합니다. 입력을 생략할 수 있는 operation은 test store를 변경하지 않도록 빈 입력으로 호출합니다. API가 반환한 `InvalidRequestException`, `PlatformNotEnabledException`, `UnknownException` 등은 `controlled-failure`로 기록되며, 로컬 PHP 오류나 operation 누락은 probe 실패입니다. 정상적인 결과의 요약은 다음과 같습니다.

```text
status=observed
operationCount=147
observedCount=147
missingOperations=0
localFailures=0
```

일부 operation은 test store의 기능 활성화 여부나 존재하지 않는 resource에 따라 `InvalidRequestException`, `PlatformNotEnabledException`, `UnknownException`을 기록할 수 있습니다. 이것은 probe가 의도한 controlled failure이며, 스크립트가 성공적으로 종료되고 JSON 결과를 기록하는지 확인해야 합니다.

### 결제 성공 응답 lifecycle E2E

147개 matrix는 빈 입력으로 operation을 호출하므로, 실제 결제 성공 응답의 typed model을 확인하지 않습니다. 결제 성공 응답까지 확인하려면 `.env`에 `.env.example`의 `PORTONE_E2E_*` 설정을 입력한 뒤 다음 명령을 실행합니다.

```sh
composer e2e:payment-lifecycle
```

이 probe는 test store에 1,004원 카드 결제를 생성하고 다음 순서로 확인합니다.

1. `payInstantly`가 `PayInstantlyResponse`와 `InstantPaymentSummary`를 반환하는지 확인합니다.
2. `getPayment`가 생성된 결제를 `Payment` 모델로 반환하고 상태가 `PAID`인지 확인합니다.
3. `cancelPayment`가 `CancelPaymentResponse`와 `PaymentCancellation`을 반환하는지 확인합니다.
4. `getPaymentAsync`로 최종 상태가 `CANCELLED`인지 확인합니다.

결제 생성과 취소가 실제 test store에서 실행되므로 운영 secret이나 운영 카드 정보를 사용하지 마세요. 웹훅은 생성하지 않도록 `skipWebhook=true`로 실행합니다. 카드번호와 secret은 출력하거나 저장하지 않으며, 관찰 결과는 다음 fixture에 typed model 이름과 상태만 기록합니다.

```text
tests/fixtures/payment-lifecycle-boundary-observations.json
```

`PORTONE_E2E_BIRTH_OR_BUSINESS_NUMBER`는 생년월일 `YYMMDD` 6자리 또는 사업자등록번호 10자리여야 합니다. 테스트 PG가 요구하는 경우에만 `PORTONE_E2E_PASSWORD_TWO_DIGITS`를 입력합니다. 실행에 실패한 결제 시도가 test store에 남을 수 있으므로, 결과를 확인한 뒤 PortOne 관리자에서 미완료 테스트 결제를 정리하세요.

### Webhook E2E와 ngrok

1. PHP sample 서버를 실행합니다.

   ```sh
   composer serve
   ```

2. 다른 terminal에서 ngrok을 실행합니다.

   ```sh
   ngrok http 8080
   ```

3. PortOne 관리자 콘솔의 webhook endpoint를 다음 주소로 등록합니다.

   ```text
   https://<ngrok-domain>/webhook-capture.php
   ```

   `webhook-capture.php`는 raw body와 세 webhook header를 `WebhookVerifier`로 검증한 뒤, 성공한 요청을
   `tests/fixtures/live-webhook.json`에 기록합니다. 잘못된 서명은 400으로 거부됩니다.

4. PortOne에서 test webhook을 전송하거나 test 결제를 진행합니다. 응답에 다음과 같은 결과가 나오면 capture가 성공한 것입니다.

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

   `portone_webhook_probe.php`는 known webhook, unknown webhook, raw body 변조, signature 변조를 확인합니다. `portone_boundary_probe.php`는 timestamp tolerance와 live signature 규칙을 추가로 확인합니다.

   capture fixture의 원래 timestamp가 오래된 경우에도 probe는 캡처된 live body를 보존하면서 현재 timestamp로 검증용 signature를 재생성합니다.
   실제 webhook endpoint 검증에서는 PortOne이 보낸 원본 timestamp가 그대로 사용됩니다.

### 결제 스케줄 + Webhook lifecycle E2E

결제 스케줄이 실행될 때 PortOne이 실제로 webhook을 발송하고, `WebhookVerifier`로 검증한 뒤 스케줄이 생성한 결제를 typed model로 조회·취소하는 전 과정을 검증합니다.

1. PHP sample 서버를 실행합니다.

   ```sh
   php -S 0.0.0.0:8899 -t samples/
   ```

2. 다른 terminal에서 ngrok을 실행합니다.

   ```sh
   ngrok http 8899
   ```

3. PortOne 관리자 콘솔의 webhook endpoint를 다음 주소로 등록합니다.

   ```text
   https://<ngrok-domain>/webhook-capture.php
   ```

4. probe를 실행합니다. ngrok이 실행 중이면 공개 URL을 자동으로 감지합니다.

   ```sh
   php tools/portone_payment_schedule_probe.php
   ```

   수동으로 URL을 지정할 수도 있습니다.

   ```sh
   php tools/portone_payment_schedule_probe.php https://<ngrok-domain>/webhook-capture.php
   ```

   probe는 다음 순서로 실행됩니다.

   1. 빌링키 발급
   2. 결제 스케줄 생성 → `getPaymentSchedule`로 `SCHEDULED` 상태 확인 → `revokePaymentSchedules`로 취소 → `getPaymentScheduleAsync`로 `REVOKED` 상태 확인
   3. 약 2분 10초 후 실행되는 결제 스케줄 생성
   4. PortOne이 스케줄을 실행하고 webhook을 발송하면 `webhook-capture.php`가 수신
   5. `WebhookVerifier`로 webhook 서명 검증 → typed `WebhookTransactionPaid` 확인
   6. 스케줄이 생성한 결제를 `getPayment`로 typed `Payment` (PAID) 조회
   7. `cancelPayment`로 결제 취소 → typed `CancelPaymentResponse` 확인

   성공하면 다음 fixture에 모든 operation 결과를 기록합니다.

   ```text
   tests/fixtures/payment-schedule-boundary-observations.json
   ```

   webhook 수신 대기는 스케줄 실행 후 최대 90초이며, 그 사이 `tests/fixtures/live-webhook.json`을 5초 간격으로 폴링합니다. 기존 live-webhook.json에 다른 paymentId가 있으면 덮어쓰기 전까지 대기합니다. 결과에 secret, 카드번호, billing key 값은 포함하지 않습니다.

### PHP sample E2E

먼저 별도 terminal에서 `composer serve`로 샘플 HTTP 서버를 실행합니다. 이 명령이 실행 중인 동안에만 아래 HTTP 요청을 보낼 수 있습니다.

서버가 실행된 상태에서 다른 터미널로 다음 요청을 보내 응답을 확인할 수 있습니다.

```sh
curl http://127.0.0.1:8080/api/item

curl -X POST http://127.0.0.1:8080/api/payment/complete \
  -H 'Content-Type: application/json' \
  -d '{"paymentId":"<test-payment-id>"}'
```

상품 endpoint는 secret 없이도 확인할 수 있습니다. 결제 complete endpoint는 `.env`의 `PORTONE_API_SECRET`으로 PortOne에 결제를 조회하므로, 실제 test payment ID가 필요합니다. 성공하면 결제 상태 JSON을 반환하고, secret 누락·결제 조회 실패·완료되지 않은 결제는 오류 JSON을 반환합니다.

Webhook URL은 다음과 같습니다.

```text
POST /api/payment/webhook
```

샘플의 상세 설명은 [samples/README.md](samples/README.md)를 참고하세요.

## CI

GitHub Actions는 push와 pull request마다 PHP 8.2, 8.3, 8.4, 8.5 각각에 대해 다음을 실행합니다.

```sh
composer install --no-interaction --prefer-dist
composer lint
composer test
```

문서에 적힌 개발 환경을 처음부터 확인하려면 저장소를 새 디렉터리에 checkout한 뒤 다음을 순서대로 실행합니다.

```sh
composer install --no-interaction --prefer-dist
composer validate --no-check-publish
composer lint
composer test
```

실제 API와 webhook까지 확인하려면 `.env`를 작성한 뒤 `composer e2e`를 추가로 실행합니다.

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
