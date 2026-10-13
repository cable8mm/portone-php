<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 파트너 API 작업을 제공합니다.
 */
final class PartnerClient extends AbstractClient
{
    /**
     * 파트너 보관 기능입니다.
     * 주어진 아이디에 대응되는 파트너를 보관합니다.
     */
    public function archivePlatformPartner(?string $id = null, ?bool $test = null): Model\ArchivePlatformPartnerResponse
    {
        return $this->callOperation('archivePlatformPartner', 'POST', '/platform/partners/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformPartnerResponse::class, false);
    }

    /**
     * 파트너 보관 기능입니다.
     * 주어진 아이디에 대응되는 파트너를 보관합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function archivePlatformPartnerAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('archivePlatformPartner', 'POST', '/platform/partners/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformPartnerResponse::class, false);
    }

    /**
     * 파트너 일괄 거래처 연동 기능입니다.
     * 파트너들을 일괄 거래처 연동합니다.
     */
    public function connectBulkPartnerCounterparty(?bool $test = null, ?array $filter = null): Model\ConnectBulkPartnerCounterpartyResponse
    {
        return $this->callOperationWithQueryAndBody('connectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect', ['test' => $test], ['filter' => $filter], Model\ConnectBulkPartnerCounterpartyResponse::class);
    }

    /**
     * 파트너 일괄 거래처 연동 기능입니다.
     * 파트너들을 일괄 거래처 연동합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function connectBulkPartnerCounterpartyAsync(?bool $test = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('connectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect', ['test' => $test], ['filter' => $filter], Model\ConnectBulkPartnerCounterpartyResponse::class);
    }

    /**
     * 파트너 거래처 연동 기능입니다.
     * 파트너를 거래처에 연동합니다.
     */
    public function connectPartnerCounterparty(?string $id = null, ?bool $test = null): Model\ConnectPartnerCounterpartyResponse
    {
        return $this->callOperation('connectPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect/{id}', ['id' => $id, 'test' => $test], Model\ConnectPartnerCounterpartyResponse::class, false);
    }

    /**
     * 파트너 거래처 연동 기능입니다.
     * 파트너를 거래처에 연동합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function connectPartnerCounterpartyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('connectPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect/{id}', ['id' => $id, 'test' => $test], Model\ConnectPartnerCounterpartyResponse::class, false);
    }

    /**
     * 파트너 생성 기능입니다.
     * 새로운 파트너를 생성합니다.
     */
    public function createPlatformPartner(?bool $test = null, ?string $id = null, ?string $name = null, ?array $contact = null, ?array $account = null, ?string $defaultContractId = null, ?string $memo = null, ?array $tags = null, ?array $type = null, ?array $userDefinedProperties = null): Model\CreatePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformPartner', 'POST', '/platform/partners', ['test' => $test], ['id' => $id, 'name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Model\CreatePlatformPartnerResponse::class);
    }

    /**
     * 파트너 생성 기능입니다.
     * 새로운 파트너를 생성합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function createPlatformPartnerAsync(?bool $test = null, ?string $id = null, ?string $name = null, ?array $contact = null, ?array $account = null, ?string $defaultContractId = null, ?string $memo = null, ?array $tags = null, ?array $type = null, ?array $userDefinedProperties = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformPartner', 'POST', '/platform/partners', ['test' => $test], ['id' => $id, 'name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Model\CreatePlatformPartnerResponse::class);
    }

    /**
     * 파트너 다건 생성 기능입니다.
     * 새로운 파트너를 다건 생성합니다.
     */
    public function createPlatformPartners(?bool $test = null, ?array $partners = null): Model\CreatePlatformPartnersResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformPartners', 'POST', '/platform/partners/batch', ['test' => $test], ['partners' => $partners], Model\CreatePlatformPartnersResponse::class);
    }

    /**
     * 파트너 다건 생성 기능입니다.
     * 새로운 파트너를 다건 생성합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function createPlatformPartnersAsync(?bool $test = null, ?array $partners = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformPartners', 'POST', '/platform/partners/batch', ['test' => $test], ['partners' => $partners], Model\CreatePlatformPartnersResponse::class);
    }

    /**
     * 파트너 일괄 거래처 연동 해제 기능입니다.
     * 파트너들을 일괄 거래처 연동 해제합니다.
     */
    public function disconnectBulkPartnerCounterparty(?bool $test = null, ?array $filter = null): Model\DisconnectBulkPartnerCounterpartyResponse
    {
        return $this->callOperationWithQueryAndBody('disconnectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect', ['test' => $test], ['filter' => $filter], Model\DisconnectBulkPartnerCounterpartyResponse::class);
    }

    /**
     * 파트너 일괄 거래처 연동 해제 기능입니다.
     * 파트너들을 일괄 거래처 연동 해제합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function disconnectBulkPartnerCounterpartyAsync(?bool $test = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('disconnectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect', ['test' => $test], ['filter' => $filter], Model\DisconnectBulkPartnerCounterpartyResponse::class);
    }

    /**
     * 파트너 거래처 연동 해제 기능입니다.
     * 파트너를 거래처 연동 해제합니다.
     */
    public function disconnectPartnerCounterparty(?string $id = null, ?bool $test = null): Model\DisconnectPartnerCounterpartyResponse
    {
        return $this->callOperation('disconnectPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect/{id}', ['id' => $id, 'test' => $test], Model\DisconnectPartnerCounterpartyResponse::class, false);
    }

    /**
     * 파트너 거래처 연동 해제 기능입니다.
     * 파트너를 거래처 연동 해제합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function disconnectPartnerCounterpartyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('disconnectPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect/{id}', ['id' => $id, 'test' => $test], Model\DisconnectPartnerCounterpartyResponse::class, false);
    }

    /**
     * 파트너 조회 기능입니다.
     * 파트너 객체를 조회합니다.
     */
    public function getPlatformPartner(?string $id = null, ?bool $test = null): Model\PlatformPartner
    {
        return $this->callOperation('getPlatformPartner', 'GET', '/platform/partners/{id}', ['id' => $id, 'test' => $test], Model\PlatformPartner::class, false);
    }

    /**
     * 파트너 조회 기능입니다.
     * 파트너 객체를 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformPartnerAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformPartner', 'GET', '/platform/partners/{id}', ['id' => $id, 'test' => $test], Model\PlatformPartner::class, false);
    }

    /**
     * 파트너 다건 조회 기능입니다.
     * 여러 파트너를 조회합니다.
     */
    public function getPlatformPartners(?bool $test = null, ?array $page = null, ?array $filter = null): Model\GetPlatformPartnersResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformPartners', 'GET', '/platform/partners', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformPartnersResponse::class);
    }

    /**
     * 파트너 다건 조회 기능입니다.
     * 여러 파트너를 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformPartnersAsync(?bool $test = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformPartners', 'GET', '/platform/partners', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformPartnersResponse::class);
    }

    /**
     * 파트너 복원 기능입니다.
     * 주어진 아이디에 대응되는 파트너를 복원합니다.
     */
    public function recoverPlatformPartner(?string $id = null, ?bool $test = null): Model\RecoverPlatformPartnerResponse
    {
        return $this->callOperation('recoverPlatformPartner', 'POST', '/platform/partners/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformPartnerResponse::class, false);
    }

    /**
     * 파트너 복원 기능입니다.
     * 주어진 아이디에 대응되는 파트너를 복원합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function recoverPlatformPartnerAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('recoverPlatformPartner', 'POST', '/platform/partners/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformPartnerResponse::class, false);
    }

    /**
     * 파트너 수정 기능입니다.
     * 주어진 아이디에 대응되는 파트너 정보를 업데이트합니다.
     */
    public function updatePlatformPartner(?string $id = null, ?bool $test = null, ?string $name = null, ?array $contact = null, ?array $account = null, ?string $defaultContractId = null, ?string $memo = null, ?array $tags = null, ?array $type = null, ?array $userDefinedProperties = null): Model\UpdatePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformPartner', 'PATCH', '/platform/partners/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Model\UpdatePlatformPartnerResponse::class);
    }

    /**
     * 파트너 수정 기능입니다.
     * 주어진 아이디에 대응되는 파트너 정보를 업데이트합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function updatePlatformPartnerAsync(?string $id = null, ?bool $test = null, ?string $name = null, ?array $contact = null, ?array $account = null, ?string $defaultContractId = null, ?string $memo = null, ?array $tags = null, ?array $type = null, ?array $userDefinedProperties = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformPartner', 'PATCH', '/platform/partners/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Model\UpdatePlatformPartnerResponse::class);
    }
}
