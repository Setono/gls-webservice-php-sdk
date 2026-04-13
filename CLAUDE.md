# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

PHP SDK wrapping the GLS (General Logistics Systems) Danish parcel shop webservice at `https://www.gls.dk/webservices_v4/wsShopFinder.asmx`. Uses SOAP under the hood. Namespace: `Setono\GLS\Webservice\`.

## Commands

- **Run tests:** `composer phpunit` (or `vendor/bin/phpunit`)
- **Run a single test:** `vendor/bin/phpunit --filter testMethodName`
- **Static analysis:** `composer analyse` (Psalm, error level 1 — strictest)
- **Check code style:** `composer check-style` (ECS with Sylius coding standard)
- **Fix code style:** `composer fix-style`

## Architecture

The SDK follows a straightforward layered pattern:

- **`Client/ClientInterface`** defines five methods for querying parcel shops (search nearest, get by zip code, get all, get one, get drop point). **`Client/Client`** implements them via SOAP.
- **`Factory/SoapClientFactoryInterface`** abstracts SOAP client creation — injected into Client for testability.
- **`Model/ParcelShop`** and **`Model/OpeningHours`** are DTOs with `createFromStdClass()` factory methods that parse raw SOAP `stdClass` responses.
- **`Response/Response`** wraps SOAP response headers/body and uses `guzzlehttp/psr7` to parse the HTTP status line.
- **`Exception/`** has a hierarchy rooted at `ExceptionInterface`: `ConnectionException` (host unreachable), `SoapException` (generic SOAP fault), `ClientException` (HTTP-level error with Response), `NoResultException`, `ParcelShopNotFoundException`.

## Code Conventions

- All files use `declare(strict_types=1)`.
- Coding standard: Sylius coding standard via ECS (`ecs.php` imports `vendor/sylius-labs/coding-standard/ecs.php`).
- Psalm baseline (`psalm-baseline.xml`) tracks accepted issues around SOAP's dynamic typing.
- Tests use `@test` annotation style, not `test` method prefix.
- Tests hit the real GLS webservice (integration tests, not mocked).
