# PHP server sample

This directory implements the server-side payment flow used by the current
PortOne sample repository's Express, FastAPI, Flask, Next.js, Spring Boot, and
Ruby on Rails examples:

- `GET /api/item` returns the sample item.
- `POST /api/payment/complete` retrieves and validates a payment with the PHP SDK.
- `POST /api/payment/webhook` verifies the raw request body and synchronizes a payment webhook.

The framework variants in the reference repository have the same server-side
scenario, so this repository provides one framework-free PHP implementation.

## Run

Set secrets in the process environment. Do not put real credentials in this
directory or commit them.

```sh
export PORTONE_API_SECRET='your-api-secret'
export PORTONE_WEBHOOK_SECRET='whsec_your-webhook-secret'
php -S 127.0.0.1:8080 -t samples samples/index.php
```

Open `http://127.0.0.1:8080/` or expose the same port with a tunnel for a
webhook endpoint. The webhook URL is `/api/payment/webhook`.

The sample also works without credentials for its item endpoint. API calls
without `PORTONE_API_SECRET` and webhook calls without
`PORTONE_WEBHOOK_SECRET` return a controlled error instead of using a default
or embedded secret.
