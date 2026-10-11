# PRODUCT_SPEC.md

## Purpose

- The product is a PHP library named portone-php.
- The product is a PHP port of the PortOne V2 server SDK published at https://github.com/portone-io/server-sdk under the directory jvm.
- The product lets a PHP program call the PortOne V2 REST API.
- The product lets a PHP program verify PortOne V2 webhooks.

## Problem

- The official repository https://github.com/portone-io/server-sdk provides SDKs for JavaScript, JVM, and Python. It provides no PHP SDK.
- The previously existing unofficial PHP packages are deprecated or unmaintained.

## Product Goals

- The user can call every operation of the PortOne V2 REST API that the JVM SDK exposes, from PHP.
- The user can verify a PortOne V2 webhook and receive it as a typed object.
- The user can install the library with Composer.
- The user can build a separate package (for example, a Laravel integration package) on top of this library.

## Users

- PHP developer: a developer who installs portone-php with Composer and calls it from PHP code.

## Inputs

- apiSecret: PortOne V2 API Secret string, given when a client is constructed.
- webhookSecret: PortOne V2 webhook secret string, given when WebhookVerifier is constructed.
- Operation parameters: named parameters of each operation, in camelCase, matching the same-named operation in the JVM SDK.
- Webhook body: the raw request body as an unparsed string.
- msgId: value of the webhook-id header.
- msgSignature: value of the webhook-signature header.
- msgTimestamp: value of the webhook-timestamp header.

## Outputs

- Operation result: a typed PHP object representing the PortOne V2 REST API response.
- Async operation result: a typed Future object that can be waited on for the operation result.
- Webhook result: a typed PHP object representing the verified webhook, or an UnrecognizedWebhook object.
- Failure: a thrown exception (see Error Conditions).

## Constraints

- Supported PHP version: ^8.2.
- The library is pure PHP. It MUST NOT depend on any PHP framework.
- Package name: cable8mm/portone-php.
- Distribution: Composer, publicly available.
- License: MIT.
- Versioning: own version number, independent of the official SDK versions.
- PortOne API version: V2 only.
- Every operation has a synchronous method and an asynchronous counterpart.
- A synchronous method blocks until the response is received or a timeout occurs.
- An asynchronous counterpart starts the request and returns a Future without waiting for the response.
- Waiting on a Future returns the typed operation result or raises the same PortOneException as the synchronous method.
- Each HTTP request has a connection timeout of 10 seconds and a total timeout of 30 seconds.
- The library MUST NOT retry a failed HTTP request automatically.
- Root PHP namespace: None stated.
- Client configuration accepts apiSecret only. Webhook configuration accepts webhookSecret only.
- Persistence: none. The library keeps no data across processes.

## External Systems [UNVERIFIED]

- PortOne V2 REST API (default origin https://api.portone.io): relied on for every operation of the clients in FR-002 to FR-006.
- Official JVM SDK (https://github.com/portone-io/server-sdk, directory jvm): the reference for the set of clients, operations, operation parameters, per-operation exception names, and webhook types.
- PortOne documentation: the reference for operation behavior.
- Sample repository https://github.com/portone-io/portone-sample: the reference for the scenarios covered by the samples in FR-016.

## User Interface

- SCR: None. The product has no screen.
- The product has no command-line interface.
- The product interface is the public PHP API listed below.

### Public API elements

- EL-001: PortOneClient. Purpose: top-level client. User actions: construct with apiSecret; read the accessors payment, identityVerification, pgSpecific, auth, reconciliation, platform, b2b.
- EL-002: PaymentClient. Purpose: payment operations. User actions: construct with apiSecret; call payment operations; read the accessors billingKey, cashReceipt, additionalFeature, paymentSchedule, promotion.
- EL-003: BillingKeyClient. Purpose: billing key operations. User actions: construct with apiSecret; call its operations.
- EL-004: CashReceiptClient. Purpose: cash receipt operations. User actions: construct with apiSecret; call its operations.
- EL-005: AdditionalFeatureClient. Purpose: additional feature operations. User actions: construct with apiSecret; call its operations.
- EL-006: PaymentScheduleClient. Purpose: payment schedule operations. User actions: construct with apiSecret; call its operations.
- EL-007: PromotionClient. Purpose: promotion operations. User actions: construct with apiSecret; call its operations.
- EL-008: IdentityVerificationClient. Purpose: identity verification operations. User actions: construct with apiSecret; call its operations.
- EL-009: PgSpecificClient. Purpose: PG-specific operations. User actions: construct with apiSecret; call its operations.
- EL-010: AuthClient. Purpose: authentication operations. User actions: construct with apiSecret; call its operations.
- EL-011: ReconciliationClient. Purpose: reconciliation operations. User actions: construct with apiSecret; call its operations.
- EL-012: PlatformClient. Purpose: platform operations. User actions: construct with apiSecret; call its operations; read the accessors company, accountTransfer, policy, account, bulkAccountTransfer, bulkPayout, payout, partnerSettlement, partner, transfer.
- EL-013: CompanyClient, AccountTransferClient, PolicyClient, AccountClient, BulkAccountTransferClient, BulkPayoutClient, PayoutClient, PartnerSettlementClient, PartnerClient, TransferClient. Purpose: platform sub-clients. User actions: construct with apiSecret; call their operations.
- EL-014: B2bClient. Purpose: B2B operations. User actions: construct with apiSecret; call its operations; read the accessors taxInvoice, counterparty.
- EL-015: TaxInvoiceClient, CounterpartyClient. Purpose: B2B sub-clients. User actions: construct with apiSecret; call their operations.
- EL-016: WebhookVerifier. Purpose: webhook verification. User actions: construct with webhookSecret; call verify with body, msgId, msgSignature, msgTimestamp.
- EL-017: Webhook types. Purpose: typed representation of a verified webhook. User actions: check the type of the returned object; read its fields.
- EL-018: UnrecognizedWebhook. Purpose: representation of a webhook whose type this library version does not know. User actions: read the decoded body.
- EL-019: PortOneException and its subtypes. Purpose: failure reporting. User actions: catch by type; read the error data.
- EL-020: sample directory. Purpose: runnable PHP samples. User actions: read and run the samples.
- EL-021: Future. Purpose: represent an in-flight asynchronous operation. User actions: check completion and wait for a typed result or failure.

## Functional Requirements [UNVERIFIED]

- FR-001: The library MUST be installable with Composer under the package name cable8mm/portone-php.
- FR-002: PortOneClient MUST be constructible with apiSecret as its only configuration value.
- FR-003: PortOneClient MUST expose the accessors payment, identityVerification, pgSpecific, auth, reconciliation, platform, and b2b, returning the clients EL-002, EL-008, EL-009, EL-010, EL-011, EL-012, and EL-014.
- FR-004: PaymentClient MUST expose the accessors billingKey, cashReceipt, additionalFeature, paymentSchedule, and promotion, returning the clients EL-003 to EL-007.
- FR-005: PlatformClient MUST expose the accessors company, accountTransfer, policy, account, bulkAccountTransfer, bulkPayout, payout, partnerSettlement, partner, and transfer, returning the clients in EL-013.
- FR-006: B2bClient MUST expose the accessors taxInvoice and counterparty, returning the clients in EL-015.
- FR-007: Every client in EL-002 to EL-015 MUST be constructible on its own with apiSecret as its only configuration value.
- FR-008: Every client MUST expose one method for each operation of the same-named client in the JVM SDK.
- FR-009: Every operation method MUST use the operation name of the JVM SDK in camelCase.
- FR-010: Every operation method MUST accept the same named parameters as the same-named JVM SDK operation, in camelCase.
- FR-011: Every operation method MUST return a typed object representing the PortOne V2 REST API response.
- FR-012: Every operation method MUST send an authenticated request to the PortOne V2 REST API without the caller handling access tokens.
- FR-013: Every synchronous operation method MUST block until the response is received or a timeout occurs.
- FR-014: WebhookVerifier MUST be constructible with webhookSecret.
- FR-015: WebhookVerifier.verify MUST accept body (raw string), msgId, msgSignature, and msgTimestamp.
- FR-016: WebhookVerifier.verify MUST return a typed object for a verified webhook whose type this library version knows.
- FR-017: WebhookVerifier.verify MUST return an UnrecognizedWebhook for a verified webhook whose type this library version does not know.
- FR-018: UnrecognizedWebhook MUST expose the decoded body.
- FR-019: The repository MUST contain a directory named sample.
- FR-020: The sample directory MUST contain one PHP sample for each server-side scenario in https://github.com/portone-io/portone-sample.
- FR-021: The samples MUST be in the same repository as the library.
- FR-022: The library MUST use only apiSecret and webhookSecret as configuration values.
- FR-023: The library MUST apply a connection timeout of 10 seconds to every HTTP request.
- FR-024: The library MUST apply a total timeout of 30 seconds to every HTTP request.
- FR-025: The library MUST NOT retry a failed HTTP request.
- FR-026: Every operation method MUST have an asynchronous counterpart that starts one request and returns a Future without waiting for the response.
- FR-027: Future waiting MUST return the same typed result or raise the same PortOneException as the corresponding synchronous operation.

## User Flows

- Flow 1, call an operation: construct PortOneClient (EL-001) with apiSecret -> read an accessor -> call an operation method with its named parameters -> receive a typed object or catch a PortOneException.
- Flow 2, use one client only: construct a client from EL-002 to EL-015 with apiSecret -> call an operation method -> receive a typed object or catch a PortOneException.
- Flow 3, verify a webhook: construct WebhookVerifier with webhookSecret -> call verify with the raw body, msgId, msgSignature, and msgTimestamp -> receive a typed webhook object or an UnrecognizedWebhook, or catch a WebhookVerificationException.
- Flow 4, install: run Composer to require cable8mm/portone-php -> use the library classes.
- Flow 5, call an operation asynchronously: construct a client -> call an Async operation method -> receive a Future -> wait for a typed object or catch a PortOneException.

## Error Conditions [UNVERIFIED]

- ERR-001: apiSecret is an empty string at client construction -> the constructor MUST throw InvalidArgumentException.
- ERR-002: webhookSecret is an empty string at WebhookVerifier construction -> the constructor MUST throw InvalidArgumentException.
- ERR-003: The PortOne V2 REST API returns an error response that the JVM SDK defines for the operation -> the operation MUST throw the exception type named as in the JVM SDK for that operation, a subtype of PortOneException.
- ERR-004: The PortOne V2 REST API returns an error response that is not defined for the operation -> the operation MUST throw the UnknownException type of that operation, a subtype of PortOneException.
- ERR-005: The PortOne V2 REST API returns a success response that this library version cannot decode -> the operation MUST throw UnrecognizedResponseException, a subtype of PortOneException, carrying the HTTP status and the raw response body.
- ERR-006: A network failure, connection timeout, or total timeout occurs -> the operation MUST throw TransportException, a subtype of PortOneException.
- ERR-007: Webhook signature verification fails -> WebhookVerifier.verify MUST throw WebhookVerificationException, a subtype of PortOneException.
- ERR-008: PortOneException MUST extend RuntimeException.
- ERR-009: Waiting on a Future after a transport, API, decode, or operation failure -> the Future MUST raise the corresponding PortOneException.

## Non-Goals

- PortOne V1 REST API support.
- Laravel or any other framework integration.
- Configuration values other than apiSecret and webhookSecret.

## Acceptance Criteria

- AC-001: Running Composer to require cable8mm/portone-php on PHP 8.2 succeeds. Verifies FR-001.
- AC-002: PortOneClient constructed with apiSecret exposes the seven accessors of FR-003. Verifies FR-002, FR-003.
- AC-003: PaymentClient exposes the five accessors of FR-004. Verifies FR-004.
- AC-004: PlatformClient exposes the ten accessors of FR-005. Verifies FR-005.
- AC-005: B2bClient exposes the two accessors of FR-006. Verifies FR-006.
- AC-006: Each client in EL-002 to EL-015 constructs on its own with apiSecret. Verifies FR-007.
- AC-007: For each client, the set of operation method names equals the set of operation names of the same-named JVM SDK client, in camelCase. Verifies FR-008, FR-009.
- AC-008: For each operation, the named parameters equal those of the same-named JVM SDK operation. Verifies FR-010.
- AC-009: An operation call against a mocked PortOne V2 REST API returns a typed object whose fields equal the mocked response. Verifies FR-011, FR-012, FR-013.
- AC-010: WebhookVerifier.verify with a valid signature and a known type returns the typed object for that type. Verifies FR-014, FR-015, FR-016.
- AC-011: WebhookVerifier.verify with a valid signature and an unknown type returns an UnrecognizedWebhook exposing the decoded body. Verifies FR-017, FR-018.
- AC-012: The sample directory exists in the repository and contains one PHP sample for each server-side scenario in portone-sample. Verifies FR-019, FR-020, FR-021.
- AC-013: A client constructed with any configuration value other than apiSecret is rejected, and WebhookVerifier constructed with any value other than webhookSecret is rejected. Verifies FR-022.
- AC-014: A request to an unresponsive host fails with TransportException after the timeouts of FR-023 and FR-024, with exactly one attempt. Verifies FR-023, FR-024, FR-025, ERR-006.
- AC-015: Every operation has a synchronous method and an asynchronous counterpart; the asynchronous counterpart returns EL-021 without waiting for the response. Verifies FR-026.
- AC-016: Constructing a client with an empty apiSecret throws InvalidArgumentException. Verifies ERR-001.
- AC-017: Constructing WebhookVerifier with an empty webhookSecret throws InvalidArgumentException. Verifies ERR-002.
- AC-018: A mocked error response defined for an operation throws that operation's exception type. Verifies ERR-003, ERR-008.
- AC-019: A mocked error response not defined for an operation throws that operation's UnknownException. Verifies ERR-004.
- AC-020: A mocked success response that cannot be decoded throws UnrecognizedResponseException with the HTTP status and raw body. Verifies ERR-005.
- AC-021: WebhookVerifier.verify with an invalid signature throws WebhookVerificationException. Verifies ERR-007.
- AC-022: Waiting on every representative asynchronous operation returns the same typed result or raises the same exception as its synchronous counterpart. Verifies FR-027, ERR-009.
