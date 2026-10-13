# TECH_STACK.md

## 1. Languages / runtimes / frameworks / libraries

- Language: PHP.
- PHP version constraint: ^8.2.
- CI PHP versions: 8.2, 8.3, 8.4, 8.5.
- Run method: interpreted. No compile step.
- Module system: Composer autoload, PSR-4.
- Root PHP namespace: Cable8mm\\PortonePhp.
- Package manager: Composer.
- Lockfile: composer.lock. MUST NOT be committed.
- Package name: cable8mm/portone-php.
- Vendor: cable8mm.
- License: MIT.
- Web framework: none. Pure PHP.
- Runtime dependency: PHP extension ext-curl, any version.
- Runtime dependency: PHP extension ext-json, any version.
- Runtime dependency: guzzlehttp/guzzle, ^7.8.2 or ^8.0.
- HTTP transport: Guzzle HTTP client.
- Async HTTP transport: Guzzle asynchronous requests and promises.
- Webhook signature computation: PHP built-in hash functions. No library.
- Config parser library: vlucas/phpdotenv, development-only for the E2E runner.
- CLI argument parser library: none.
- YouTube API client library: none.
- Dev dependency: phpunit/phpunit ^11.0.
- Dev dependency: laravel/pint ^1.29.
- Reference implementation for stack conventions: Stripe PHP SDK.
- API contract source: the PortOne V2 OpenAPI document at https://developers.portone.io/api/schema/v2/openapi.json.
- OpenAPI contract snapshots MUST be stored under tests/fixtures with their source URL and retrieval date recorded by the contract tool.

## 2. Framework- or tool-mandated paths and file names only

- composer.json (project root).
- vendor/ (Composer install directory). MUST be git-ignored.
- composer.lock. MUST be git-ignored.
- phpunit.xml.dist (PHPUnit configuration).
- pint.json (Pint configuration, only if a non-default rule is needed).
- .github/workflows/ (GitHub Actions workflow files).
- .gitignore.

## 3. Coding conventions specific to the chosen stack

- Code MUST run on every PHP version in the CI PHP versions list.
- Code MUST NOT use syntax or built-in features introduced after PHP 8.2.
- PHP files MUST follow PSR-4: one class per file, file name equals class name.
- Code MUST be formatted by laravel/pint with its default preset.
- composer.json MUST declare "php": "^8.2" under require.
- composer.json MUST declare ext-curl and ext-json under require.
- composer.json MUST declare guzzlehttp/guzzle under require.
- composer.json MUST declare phpunit/phpunit and laravel/pint under require-dev.
- composer.json MUST declare the PSR-4 autoload mapping.
- composer.json MUST NOT contain a "version" field.
- Static analysis tools MUST NOT be used.

## 4. Testing rules

- Test tool: PHPUnit ^11.0.
- Test classes MUST have the suffix Test.
- Test files MUST have the suffix Test.php.
- Test metadata MUST use PHPUnit attributes.
- Test metadata MUST NOT use docblock annotations.
- Tests MUST run on every PHP version in the CI PHP versions list.
- Coverage threshold: none.
- Coverage tools and coverage reports MUST NOT be configured.
- Format check command: composer lint.
- Test command: composer test.

## 5. Configuration rules

- Config file format: none.
- The library MUST NOT read environment variables.
- The development-only E2E runner MAY load `.env` with vlucas/phpdotenv for the
  existing boundary probes.
- Environment variable for the samples: PORTONE_API_SECRET.
- Environment variable for the samples: PORTONE_WEBHOOK_SECRET.
- Samples MUST read secrets from process environment variables.
- vlucas/phpdotenv MUST remain a development-only dependency and MUST NOT be
  used by the library classes or production package runtime.

## 6. Deployment rules

- Distribution target: Packagist.
- CI system: GitHub Actions.
- Build step: none.
- Release tag format: vx.y.z.
- Version scheme: semver.
- A release MUST be made by pushing a tag in the vx.y.z format.
- Each CI run MUST execute the format check and the test command on every PHP version in the CI PHP versions list.

## 7. Security rules tied to the chosen stack

- Secrets MUST NOT be committed to the repository.
- Secrets MUST NOT appear in test fixtures or samples as literal real values.
- cURL options MUST NOT disable TLS peer or host verification.
- Webhook signature comparison MUST use hash_equals.

## 8. Non-goals

- Web frameworks of any kind.
- Laravel HTTP client or any framework-specific HTTP client.
- Static analysis tools.
- Code coverage tools and thresholds.
- Committing composer.lock.
- Production configuration parser libraries.
- CLI argument parser libraries.
- YouTube API client libraries.
- Dotenv libraries.
