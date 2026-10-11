# PHP 서버 샘플

이 디렉터리는 PortOne 공식 샘플 저장소의 Express, FastAPI, Flask, Next.js,
Spring Boot, Ruby on Rails 예제에서 사용하는 서버 결제 흐름을 구현합니다.

- `GET /api/item`: 샘플 상품을 반환합니다.
- `POST /api/payment/complete`: PHP SDK로 결제를 조회하고 검증합니다.
- `POST /api/payment/webhook`: 원본 request body를 검증하고 webhook 결제를
  동기화합니다.

참조 저장소의 프레임워크별 예제는 같은 서버 시나리오를 사용하므로, 이
저장소에서는 프레임워크가 없는 순수 PHP 구현 하나를 제공합니다.

## 실행

저장소 루트의 `.env.example`을 `.env`로 복사하고 test credential을 입력합니다.
샘플 서버는 개발 전용 `.env`를 자동으로 읽습니다. 실제 credential을 이
디렉터리에 넣거나 commit하지 마세요.

```sh
cp .env.example .env
# .env에 test credential 입력
php -S 127.0.0.1:8080 -t samples samples/index.php
```

`http://127.0.0.1:8080/`을 열어 샘플 서버를 확인할 수 있습니다. webhook
endpoint를 외부에 노출하려면 같은 port를 tunnel로 공개합니다. webhook URL은
`/api/payment/webhook`입니다.

credential 없이도 상품 endpoint는 사용할 수 있습니다. `PORTONE_API_SECRET`이
없는 API 요청과 `PORTONE_WEBHOOK_SECRET`이 없는 webhook 요청은 기본값이나
내장 secret을 사용하지 않고 통제된 오류를 반환합니다.
