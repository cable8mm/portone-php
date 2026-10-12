# Release Notes

## v0.2.0 - 2026-10-12

### What's Changed

* docs: add MIT License and update README with license badge by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/39
* refactor: update namespaces from Response to Model in tests and fixtures by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/40

**Full Changelog**: https://github.com/cable8mm/portone-php/compare/v0.1.0...v0.2.0

## v0.1.0 - 2026-10-11

### What's Changed

* chore: add CI workflow, update project structure, and configure PHPUnit by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/1
* docs: add reference contract probe tool for jvm sdk by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/2
* feat: implement webhook capture and boundary observation tools by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/3
* test: add undecodable success observation to boundary probe and mark T-003 as complete by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/4
* feat: implement PaymentClient and related exceptions, add synchronous and asynchronous payment retrieval by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/5
* feat: implement client hierarchy with abstract base class and specific clients by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/6
* feat: add PaymentScheduleClient and PromotionClient with new operations by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/7
* feat: implement IdentityVerificationClient with operations for identity verification and responses by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/8
* feat: implement PG-specific operations in PgSpecificClient and add related response classes by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/9
* feat: implement authentication operations in AuthClient with login and refresh token methods, add response classes and tests by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/10
* feat: add reconciliation operations in ReconciliationClient with synchronous and asynchronous methods, implement response classes and tests by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/11
* feat: Add new operations for account and company clients by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/12
* feat: implement platform bulk and payout operations in clients, add response classes and tests by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/13
* feat: implement platform partner and transfer operations in PartnerClient and TransferClient by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/14
* feat: implement platform policy operations in PolicyClient, add response classes and tests by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/15
* feat: add b2b tax invoice operations by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/16
* feat: implement B2B counterparty operations and responses, add tests and observation recording by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/17
* feat: implement webhook verification system with typed results and tests by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/18
* feat: add PHP server sample implementation with webhook handling and tests by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/19
* feat: update webhook verification to include timestamp and signature handling by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/20
* feat: create README and add webhook capture functionality with request validation and logging by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/21
* feat: add response schema probing tools and fix all things by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/22
* feat: add OpenAPI metadata and new client response classes by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/23
* feat: enhance OpenAPI contract probing and PaymentScheduleClient by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/24
* feat: implement OpenAPI response schema inventory and corresponding tests by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/25
* feat: common checkout and payment session schema completion by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/26
* feat: implement async handling for identity verification and payment reconciliation probes by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/27
* feat: enhance B2B response models and add async operations for counterparties and tax invoices by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/28
* feat: enhance response models with additional fields and validation methods by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/29
* feat: enhance error handling by adding error type to exceptions and implementing tests by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/30
* feat: add tests for synchronous and asynchronous operation parity by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/31
* test: add OpenAPI matrix probe for API operation validation by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/32
* refactor: PaymentClient to use callOperation methods and update response handling by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/33
* docs: update README and sample documentation to reflect OpenAPI client operations by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/34
* ci: enhance CI workflow by adding Composer validation and OpenAPI checks by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/35
* refactor: remove reference and response schema probe scripts as they are no longer needed by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/36
* refactor: TransferClient method signatures to use more specific types by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/37
* ci: update CI workflow to use actions/checkout@v7 and add update-changelog workflow by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/portone-php/pull/38

### New Contributors

* [@cable8mm](https://github.com/cable8mm) made their first contribution in https://github.com/cable8mm/portone-php/pull/1

**Full Changelog**: https://github.com/cable8mm/portone-php/commits/v0.1.0
