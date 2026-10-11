<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class PartnerClient extends AbstractClient
{
    public function archivePlatformPartner(?string $id = null, ?bool $test = null): Response\ArchivePlatformPartnerResponse
    {
        return $this->callOperation('archivePlatformPartner', 'POST', '/platform/partners/{id}/archive', ['id' => $id, 'test' => $test], Response\ArchivePlatformPartnerResponse::class, false);
    }

    public function archivePlatformPartnerAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('archivePlatformPartner', 'POST', '/platform/partners/{id}/archive', ['id' => $id, 'test' => $test], Response\ArchivePlatformPartnerResponse::class, false);
    }

    public function connectBulkPartnerCounterparty(?bool $test = null, ?array $filter = null): Response\ConnectBulkPartnerCounterpartyResponse
    {
        return $this->callOperationWithQueryAndBody('connectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect', ['test' => $test], ['filter' => $filter], Response\ConnectBulkPartnerCounterpartyResponse::class);
    }

    public function connectBulkPartnerCounterpartyAsync(?bool $test = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('connectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect', ['test' => $test], ['filter' => $filter], Response\ConnectBulkPartnerCounterpartyResponse::class);
    }

    public function connectPartnerCounterparty(?string $id = null, ?bool $test = null): Response\ConnectPartnerCounterpartyResponse
    {
        return $this->callOperation('connectPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect/{id}', ['id' => $id, 'test' => $test], Response\ConnectPartnerCounterpartyResponse::class, false);
    }

    public function connectPartnerCounterpartyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('connectPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect/{id}', ['id' => $id, 'test' => $test], Response\ConnectPartnerCounterpartyResponse::class, false);
    }

    public function createPlatformPartner(?bool $test = null, ?string $id = null, ?string $name = null, ?array $contact = null, ?array $account = null, ?string $defaultContractId = null, ?string $memo = null, ?array $tags = null, ?array $type = null, ?array $userDefinedProperties = null): Response\CreatePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformPartner', 'POST', '/platform/partners', ['test' => $test], ['id' => $id, 'name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Response\CreatePlatformPartnerResponse::class);
    }

    public function createPlatformPartnerAsync(?bool $test = null, ?string $id = null, ?string $name = null, ?array $contact = null, ?array $account = null, ?string $defaultContractId = null, ?string $memo = null, ?array $tags = null, ?array $type = null, ?array $userDefinedProperties = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformPartner', 'POST', '/platform/partners', ['test' => $test], ['id' => $id, 'name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Response\CreatePlatformPartnerResponse::class);
    }

    public function createPlatformPartners(?bool $test = null, ?array $partners = null): Response\CreatePlatformPartnersResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformPartners', 'POST', '/platform/partners/batch', ['test' => $test], ['partners' => $partners], Response\CreatePlatformPartnersResponse::class);
    }

    public function createPlatformPartnersAsync(?bool $test = null, ?array $partners = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformPartners', 'POST', '/platform/partners/batch', ['test' => $test], ['partners' => $partners], Response\CreatePlatformPartnersResponse::class);
    }

    public function disconnectBulkPartnerCounterparty(?bool $test = null, ?array $filter = null): Response\DisconnectBulkPartnerCounterpartyResponse
    {
        return $this->callOperationWithQueryAndBody('disconnectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect', ['test' => $test], ['filter' => $filter], Response\DisconnectBulkPartnerCounterpartyResponse::class);
    }

    public function disconnectBulkPartnerCounterpartyAsync(?bool $test = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('disconnectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect', ['test' => $test], ['filter' => $filter], Response\DisconnectBulkPartnerCounterpartyResponse::class);
    }

    public function disconnectPartnerCounterparty(?string $id = null, ?bool $test = null): Response\DisconnectPartnerCounterpartyResponse
    {
        return $this->callOperation('disconnectPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect/{id}', ['id' => $id, 'test' => $test], Response\DisconnectPartnerCounterpartyResponse::class, false);
    }

    public function disconnectPartnerCounterpartyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('disconnectPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect/{id}', ['id' => $id, 'test' => $test], Response\DisconnectPartnerCounterpartyResponse::class, false);
    }

    public function getPlatformPartner(?string $id = null, ?bool $test = null): Response\PlatformPartner
    {
        return $this->callOperation('getPlatformPartner', 'GET', '/platform/partners/{id}', ['id' => $id, 'test' => $test], Response\PlatformPartner::class, false);
    }

    public function getPlatformPartnerAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformPartner', 'GET', '/platform/partners/{id}', ['id' => $id, 'test' => $test], Response\PlatformPartner::class, false);
    }

    public function getPlatformPartners(?bool $test = null, ?array $page = null, ?array $filter = null): Response\GetPlatformPartnersResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformPartners', 'GET', '/platform/partners', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformPartnersResponse::class);
    }

    public function getPlatformPartnersAsync(?bool $test = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformPartners', 'GET', '/platform/partners', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformPartnersResponse::class);
    }

    public function recoverPlatformPartner(?string $id = null, ?bool $test = null): Response\RecoverPlatformPartnerResponse
    {
        return $this->callOperation('recoverPlatformPartner', 'POST', '/platform/partners/{id}/recover', ['id' => $id, 'test' => $test], Response\RecoverPlatformPartnerResponse::class, false);
    }

    public function recoverPlatformPartnerAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('recoverPlatformPartner', 'POST', '/platform/partners/{id}/recover', ['id' => $id, 'test' => $test], Response\RecoverPlatformPartnerResponse::class, false);
    }

    public function updatePlatformPartner(?string $id = null, ?bool $test = null, ?string $name = null, ?array $contact = null, ?array $account = null, ?string $defaultContractId = null, ?string $memo = null, ?array $tags = null, ?array $type = null, ?array $userDefinedProperties = null): Response\UpdatePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformPartner', 'PATCH', '/platform/partners/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Response\UpdatePlatformPartnerResponse::class);
    }

    public function updatePlatformPartnerAsync(?string $id = null, ?bool $test = null, ?string $name = null, ?array $contact = null, ?array $account = null, ?string $defaultContractId = null, ?string $memo = null, ?array $tags = null, ?array $type = null, ?array $userDefinedProperties = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformPartner', 'PATCH', '/platform/partners/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Response\UpdatePlatformPartnerResponse::class);
    }
}
