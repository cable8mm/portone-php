<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * B2B 거래처 API 작업을 제공합니다.
 */
final class CounterpartyClient extends AbstractClient
{
    /**
     * 거래처 생성 기능입니다.
     * 거래처를 생성합니다.
     */
    public function createB2bCounterparty(?bool $test = null, ?string $counterpartyId = null, ?array $counterparty = null, ?array $options = null): Model\CreateB2bCounterpartyResponse
    {
        return $this->callOperationWithQueryAndBody('createB2bCounterparty', 'POST', '/b2b/counterparties', ['test' => $test], ['counterpartyId' => $counterpartyId, 'counterparty' => $counterparty, 'options' => $options], Model\CreateB2bCounterpartyResponse::class);
    }

    /**
     * 거래처 생성 기능입니다.
     * 거래처를 생성합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function createB2bCounterpartyAsync(?bool $test = null, ?string $counterpartyId = null, ?array $counterparty = null, ?array $options = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createB2bCounterparty', 'POST', '/b2b/counterparties', ['test' => $test], ['counterpartyId' => $counterpartyId, 'counterparty' => $counterparty, 'options' => $options], Model\CreateB2bCounterpartyResponse::class);
    }

    /**
     * 거래처 삭제 기능입니다.
     * 거래처를 삭제합니다.
     */
    public function deleteB2bCounterparty(?string $counterpartyId = null, ?bool $test = null): Model\DeleteB2bCounterpartyResponse
    {
        return $this->callOperation('deleteB2bCounterparty', 'DELETE', '/b2b/counterparties/{counterpartyId}', ['counterpartyId' => $counterpartyId, 'test' => $test], Model\DeleteB2bCounterpartyResponse::class, false);
    }

    /**
     * 거래처 삭제 기능입니다.
     * 거래처를 삭제합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function deleteB2bCounterpartyAsync(?string $counterpartyId = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('deleteB2bCounterparty', 'DELETE', '/b2b/counterparties/{counterpartyId}', ['counterpartyId' => $counterpartyId, 'test' => $test], Model\DeleteB2bCounterpartyResponse::class, false);
    }

    /**
     * 거래처 검색 기능입니다.
     * 거래처를 검색합니다.
     */
    public function getB2bCounterparties(?bool $test = null, ?array $page = null, ?array $filter = null): Model\GetB2bCounterpartiesResponse
    {
        return $this->callOperationWithQueryRequestBody('getB2bCounterparties', 'GET', '/b2b/counterparties', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetB2bCounterpartiesResponse::class);
    }

    /**
     * 거래처 검색 기능입니다.
     * 거래처를 검색합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getB2bCounterpartiesAsync(?bool $test = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getB2bCounterparties', 'GET', '/b2b/counterparties', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetB2bCounterpartiesResponse::class);
    }

    /**
     * 거래처 조회 기능입니다.
     * 거래처를 조회합니다.
     */
    public function getB2bCounterparty(?string $counterpartyId = null, ?bool $test = null): Model\B2bCounterparty
    {
        return $this->callOperation('getB2bCounterparty', 'GET', '/b2b/counterparties/{counterpartyId}', ['counterpartyId' => $counterpartyId, 'test' => $test], Model\B2bCounterparty::class, false);
    }

    /**
     * 거래처 조회 기능입니다.
     * 거래처를 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getB2bCounterpartyAsync(?string $counterpartyId = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bCounterparty', 'GET', '/b2b/counterparties/{counterpartyId}', ['counterpartyId' => $counterpartyId, 'test' => $test], Model\B2bCounterparty::class, false);
    }

    /**
     * 인증서 조회 기능입니다.
     * 연동 사업자의 인증서를 조회합니다.
     */
    public function getB2bCounterpartyCertificate(?string $brn = null, ?bool $test = null): Model\B2bCertificate
    {
        return $this->callOperation('getB2bCounterpartyCertificate', 'GET', '/b2b/counterparties/{brn}/certificate', ['brn' => $brn, 'test' => $test], Model\B2bCertificate::class, false);
    }

    /**
     * 인증서 조회 기능입니다.
     * 연동 사업자의 인증서를 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getB2bCounterpartyCertificateAsync(?string $brn = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bCounterpartyCertificate', 'GET', '/b2b/counterparties/{brn}/certificate', ['brn' => $brn, 'test' => $test], Model\B2bCertificate::class, false);
    }

    /**
     * 사업자 인증서 등록 URL 조회 기능입니다.
     * 연동 사업자의 인증서를 등록하기 위한 URL을 조회합니다.
     */
    public function getB2bCounterpartyCertificateRegistrationUrl(?string $brn = null, ?bool $test = null): Model\GetB2bCounterpartyCertificateRegistrationUrlResponse
    {
        return $this->callOperation('getB2bCounterpartyCertificateRegistrationUrl', 'GET', '/b2b/counterparties/{brn}/certificate/registration-url', ['brn' => $brn, 'test' => $test], Model\GetB2bCounterpartyCertificateRegistrationUrlResponse::class, false);
    }

    /**
     * 사업자 인증서 등록 URL 조회 기능입니다.
     * 연동 사업자의 인증서를 등록하기 위한 URL을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getB2bCounterpartyCertificateRegistrationUrlAsync(?string $brn = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bCounterpartyCertificateRegistrationUrl', 'GET', '/b2b/counterparties/{brn}/certificate/registration-url', ['brn' => $brn, 'test' => $test], Model\GetB2bCounterpartyCertificateRegistrationUrlResponse::class, false);
    }

    /**
     * 거래처 정보 수정 기능입니다.
     * 거래처 정보를 수정합니다.
     */
    public function updateB2bCounterparty(?string $counterpartyId = null, ?bool $test = null, ?array $counterparty = null, ?array $options = null): Model\UpdateB2bCounterpartyResponse
    {
        return $this->callOperationWithQueryAndBody('updateB2bCounterparty', 'PATCH', '/b2b/counterparties/{counterpartyId}', ['counterpartyId' => $counterpartyId, 'test' => $test], ['counterparty' => $counterparty, 'options' => $options], Model\UpdateB2bCounterpartyResponse::class);
    }

    /**
     * 거래처 정보 수정 기능입니다.
     * 거래처 정보를 수정합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function updateB2bCounterpartyAsync(?string $counterpartyId = null, ?bool $test = null, ?array $counterparty = null, ?array $options = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updateB2bCounterparty', 'PATCH', '/b2b/counterparties/{counterpartyId}', ['counterpartyId' => $counterpartyId, 'test' => $test], ['counterparty' => $counterparty, 'options' => $options], Model\UpdateB2bCounterpartyResponse::class);
    }

    /**
     * 사업자 인증서 유효성 검증 기능입니다.
     * 연동 사업자가 등록한 인증서의 유효성을 검증합니다.
     */
    public function validateB2bCounterpartyCertificate(?string $brn = null, ?bool $test = null): Model\ValidateB2bCounterpartyCertificateResponse
    {
        return $this->callOperation('validateB2bCounterpartyCertificate', 'POST', '/b2b/counterparties/{brn}/certificate/validate', ['brn' => $brn, 'test' => $test], Model\ValidateB2bCounterpartyCertificateResponse::class, false);
    }

    /**
     * 사업자 인증서 유효성 검증 기능입니다.
     * 연동 사업자가 등록한 인증서의 유효성을 검증합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function validateB2bCounterpartyCertificateAsync(?string $brn = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('validateB2bCounterpartyCertificate', 'POST', '/b2b/counterparties/{brn}/certificate/validate', ['brn' => $brn, 'test' => $test], Model\ValidateB2bCounterpartyCertificateResponse::class, false);
    }
}
