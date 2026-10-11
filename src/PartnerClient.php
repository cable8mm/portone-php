<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class PartnerClient extends AbstractClient
{
    public function archivePlatformPartner(mixed $id = null, mixed $test = null): Response\ArchivePlatformPartnerResponse
    {
        return $this->callOperation('archivePlatformPartner', 'POST', '/platform/partners/{id}/archive', ['id' => $id, 'test' => $test], Response\ArchivePlatformPartnerResponse::class, false);
    }

    public function archivePlatformPartnerAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('archivePlatformPartner', 'POST', '/platform/partners/{id}/archive', ['id' => $id, 'test' => $test], Response\ArchivePlatformPartnerResponse::class, false);
    }

    public function connectBulkPartnerCounterparty(mixed $test = null, mixed $filter = null): Response\ConnectBulkPartnerCounterpartyResponse
    {
        return $this->callOperationWithQueryAndBody('connectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect', ['test' => $test], ['filter' => $filter], Response\ConnectBulkPartnerCounterpartyResponse::class);
    }

    public function connectBulkPartnerCounterpartyAsync(mixed $test = null, mixed $filter = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('connectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect', ['test' => $test], ['filter' => $filter], Response\ConnectBulkPartnerCounterpartyResponse::class);
    }

    public function connectPartnerCounterparty(mixed $id = null, mixed $test = null): Response\ConnectPartnerCounterpartyResponse
    {
        return $this->callOperation('connectPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect/{id}', ['id' => $id, 'test' => $test], Response\ConnectPartnerCounterpartyResponse::class, false);
    }

    public function connectPartnerCounterpartyAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('connectPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect/{id}', ['id' => $id, 'test' => $test], Response\ConnectPartnerCounterpartyResponse::class, false);
    }

    public function createPlatformPartner(mixed $test = null, mixed $id = null, mixed $name = null, mixed $contact = null, mixed $account = null, mixed $defaultContractId = null, mixed $memo = null, mixed $tags = null, mixed $type = null, mixed $userDefinedProperties = null): Response\CreatePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformPartner', 'POST', '/platform/partners', ['test' => $test], ['id' => $id, 'name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Response\CreatePlatformPartnerResponse::class);
    }

    public function createPlatformPartnerAsync(mixed $test = null, mixed $id = null, mixed $name = null, mixed $contact = null, mixed $account = null, mixed $defaultContractId = null, mixed $memo = null, mixed $tags = null, mixed $type = null, mixed $userDefinedProperties = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformPartner', 'POST', '/platform/partners', ['test' => $test], ['id' => $id, 'name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Response\CreatePlatformPartnerResponse::class);
    }

    public function createPlatformPartners(mixed $test = null, mixed $partners = null): Response\CreatePlatformPartnersResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformPartners', 'POST', '/platform/partners/batch', ['test' => $test], ['partners' => $partners], Response\CreatePlatformPartnersResponse::class);
    }

    public function createPlatformPartnersAsync(mixed $test = null, mixed $partners = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformPartners', 'POST', '/platform/partners/batch', ['test' => $test], ['partners' => $partners], Response\CreatePlatformPartnersResponse::class);
    }

    public function disconnectBulkPartnerCounterparty(mixed $test = null, mixed $filter = null): Response\DisconnectBulkPartnerCounterpartyResponse
    {
        return $this->callOperationWithQueryAndBody('disconnectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect', ['test' => $test], ['filter' => $filter], Response\DisconnectBulkPartnerCounterpartyResponse::class);
    }

    public function disconnectBulkPartnerCounterpartyAsync(mixed $test = null, mixed $filter = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('disconnectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect', ['test' => $test], ['filter' => $filter], Response\DisconnectBulkPartnerCounterpartyResponse::class);
    }

    public function disconnectPartnerCounterparty(mixed $id = null, mixed $test = null): Response\DisconnectPartnerCounterpartyResponse
    {
        return $this->callOperation('disconnectPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect/{id}', ['id' => $id, 'test' => $test], Response\DisconnectPartnerCounterpartyResponse::class, false);
    }

    public function disconnectPartnerCounterpartyAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('disconnectPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect/{id}', ['id' => $id, 'test' => $test], Response\DisconnectPartnerCounterpartyResponse::class, false);
    }

    public function getPlatformPartner(mixed $id = null, mixed $test = null): Response\PlatformPartner
    {
        return $this->callOperation('getPlatformPartner', 'GET', '/platform/partners/{id}', ['id' => $id, 'test' => $test], Response\PlatformPartner::class, false);
    }

    public function getPlatformPartnerAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('getPlatformPartner', 'GET', '/platform/partners/{id}', ['id' => $id, 'test' => $test], Response\PlatformPartner::class, false);
    }

    public function getPlatformPartners(mixed $test = null, mixed $page = null, mixed $filter = null): Response\GetPlatformPartnersResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformPartners', 'GET', '/platform/partners', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformPartnersResponse::class);
    }

    public function getPlatformPartnersAsync(mixed $test = null, mixed $page = null, mixed $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformPartners', 'GET', '/platform/partners', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformPartnersResponse::class);
    }

    public function recoverPlatformPartner(mixed $id = null, mixed $test = null): Response\RecoverPlatformPartnerResponse
    {
        return $this->callOperation('recoverPlatformPartner', 'POST', '/platform/partners/{id}/recover', ['id' => $id, 'test' => $test], Response\RecoverPlatformPartnerResponse::class, false);
    }

    public function recoverPlatformPartnerAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('recoverPlatformPartner', 'POST', '/platform/partners/{id}/recover', ['id' => $id, 'test' => $test], Response\RecoverPlatformPartnerResponse::class, false);
    }

    public function updatePlatformPartner(mixed $id = null, mixed $test = null, mixed $name = null, mixed $contact = null, mixed $account = null, mixed $defaultContractId = null, mixed $memo = null, mixed $tags = null, mixed $type = null, mixed $userDefinedProperties = null): Response\UpdatePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformPartner', 'PATCH', '/platform/partners/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Response\UpdatePlatformPartnerResponse::class);
    }

    public function updatePlatformPartnerAsync(mixed $id = null, mixed $test = null, mixed $name = null, mixed $contact = null, mixed $account = null, mixed $defaultContractId = null, mixed $memo = null, mixed $tags = null, mixed $type = null, mixed $userDefinedProperties = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformPartner', 'PATCH', '/platform/partners/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Response\UpdatePlatformPartnerResponse::class);
    }
}
