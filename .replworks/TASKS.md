# TASKS.md

- [X] T-001 Project foundation
  - Satisfies: PRODUCT_SPEC.md FR-001
  - External boundary: no
  - Acceptance criteria:
    - All constraints and verification commands defined in TECH_STACK.md pass on the supported PHP versions.
    - Installing the package with Composer under the package name required by PRODUCT_SPEC.md succeeds on PHP 8.2.
    - The package exposes the PSR-4 public namespace and contains no committed lockfile or secret values.

- [X] T-002 JVM operation catalog and model contract verification
  - Satisfies: PRODUCT_SPEC.md EL-021, FR-008, FR-009, FR-010, FR-026, ERR-003, ERR-004
  - External boundary: yes
  - Acceptance criteria:
    - An executable probe against the JVM SDK at tag jvm-v0.24.0 records every client, operation name, camelCase operation name, named parameter, defined error name, and webhook type required by PRODUCT_SPEC.md EL-002 to EL-017.
    - The probe records the JVM asynchronous counterpart for every operation and excludes no Future capability from the reference contract.
    - The recorded operation and parameter sets are available to the dependent implementation tasks and the probe fails when the PHP public set differs from the recorded JVM set.
    - The probe records the JVM SDK's success decoding, error classification, and unknown-value behavior required by ARCHITECTURE.md RD-03 and RD-04.

- [X] T-003 PortOne API and webhook boundary behavior verification
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-015, FR-016, FR-017, FR-018, ERR-003, ERR-004, ERR-005, ERR-006, ERR-007
  - External boundary: yes
  - Acceptance criteria:
    - A live probe against the PortOne V2 REST API records the authenticated request form, representative success response, defined error response, unknown error response, undecodable success response, transport failure, and timeout behavior required by ARCHITECTURE.md.
    - A live webhook probe records the verification inputs, signature format, timestamp handling, known type result, unknown type result, invalid signature failure, and raw-body handling required by ARCHITECTURE.md.
    - Each recorded result has an executable pass/fail check, and the task remains incomplete if the live PortOne boundary is unreachable.

- [X] T-004 End-to-end authenticated operation outcome
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-013, FR-023, FR-024, FR-025, FR-026, FR-027, ERR-003, ERR-004, ERR-005, ERR-006, ERR-008, ERR-009
  - External boundary: yes
  - Acceptance criteria:
    - A synchronous public operation sends exactly one authenticated request through the Request Executor and returns the typed result for the observed live success behavior.
    - The live E2E check observes the required authentication header, connection timeout, total timeout, and no-retry behavior.
    - The operation raises the observed defined error, UnknownException, UnrecognizedResponseException, or TransportException behavior as applicable, and every raised failure descends from PortOneException.
    - The asynchronous counterpart starts one request without waiting, returns a Future, and waiting on it applies the same typed decoding and failure behavior as the synchronous operation.
    - Unit tests pass for request construction, outcome classification, typed decoding, failure propagation, and the invariant that one failed call does not affect a later call.

- [X] T-005 Client construction and accessor hierarchy
  - Satisfies: PRODUCT_SPEC.md FR-002, FR-003, FR-004, FR-005, FR-006, FR-007, FR-022, ERR-001
  - External boundary: no
  - Acceptance criteria:
    - PortOneClient exposes exactly the seven accessors in EL-001, with the required child clients.
    - PaymentClient exposes exactly the five accessors in EL-002, PlatformClient exposes exactly the ten accessors in EL-012, and B2bClient exposes exactly the two accessors in EL-014.
    - Every client in EL-002 to EL-015 constructs with apiSecret as its only configuration value and a parent and all children share one Request Executor.
    - An empty apiSecret raises InvalidArgumentException before any request is made.
    - No public client accepts or retains configuration values other than apiSecret.
    - Unit tests pass for all accessors, standalone construction, shared executor identity, and construction failure.

- [X] T-006 Payment operations
  - Satisfies: PRODUCT_SPEC.md EL-002, EL-003, EL-004, EL-005, EL-006, EL-007 and FR-008, FR-009, FR-010, FR-011, FR-026, FR-027
  - External boundary: yes
  - Acceptance criteria:
    - PaymentClient, BillingKeyClient, CashReceiptClient, AdditionalFeatureClient, PaymentScheduleClient, and PromotionClient expose exactly the operations and named parameters recorded from the JVM SDK.
    - Each operation uses the documented PortOne V2 path and request shape and returns the documented typed result for the observed live success behavior.
    - E2E checks exercise at least one operation in each client through the live PortOne boundary and pass the applicable failure behavior defined in ARCHITECTURE.md.
    - Unit tests pass for every operation definition and for representative request, response, defined-error, unknown-error, and undecodable-success cases.
    - Unit tests pass for every asynchronous counterpart and verify that waiting resolves the same typed result or failure as the synchronous operation.

- [X] T-007 Identity verification operations
  - Satisfies: PRODUCT_SPEC.md EL-008 and FR-008, FR-009, FR-010, FR-011, FR-026, FR-027
  - External boundary: yes
  - Acceptance criteria:
    - IdentityVerificationClient exposes exactly the JVM operation and parameter set.
    - Each operation returns the documented typed result for the observed live success behavior and uses the documented request shape.
    - A live E2E check exercises the client and passes the applicable failure behavior defined in ARCHITECTURE.md.
    - Unit tests pass for every operation definition and representative outcome classifications.
    - Unit tests pass for every asynchronous counterpart and verify equivalent result and failure behavior.

- [X] T-008 PG-specific operations
  - Satisfies: PRODUCT_SPEC.md EL-009 and FR-008, FR-009, FR-010, FR-011, FR-026, FR-027
  - External boundary: yes
  - Acceptance criteria:
    - PgSpecificClient exposes exactly the JVM operation and parameter set.
    - Each operation returns the documented typed result for the observed live success behavior and uses the documented request shape.
    - A live E2E check exercises the client and passes the applicable failure behavior defined in ARCHITECTURE.md.
    - Unit tests pass for every operation definition and representative outcome classifications.
    - Unit tests pass for every asynchronous counterpart and verify equivalent result and failure behavior.

- [X] T-009 Authentication operations
  - Satisfies: PRODUCT_SPEC.md EL-010 and FR-008, FR-009, FR-010, FR-011, FR-026, FR-027
  - External boundary: yes
  - Acceptance criteria:
    - AuthClient exposes exactly the JVM operation and parameter set and treats those operations as ordinary authenticated operations.
    - Each operation returns the documented typed result for the observed live success behavior and uses the documented request shape.
    - A live E2E check exercises the client and passes the applicable failure behavior defined in ARCHITECTURE.md.
    - Unit tests pass for every operation definition and representative outcome classifications.
    - Unit tests pass for every asynchronous counterpart and verify equivalent result and failure behavior.

- [X] T-010 Reconciliation operations
  - Satisfies: PRODUCT_SPEC.md EL-011 and FR-008, FR-009, FR-010, FR-011, FR-026, FR-027
  - External boundary: yes
  - Acceptance criteria:
    - ReconciliationClient exposes exactly the JVM operation and parameter set.
    - Each operation returns the documented typed result for the observed live success behavior and uses the documented request shape.
    - A live E2E check exercises the client and passes the applicable failure behavior defined in ARCHITECTURE.md.
    - Unit tests pass for every operation definition and representative outcome classifications.
    - Unit tests pass for every asynchronous counterpart and verify equivalent result and failure behavior.

- [X] T-011 Platform core operations
  - Satisfies: PRODUCT_SPEC.md EL-012, EL-013 and FR-005, FR-008, FR-009, FR-010, FR-011, FR-026, FR-027
  - External boundary: yes
  - Acceptance criteria:
    - PlatformClient, CompanyClient, AccountClient, and AccountTransferClient expose exactly the JVM operation and parameter sets.
    - Each operation returns the documented typed result for the observed live success behavior and uses the documented request shape.
    - A live E2E check exercises each client and passes the applicable failure behavior defined in ARCHITECTURE.md.
    - Unit tests pass for every operation definition and representative outcome classifications.
    - Unit tests pass for every asynchronous counterpart and verify equivalent result and failure behavior.

- [X] T-012 Platform bulk and payout operations
  - Satisfies: PRODUCT_SPEC.md EL-013 and FR-008, FR-009, FR-010, FR-011, FR-026, FR-027
  - External boundary: yes
  - Acceptance criteria:
    - BulkAccountTransferClient, BulkPayoutClient, and PayoutClient expose exactly the JVM operation and parameter sets.
    - Each operation returns the documented typed result for the observed live success behavior and uses the documented request shape.
    - A live E2E check exercises each client and passes the applicable failure behavior defined in ARCHITECTURE.md.
    - Unit tests pass for every operation definition and representative outcome classifications.
    - Unit tests pass for every asynchronous counterpart and verify equivalent result and failure behavior.

- [X] T-013 Platform partner and transfer operations
  - Satisfies: PRODUCT_SPEC.md EL-013 and FR-008, FR-009, FR-010, FR-011, FR-026, FR-027
  - External boundary: yes
  - Acceptance criteria:
    - PartnerSettlementClient, PartnerClient, and TransferClient expose exactly the JVM operation and parameter sets.
    - Each operation returns the documented typed result for the observed live success behavior and uses the documented request shape.
    - A live E2E check exercises each client and passes the applicable failure behavior defined in ARCHITECTURE.md.
    - Unit tests pass for every operation definition and representative outcome classifications.
    - Unit tests pass for every asynchronous counterpart and verify equivalent result and failure behavior.

- [X] T-014 Platform policy operations
  - Satisfies: PRODUCT_SPEC.md EL-013 and FR-008, FR-009, FR-010, FR-011, FR-026, FR-027
  - External boundary: yes
  - Acceptance criteria:
    - PolicyClient exposes exactly the JVM operation and parameter set.
    - Each operation returns the documented typed result for the observed live success behavior and uses the documented request shape.
    - A live E2E check exercises the client and passes the applicable failure behavior defined in ARCHITECTURE.md.
    - Unit tests pass for every operation definition and representative outcome classifications.
    - Unit tests pass for every asynchronous counterpart and verify equivalent result and failure behavior.

- [X] T-015 B2B tax invoice operations
  - Satisfies: PRODUCT_SPEC.md EL-014, EL-015 and FR-006, FR-008, FR-009, FR-010, FR-011, FR-026, FR-027
  - External boundary: yes
  - Acceptance criteria:
    - B2bClient and TaxInvoiceClient expose exactly the JVM operation and parameter sets.
    - Each operation returns the documented typed result for the observed live success behavior and uses the documented request shape.
    - A live E2E check exercises each client and passes the applicable failure behavior defined in ARCHITECTURE.md.
    - Unit tests pass for every operation definition and representative outcome classifications.
    - Unit tests pass for every asynchronous counterpart and verify equivalent result and failure behavior.

- [X] T-016 B2B counterparty operations
  - Satisfies: PRODUCT_SPEC.md EL-014, EL-015 and FR-006, FR-008, FR-009, FR-010, FR-011, FR-026, FR-027
  - External boundary: yes
  - Acceptance criteria:
    - CounterpartyClient exposes exactly the JVM operation and parameter set.
    - Each operation returns the documented typed result for the observed live success behavior and uses the documented request shape.
    - A live E2E check exercises the client and passes the applicable failure behavior defined in ARCHITECTURE.md.
    - Unit tests pass for every operation definition and representative outcome classifications.
    - Unit tests pass for every asynchronous counterpart and verify equivalent result and failure behavior.

- [X] T-017 Webhook verification and typed results
  - Satisfies: PRODUCT_SPEC.md EL-016, EL-017, EL-018 and FR-014, FR-015, FR-016, FR-017, FR-018, ERR-002, ERR-007
  - External boundary: yes
  - Acceptance criteria:
    - WebhookVerifier constructs with webhookSecret as its only configuration value and an empty webhookSecret raises InvalidArgumentException without decoding or making a request.
    - verify accepts the raw body, msgId, msgSignature, and msgTimestamp values required by PRODUCT_SPEC.md and preserves the raw body through verification.
    - A live E2E check with a valid signature returns the typed known webhook result, while a valid unknown type returns UnrecognizedWebhook exposing the decoded body.
    - A live E2E check with invalid verification data raises WebhookVerificationException and never decodes an unverified body.
    - Unit tests pass for all recorded JVM verification cases, known and unknown webhook types, raw-body changes, and failure cases.

- [X] T-018 Runnable server-side samples
  - Satisfies: PRODUCT_SPEC.md EL-020 and FR-019, FR-020, FR-021
  - External boundary: yes
  - Acceptance criteria:
    - The repository contains the sample directory required by PRODUCT_SPEC.md.
    - It contains one runnable PHP sample for every server-side scenario in the referenced PortOne sample repository, with no literal real secrets.
    - Each sample reads the required secret from the process environment and uses only the public SDK interface.
    - A verification run executes every sample with test credentials or a documented non-secret fixture and observes the expected success or controlled failure behavior.

- [X] T-019 Complete public API and packaging verification
  - Satisfies: PRODUCT_SPEC.md FR-001, FR-002, FR-007, FR-008, FR-009, FR-010, FR-011, FR-013, FR-022, FR-026, FR-027 and AC-001 to AC-022
  - External boundary: yes
  - Acceptance criteria:
    - The full automated test suite and all format checks defined in TECH_STACK.md pass on every supported CI PHP version.
    - A clean Composer installation exposes every public element in EL-001 to EL-021, including synchronous and asynchronous operation methods.
    - JVM catalog comparison passes for every client, operation, named parameter, defined error, and webhook type.
    - Live E2E checks pass for authenticated operations, timeout and no-retry behavior, defined and unknown failures, unrecognized success, webhook verification, known webhooks, unknown webhooks, and samples.
    - Representative asynchronous operations start without waiting and resolve to the same typed results or failures as their synchronous counterparts.
    - No acceptance criterion in PRODUCT_SPEC.md remains unverified.

- [X] T-020 JVM response schema comparison
  - Satisfies: PRODUCT_SPEC.md FR-011, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - An executable probe against the JVM SDK at tag jvm-v0.24.0 records every generated response model's fields and declared Kotlin types.
    - The probe compares the recorded JVM response models with PHP response classes by class name and constructor property name.
    - The probe reports missing PHP response classes, missing PHP fields, unexpected PHP fields, and response classes that currently expose only an untyped raw data array.
    - The recorded JVM schema and comparison result are reproducible from the local JVM path configured in `.env`.
    - Unit tests pass for the comparison parser and the probe exits non-zero when a known response model does not match.
    - The comparison report is explicitly treated as an intermediate JVM compatibility check; PortOne V2 documentation remains the final authority for response schemas.

- [X] T-021 Authentication response DTOs
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - `LoginViaApiSecretResponse` exposes typed `accessToken` and `refreshToken` fields matching the JVM response model.
    - `RefreshTokenResponse` exposes typed `accessToken` and `refreshToken` fields matching the JVM response model.
    - Both response classes reject missing or non-string required fields with a decode failure that becomes `UnrecognizedResponseException` at the operation boundary.
    - Extra response fields are ignored consistently with the recorded JVM JSON behavior.
    - Synchronous and asynchronous authentication operations return the typed DTOs.
    - Unit tests, format checks, and the JVM response schema comparison pass for these two response models.

- [X] T-022 Payment response envelope DTOs
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - `CancelPaymentResponse` exposes a validated `cancellation` object payload.
    - `GetPaymentTransactionsResponse` exposes a validated list of transaction object payloads.
    - `PayInstantlyResponse` exposes a validated `payment` object payload.
    - `PayWithBillingKeyResponse` exposes a validated `payment` object payload.
    - Extra response fields are ignored consistently with the recorded JVM JSON behavior.
    - Synchronous and asynchronous payment operations return the typed DTOs.
    - Unit tests and format checks pass; the payment live probe remains successful; and the JVM response schema comparison identifies these response models as matching.

- [X] T-023 Payment scalar response DTOs
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Escrow, virtual-account, and cancellation-stop response classes expose their JVM-matching timestamp and string fields.
    - `RegisterStoreReceiptResponse` exposes nullable `receiptUrl` with the JVM default/null behavior.
    - `PaymentWebhookResponse` exposes its response code, header, body, and response timestamp fields.
    - Required fields reject missing or non-string values, while extra fields are ignored.
    - Unit tests, format checks, the payment live probe, and the JVM response schema comparison pass for these response models.

- [X] T-024 Remaining simple payment response DTOs
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Cursor-based payment and payment-event responses expose validated `items` lists.
    - `ResendWebhookResponse` exposes a validated webhook object payload.
    - JVM empty success responses expose a successful empty DTO and ignore unknown response fields.
    - Unit tests, format checks, the payment live probe, and the JVM response schema comparison pass for these response models.

- [X] T-025 Cross-domain scalar and empty response DTOs
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Simple scalar responses across payment, PG-specific, platform, and B2B domains expose their JVM-matching fields and validate scalar types.
    - Nullable scalar fields preserve the JVM default/null behavior.
    - Empty success responses decode as empty DTOs rather than raw arrays.
    - Unit tests, format checks, a live E2E probe, and the JVM response schema comparison pass for these response models.

- [X] T-026 B2B response envelope DTOs
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - B2B tax invoice and counterparty response classes expose JVM-matching object, list, and page envelope fields.
    - Required envelope fields reject missing or non-array values; list fields reject non-list or non-object members.
    - Extra response fields are ignored consistently with the recorded JVM JSON behavior.
    - Unit tests, format checks, the B2B live E2E probes, and the JVM response schema comparison pass for these response models.

- [X] T-027 Platform policy and partner response envelopes
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Archive, create, and recover responses for Platform policies, contracts, and partners expose their JVM-matching object fields.
    - Required object fields reject missing or non-array values; extra fields are ignored.
    - Unit tests, format checks, the Platform live probes, and the JVM response schema comparison pass for these response models.

- [X] T-028 Platform schedule and update response envelopes
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Schedule and reschedule responses expose their JVM-matching scheduled object fields.
    - Platform update responses expose their JVM-matching policy, contract, and partner object fields.
    - Required object fields reject missing or non-array values; extra fields are ignored.
    - Unit tests, format checks, Platform live probes, and the JVM response schema comparison pass for these response models.

- [X] T-029 Platform list response DTOs
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Platform list responses expose JVM-matching `items`, `counts`, `page`, `partners`, and `transferSummaries` fields.
    - List and object envelope fields are validated consistently through the response model base helpers.
    - Unit tests, format checks, Platform live probes, and the JVM response schema comparison pass for these response models.

- [X] T-030 Payment, identity, and reconciliation list DTOs
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Billing key, cash receipt, identity verification, and payment schedule responses expose `items` and `page` lists matching the JVM models.
    - Card promotion and reconciliation VAT report responses preserve nullable list fields and required summary/object fields.
    - Unit tests, format checks, representative live probes, and the JVM response schema comparison pass for these response models.

- [X] T-031 Remaining non-polymorphic response DTOs
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Remaining identity, Platform transfer, payment schedule, cash receipt, billing key, and non-polymorphic response classes expose JVM-matching fields.
    - Empty success responses and nullable list/string fields preserve the JVM behavior.
    - Unit tests, format checks, representative live probes, and the JVM response schema comparison pass for these response models.

- [X] T-032 Billing key polymorphic response DTOs
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - `PgBillingKeyIssueResponse` selects failed, issued, and unknown variants from the JVM `type` discriminator.
    - `FailedPgBillingKeyIssueResponse` and `IssuedPgBillingKeyIssueResponse` expose their JVM-matching fields and validate required and nullable values.
    - Unknown variants are accepted as an explicit unrecognized response value without losing the original payload.
    - Unit tests, format checks, representative live probes, and the JVM response schema comparison pass.

- [X] T-033 Simple Platform and B2B nested model DTOs
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Platform setting, account holder, filter option, B2B upload payload, and B2B certificate models expose JVM-matching fields.
    - Required scalar fields reject missing or invalid values, while nullable fields preserve JVM defaults.
    - Unit tests, format checks, representative live probes, and the JVM response schema comparison pass.

- [X] T-034 Confirmation and company payload DTOs
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Billing-key confirmation, payment confirmation, and Platform company-state payloads expose JVM-matching fields.
    - Required scalar and object fields reject missing or invalid values.
    - Unit tests, format checks, representative live probes, and the JVM response schema comparison pass.

- [X] T-035 OpenAPI operation inventory and contract gap report
  - Satisfies: PRODUCT_SPEC.md FR-008, FR-009, FR-010, AC-007, AC-008
  - External boundary: yes
  - Acceptance criteria:
    - The repository contains a versioned OpenAPI V2 snapshot from the official PortOne source.
    - An executable contract tool enumerates every OpenAPI operation and compares its operationId with the PHP public operation methods and async counterparts.
    - The report identifies missing and unexpected operations without using the JVM catalog as the authority.
    - Unit tests, format checks, and the OpenAPI inventory check pass for the implemented scope.

- [X] T-036 OpenAPI operation signature comparison
  - Satisfies: PRODUCT_SPEC.md FR-008, FR-009, FR-010, FR-026, AC-007, AC-008
  - External boundary: no
  - Acceptance criteria:
    - The contract tool compares each PHP operation method and async counterpart with the OpenAPI path, HTTP method, path parameters, query parameters, and request body fields.
    - Required and optional OpenAPI inputs are reported separately from type mismatches.
    - The comparison fails with an actionable operation-level report when a signature diverges.
    - Unit tests, format checks, and the complete signature comparison pass.

- [X] T-037 OpenAPI response schema inventory
  - Satisfies: PRODUCT_SPEC.md FR-011, AC-009
  - External boundary: no
  - Acceptance criteria:
    - Every OpenAPI success response is mapped to its response schema and operation.
    - The tool identifies missing PHP response classes, raw response wrappers, missing fields, unexpected fields, nullable mismatches, and union schemas.
    - The inventory is reproducible from the committed OpenAPI snapshot and does not use the JVM schema as its authority.
    - Unit tests, format checks, and the response schema inventory pass for the current implementation.

- [X] T-038 Common, checkout, and payment-session schema completion
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-026, FR-027, AC-009, AC-022
  - External boundary: yes
  - Acceptance criteria:
    - Bank, checkout profile, payment-session request, and payment-session response models match the OpenAPI schemas.
    - Nested products, agreements, colors, payment methods, and optional fields are decoded according to the OpenAPI nullability and required-field rules.
    - Synchronous and asynchronous operations return the same typed results and failures.
    - Unit tests, format checks, representative live probes, and async tests pass.

- [X] T-039 Payment-domain OpenAPI response models
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-016, FR-017, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Payment, billing-key, cash-receipt, payment-schedule, promotion, and payment-event nested models match the OpenAPI schemas.
    - All OpenAPI `oneOf` and discriminator responses preserve unknown variants without crashing.
    - Required, nullable, enum, and list fields are validated according to the OpenAPI contract.
    - Unit tests, format checks, representative live probes, and unknown-variant tests pass.

- [X] T-040 Identity, PG-specific, authentication, and reconciliation response models
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-016, FR-017, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Identity verification, PG-specific, authentication, and reconciliation response models match the OpenAPI schemas.
    - Date-time, enum, nullable, and union fields preserve the documented response behavior.
    - Synchronous and asynchronous operations expose the same typed result model.
    - Unit tests, format checks, representative live probes, and unknown-variant tests pass.

- [X] T-041 B2B OpenAPI response models
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-016, FR-017, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Tax invoice, counterparty, certificate, file, and bulk-tax-invoice models match the OpenAPI schemas.
    - Nested contacts, business information, invoice items, and status unions are typed and forward-compatible.
    - Unit tests, format checks, representative live probes, and asynchronous operation tests pass.

- [X] T-042 Platform OpenAPI response models
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-016, FR-017, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Company, account, policy, partner, payout, settlement, transfer, and bulk-transfer models match the OpenAPI schemas.
    - Platform enums, nested fee/contract/account models, nullable fields, and union statuses are typed and forward-compatible.
    - Unit tests, format checks, representative live probes, and asynchronous operation tests pass.

- [X] T-043 OpenAPI error catalog and operation error mapping
  - Satisfies: PRODUCT_SPEC.md ERR-003, ERR-004, ERR-008, AC-018, AC-019
  - External boundary: yes
  - Acceptance criteria:
    - Every OpenAPI error response is mapped to a PHP PortOneException subtype or the operation's UnknownException.
    - HTTP status, OpenAPI error type, message, and raw body are preserved without exposing credentials.
    - Defined errors and unknown errors are tested against recorded or live observations.
    - Unit tests, format checks, and representative live error probes pass.

- [X] T-044 Complete synchronous/asynchronous operation parity
  - Satisfies: PRODUCT_SPEC.md FR-013, FR-026, FR-027, ERR-009, AC-015, AC-022
  - External boundary: yes
  - Acceptance criteria:
    - Every OpenAPI operation has one synchronous and one asynchronous PHP method.
    - Both paths use the same request definition, response decoder, timeout, authentication, and error mapping.
    - Representative success, decode failure, API failure, and transport failure cases produce equivalent outcomes.
    - Unit tests, format checks, and live async probes pass.

- [X] T-045 Complete OpenAPI live E2E matrix
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-013, AC-009, AC-014, AC-018, AC-019
  - External boundary: yes
  - Acceptance criteria:
    - Every OpenAPI operation has a runnable probe with safe test-store inputs or an explicit controlled-failure expectation.
    - Probe output records success result types or observed PortOneException types and status codes as JSON.
    - The E2E runner executes the complete matrix without treating documented feature-disabled or invalid-resource failures as infrastructure failures.
    - The full live matrix completes successfully and its observations are reviewed.

- [X] T-046 PHP API and internal architecture refactor
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-026, FR-027 and ARCHITECTURE.md COMP-001 to COMP-006
  - External boundary: no
  - Acceptance criteria:
    - Repeated operation declarations and response decoding code are reduced without changing the OpenAPI public API.
    - Clients, request execution, response interpretation, model decoding, errors, and Future responsibilities remain separated according to ARCHITECTURE.md.
    - Public method names, parameters, return types, authentication, timeouts, and async behavior remain unchanged.
    - Unit tests, format checks, and the OpenAPI contract checks pass before and after the refactor.

- [X] T-047 README and sample documentation for the complete OpenAPI client
  - Satisfies: PRODUCT_SPEC.md FR-001, FR-014, FR-019, FR-020, FR-021, AC-001, AC-010, AC-011, AC-012
  - External boundary: no
  - Acceptance criteria:
    - README documents installation, configuration, synchronous and asynchronous operation usage, webhook verification, and the complete OpenAPI scope.
    - E2E setup, `.env`, sample server, probe commands, controlled failures, and expected outputs are documented in Korean.
    - Documentation does not describe the JVM SDK as the implementation or API authority.
    - Documentation verification passes from a clean Composer install.

- [X] T-048 Clean-install, CI, and release verification
  - Satisfies: PRODUCT_SPEC.md FR-001, FR-011, FR-022, FR-023, FR-024, FR-025, AC-001, AC-013, AC-014
  - External boundary: yes
  - Acceptance criteria:
    - A clean PHP 8.2 installation can install the package and run the documented unit, lint, contract, and sample checks.
    - CI runs lint and tests on every required PHP version and does not require the local JVM checkout.
    - No secrets, local paths, generated credentials, or `composer.lock` are committed.
    - The package is ready for a semver release and Packagist installation.

- [X] T-049 Live payment lifecycle typed-success verification
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-013, FR-026, FR-027, AC-009, AC-022
  - External boundary: yes
  - Acceptance criteria:
    - A live test-store payment is created through the public PHP client using test credentials.
    - The payment-creation response is decoded as `PayInstantlyResponse` and its nested payment payload is a typed model.
    - `getPayment` retrieves the created payment and returns a typed `Payment` model whose identity matches the created payment.
    - `cancelPayment` cancels the created payment and returns a typed `CancelPaymentResponse` with a typed cancellation payload.
    - The final payment state is retrieved or otherwise observed as cancelled, without exposing API secrets or committing generated payment data.
    - The live probe records the operation names, result types, payment identifier metadata, and final status as a reproducible local observation; it does not treat a controlled PortOne API failure as a typed-success pass.
    - Synchronous payment creation, lookup, and cancellation plus an asynchronous final-state lookup, unit tests, format checks, and the complete live E2E verification pass.

- [X] T-050 Billing key lifecycle live verification
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-013, FR-026, FR-027, AC-009, AC-022
  - External boundary: yes
  - Acceptance criteria:
    - A billing key is issued automatically through the public PHP client using test credentials and the PortOne smart-routing channel group ID; no browser SDK or committed billing-key fixture is required.
    - `getBillingKeyInfo` returns a typed billing-key model whose identity matches the issued billing key.
    - `payWithBillingKey` creates a live test-store payment and returns a typed `PayWithBillingKeyResponse` with a typed payment payload.
    - The created payment is retrieved with `getPayment` and cancelled with `cancelPayment`, and the final state is observed as cancelled.
    - `deleteBillingKey` succeeds on the disposable billing key, and a later lookup returns the typed `DELETED` billing-key state or the observed defined deletion error.
    - Synchronous operations and an asynchronous final-state lookup are covered, and no secret or billing key value is committed or printed.
    - Unit tests, format checks, and the full live E2E matrix pass.

- [X] T-051 Payment schedule lifecycle and scheduled-execution webhook
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-013, FR-015, FR-016, AC-009, AC-018
  - External boundary: yes
  - Acceptance criteria:
    - `createPaymentSchedule` with a billing key returns a typed schedule response, and `getPaymentSchedule` returns the same schedule as a typed model.
    - `revokePaymentSchedules` revokes the schedule, and the revoked state is observed.
    - A schedule set to execute shortly is observed to run, and the resulting webhook is received and verified by `WebhookVerifier`.
    - The observed payment created by the schedule is retrieved as a typed `Payment` and cancelled.
    - Unit tests, format checks, and the full live E2E matrix pass.

- [X] T-052 Partial cancellation and refund paths
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, FR-013, ERR-003, ERR-004, AC-009, AC-018
  - External boundary: yes
  - Acceptance criteria:
    - A live payment is cancelled in multiple partial steps using `amount`, `taxFreeAmount`, `vatAmount`, and `currentCancellableAmount`, and each step returns a typed `CancelPaymentResponse`.
    - The payment status is observed as partially cancelled after the first step and cancelled after the last.
    - Cancelling more than the cancellable amount, a mismatched `currentCancellableAmount`, and cancelling an already cancelled payment each raise the observed defined error with status and type preserved.
    - Unit tests cover request construction for every cancellation field.
    - Unit tests, format checks, and the full live E2E matrix pass.

- [X] T-053 Duplicate request and timeout recovery behavior
  - Satisfies: PRODUCT_SPEC.md FR-013, FR-023, FR-024, FR-025, ERR-005, ERR-006, ERR-009, AC-014, AC-018
  - External boundary: yes
  - Acceptance criteria:
    - Paying twice with the same `paymentId` raises the observed already-paid defined error, and the first payment is unaffected.
    - A request that times out client-side is followed by `getPayment` for the same `paymentId`, and the probe records whether the payment exists, so a recovery procedure is documented from observation.
    - No retry happens inside the SDK on timeout, transport failure, or 5xx, verified by request counting at a local mock.
    - The README documents the recovery procedure for an uncertain payment outcome.
    - Unit tests, format checks, and the full live E2E matrix pass.

- [X] T-054 Real webhook verification and fixture capture
  - Satisfies: PRODUCT_SPEC.md FR-014, FR-015, FR-016, FR-017, FR-018, ERR-002, ERR-007, AC-010, AC-018
  - External boundary: yes
  - Acceptance criteria:
    - Webhooks delivered by PortOne itself (console test send and a real payment) are received by a local receiver and verified by `WebhookVerifier` with the real webhook secret.
    - Real payloads for each observed type (payment, billing key, cancellation, and others observable) are stored as sanitized fixtures and used in regression tests.
    - A signature header with multiple signatures is accepted when any one is valid and rejected when none is valid.
    - Timestamp tolerance is tested at the boundary: just inside, just outside, future-dated, and malformed timestamps.
    - Raw body changes of any kind (whitespace, re-serialization, encoding) cause `WebhookVerificationException`, and an unverified body is never decoded.
    - Unit tests, format checks, and the full live E2E matrix pass.

- [X] T-055 Payment method and status union fixtures
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-016, FR-017, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - Real or recorded responses exist for every payment method type observable (card, easy pay, transfer, virtual account, mobile, gift certificate), each decoded into its typed model.
    - Recorded PG responses that cannot be produced live are stored as sanitized fixtures and replayed in tests.
    - Every payment status value and an unknown status value decode without error, and unknown values preserve the original payload.
    - Unknown method and unknown discriminator values are accepted as explicit unrecognized values.
    - Unit tests, format checks, and the full live E2E matrix pass.

- [X] T-056 Decoder robustness and fuzzing
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-012, ERR-004, AC-009, AC-019
  - External boundary: no
  - Acceptance criteria:
    - Amounts above 32-bit range decode without loss, and non-integer or overflowing amounts are rejected as decode failures.
    - Date-time values with `Z` and `+09:00` offsets decode to the same instant, and malformed dates are decode failures.
    - Missing, null, and wrong-typed fields are distinguished for required and nullable fields, and Korean and emoji strings survive decoding unchanged.
    - A property-based or fuzz test feeds malformed JSON to every response decoder and asserts that only `UnrecognizedResponseException` is raised, never `TypeError`, `ValueError`, or warnings.
    - Unit tests and format checks pass.

- [X] T-057 Transport failure matrix with a local mock server
  - Satisfies: PRODUCT_SPEC.md FR-023, FR-024, FR-025, ERR-005, ERR-006, ERR-008, ERR-009, AC-014, AC-019
  - External boundary: no
  - Acceptance criteria:
    - A local mock server reproduces connection refused, DNS failure, TLS failure, slow response, and a connection dropped mid-response, each producing `TransportException` or the timeout behavior defined in ARCHITECTURE.md.
    - 5xx with an HTML or empty body, 429, a gzip-encoded response, and an error JSON that differs from the documented shape each produce the documented exception type with status and raw body preserved.
    - Each case is verified for both synchronous and asynchronous operations with the same outcome.
    - Request counts confirm no retry in any case.
    - Unit tests and format checks pass.

- [X] T-058 Asynchronous and long-running process behavior
  - Satisfies: PRODUCT_SPEC.md FR-013, FR-026, FR-027, ERR-009, AC-015, AC-022
  - External boundary: yes
  - Acceptance criteria:
    - Starting a Future and discarding it without waiting is tested and its behavior (request sent or not, no warnings, clean shutdown) is documented.
    - Several hundred concurrent Futures complete correctly, and any concurrency limit is documented or enforced.
    - Repeated calls in one process for many iterations show no memory growth and no state leaking between a failed call and later calls on the shared Request Executor.
    - The long-running check is documented for queue workers and Octane-style processes.
    - Unit tests, format checks, and the full live E2E matrix pass.

- [ ] T-059 Secret exposure and serialization safety
  - Satisfies: PRODUCT_SPEC.md FR-022, ERR-001, ERR-008, AC-013
  - External boundary: no
  - Acceptance criteria:
    - Raised exceptions, their messages, traces, `var_dump`, `print_r`, `var_export`, and log output never contain `apiSecret` or `webhookSecret`, including with `zend.exception_ignore_args` disabled.
    - `serialize` of any client or the verifier either fails explicitly or omits the secret, and `unserialize` cannot yield a working client from leaked data.
    - `__debugInfo` hides secrets for all public clients.
    - Unit tests and format checks pass.

- [ ] T-060 Dependency, PHP version, and release smoke compatibility
  - Satisfies: PRODUCT_SPEC.md FR-001, FR-022, AC-001, AC-013
  - External boundary: yes
  - Acceptance criteria:
    - Tests pass with `composer update --prefer-lowest` and with latest dependencies.
    - CI runs on every supported PHP version from 8.2 through the newest stable, and results are recorded.
    - A smoke test installs the published v0.2.0 from Packagist in a clean directory and runs one controlled-failure call.
    - Unit tests and format checks pass.

- [ ] T-061 OpenAPI spec drift detection
  - Satisfies: PRODUCT_SPEC.md FR-008, FR-009, FR-011, AC-007, AC-008, AC-009
  - External boundary: yes
  - Acceptance criteria:
    - A scheduled CI job fetches the official latest PortOne V2 OpenAPI spec and diffs it against the committed snapshot.
    - New, removed, and changed operations and schema fields are reported in a readable summary, and the job notifies maintainers.
    - Updating the snapshot is a documented manual step that reruns the contract tools.
    - Unit tests and format checks pass.

- [ ] T-062 Static analysis and mutation testing
  - Satisfies: PRODUCT_SPEC.md FR-011, FR-026, AC-009
  - External boundary: no
  - Acceptance criteria:
    - PHPStan or Psalm passes at the highest level practical, with any baseline entries justified.
    - Mutation testing (Infection) runs against the response decoders and outcome classification, and surviving mutants are reviewed or covered by new tests.
    - Unit tests and format checks pass.

- [ ] T-063 Public API stabilization before the Laravel package
  - Satisfies: PRODUCT_SPEC.md FR-002, FR-007, FR-011, AC-001, AC-022
  - External boundary: no
  - Acceptance criteria:
    - The public API (client names, method signatures, exception hierarchy, response types) is listed in a document, and everything else is marked `@internal`.
    - A check fails when the public surface changes without an update to that list.
    - The versioning policy for `0.x` and the version range that laravel-portone will depend on are documented.
    - Unit tests, format checks, and the OpenAPI contract checks pass.
