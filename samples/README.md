# PHP 서버 샘플

이 디렉터리는 PortOne V2 서버 결제 흐름을 순수 PHP로 확인하는 샘플입니다. API의 전체 범위는 저장소 루트 README와 [PortOne V2 OpenAPI 문서](https://developers.portone.io/api/schema/v2/openapi.json)를 참고하세요.

- `GET /api/item`: 샘플 상품을 반환합니다.
- `POST /api/payment/complete`: PHP SDK로 결제를 조회하고 검증합니다.
- `POST /api/payment/webhook`: 원본 request body를 검증하고 webhook 결제를 동기화합니다.

참조 저장소의 프레임워크별 예제는 같은 서버 시나리오를 사용하므로, 이 저장소에서는 프레임워크가 없는 순수 PHP 구현 하나를 제공합니다.

## 실행

저장소 루트의 `.env.example`을 `.env`로 복사하고 test credential을 입력합니다.
샘플 서버는 개발 전용 `.env`를 자동으로 읽습니다. 실제 credential을 이 디렉터리에 넣거나 commit하지 마세요.

```sh
cp .env.example .env
# .env에 test credential 입력
composer serve
```

`composer serve`가 실행 중인 동안 `http://127.0.0.1:8080/`을 열어 샘플 서버를 확인할 수 있습니다. 이 명령은 루트 `.env`를 자동으로 읽습니다. webhook endpoint를 외부에 노출하려면 같은 port를 tunnel로 공개합니다. webhook URL은 `/api/payment/webhook`입니다.

```sh
curl http://127.0.0.1:8080/api/item

curl -X POST http://127.0.0.1:8080/api/payment/complete \
  -H 'Content-Type: application/json' \
  -d '{"paymentId":"<test-payment-id>"}'
```

첫 요청은 샘플 상품 JSON을 반환합니다. 두 번째 요청은 PortOne에서 payment를 조회한 뒤 `PAID` 또는 `VIRTUAL_ACCOUNT_ISSUED`인지 확인합니다. 실제 test payment ID가 없거나 API Secret이 없으면 오류 JSON이 반환됩니다.

## Webhook 확인

1. `composer serve`를 실행합니다.
2. 다른 terminal에서 `ngrok http 8080`을 실행합니다.
3. PortOne webhook endpoint를 `https://<ngrok-domain>/webhook-capture.php`로 등록합니다.
4. test webhook을 전송합니다.

검증에 성공하면 다음과 같은 JSON이 반환되고, 원본 body와 webhook header가 `tests/fixtures/live-webhook.json`에 기록됩니다.

```json
{
  "verified": true,
  "type": "Transaction.Paid",
  "fixtureRecorded": true
}
```

fixture를 기록한 뒤 저장소 루트에서 다음을 실행하면 known type, unknown type, body 변조, signature 변조를 확인할 수 있습니다.

```sh
php tools/portone_webhook_probe.php
php tools/portone_boundary_probe.php
```

`live-webhook.json`은 테스트 관찰 자료이므로 secret과 함께 commit하지 마세요.

credential 없이도 상품 endpoint는 사용할 수 있습니다. `PORTONE_API_SECRET`이 없는 API 요청과 `PORTONE_WEBHOOK_SECRET`이 없는 webhook 요청은 기본값이나 내장 secret을 사용하지 않고 통제된 오류를 반환합니다.
