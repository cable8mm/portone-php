<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class CounterpartyClient extends AbstractClient
{
    public function createB2bCounterparty(mixed $test = null, mixed $counterpartyId = null, mixed $counterparty = null, mixed $options = null): Response\CreateB2bCounterpartyResponse
    {
        return $this->callOperationWithQueryAndBody('createB2bCounterparty', 'POST', '/b2b/counterparties', ['test' => $test], ['counterpartyId' => $counterpartyId, 'counterparty' => $counterparty, 'options' => $options], Response\CreateB2bCounterpartyResponse::class);
    }

    public function createB2bCounterpartyAsync(mixed $test = null, mixed $counterpartyId = null, mixed $counterparty = null, mixed $options = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createB2bCounterparty', 'POST', '/b2b/counterparties', ['test' => $test], ['counterpartyId' => $counterpartyId, 'counterparty' => $counterparty, 'options' => $options], Response\CreateB2bCounterpartyResponse::class);
    }

    public function deleteB2bCounterparty(mixed $counterpartyId = null, mixed $test = null): Response\DeleteB2bCounterpartyResponse
    {
        return $this->callOperation('deleteB2bCounterparty', 'DELETE', '/b2b/counterparties/{counterpartyId}', ['counterpartyId' => $counterpartyId, 'test' => $test], Response\DeleteB2bCounterpartyResponse::class, false);
    }

    public function deleteB2bCounterpartyAsync(mixed $counterpartyId = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('deleteB2bCounterparty', 'DELETE', '/b2b/counterparties/{counterpartyId}', ['counterpartyId' => $counterpartyId, 'test' => $test], Response\DeleteB2bCounterpartyResponse::class, false);
    }

    public function getB2bCounterparties(mixed $test = null, mixed $page = null, mixed $filter = null): Response\GetB2bCounterpartiesResponse
    {
        return $this->callOperationWithQueryRequestBody('getB2bCounterparties', 'GET', '/b2b/counterparties', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetB2bCounterpartiesResponse::class);
    }

    public function getB2bCounterpartiesAsync(mixed $test = null, mixed $page = null, mixed $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getB2bCounterparties', 'GET', '/b2b/counterparties', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetB2bCounterpartiesResponse::class);
    }

    public function getB2bCounterparty(mixed $counterpartyId = null, mixed $test = null): Response\B2bCounterparty
    {
        return $this->callOperation('getB2bCounterparty', 'GET', '/b2b/counterparties/{counterpartyId}', ['counterpartyId' => $counterpartyId, 'test' => $test], Response\B2bCounterparty::class, false);
    }

    public function getB2bCounterpartyAsync(mixed $counterpartyId = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('getB2bCounterparty', 'GET', '/b2b/counterparties/{counterpartyId}', ['counterpartyId' => $counterpartyId, 'test' => $test], Response\B2bCounterparty::class, false);
    }

    public function getB2bCounterpartyCertificate(mixed $brn = null, mixed $test = null): Response\B2bCertificate
    {
        return $this->callOperation('getB2bCounterpartyCertificate', 'GET', '/b2b/counterparties/{brn}/certificate', ['brn' => $brn, 'test' => $test], Response\B2bCertificate::class, false);
    }

    public function getB2bCounterpartyCertificateAsync(mixed $brn = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('getB2bCounterpartyCertificate', 'GET', '/b2b/counterparties/{brn}/certificate', ['brn' => $brn, 'test' => $test], Response\B2bCertificate::class, false);
    }

    public function getB2bCounterpartyCertificateRegistrationUrl(mixed $brn = null, mixed $test = null): Response\GetB2bCounterpartyCertificateRegistrationUrlResponse
    {
        return $this->callOperation('getB2bCounterpartyCertificateRegistrationUrl', 'GET', '/b2b/counterparties/{brn}/certificate/registration-url', ['brn' => $brn, 'test' => $test], Response\GetB2bCounterpartyCertificateRegistrationUrlResponse::class, false);
    }

    public function getB2bCounterpartyCertificateRegistrationUrlAsync(mixed $brn = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('getB2bCounterpartyCertificateRegistrationUrl', 'GET', '/b2b/counterparties/{brn}/certificate/registration-url', ['brn' => $brn, 'test' => $test], Response\GetB2bCounterpartyCertificateRegistrationUrlResponse::class, false);
    }

    public function updateB2bCounterparty(mixed $counterpartyId = null, mixed $test = null, mixed $counterparty = null, mixed $options = null): Response\UpdateB2bCounterpartyResponse
    {
        return $this->callOperationWithQueryAndBody('updateB2bCounterparty', 'PATCH', '/b2b/counterparties/{counterpartyId}', ['counterpartyId' => $counterpartyId, 'test' => $test], ['counterparty' => $counterparty, 'options' => $options], Response\UpdateB2bCounterpartyResponse::class);
    }

    public function updateB2bCounterpartyAsync(mixed $counterpartyId = null, mixed $test = null, mixed $counterparty = null, mixed $options = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updateB2bCounterparty', 'PATCH', '/b2b/counterparties/{counterpartyId}', ['counterpartyId' => $counterpartyId, 'test' => $test], ['counterparty' => $counterparty, 'options' => $options], Response\UpdateB2bCounterpartyResponse::class);
    }

    public function validateB2bCounterpartyCertificate(mixed $brn = null, mixed $test = null): Response\ValidateB2bCounterpartyCertificateResponse
    {
        return $this->callOperation('validateB2bCounterpartyCertificate', 'POST', '/b2b/counterparties/{brn}/certificate/validate', ['brn' => $brn, 'test' => $test], Response\ValidateB2bCounterpartyCertificateResponse::class, false);
    }

    public function validateB2bCounterpartyCertificateAsync(mixed $brn = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('validateB2bCounterpartyCertificate', 'POST', '/b2b/counterparties/{brn}/certificate/validate', ['brn' => $brn, 'test' => $test], Response\ValidateB2bCounterpartyCertificateResponse::class, false);
    }
}
