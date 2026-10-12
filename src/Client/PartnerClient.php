<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class PartnerClient extends AbstractClient
{
    public function archivePlatformPartner(?string $id = null, ?bool $test = null): Model\ArchivePlatformPartnerResponse
    {
        return $this->callOperation('archivePlatformPartner', 'POST', '/platform/partners/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformPartnerResponse::class, false);
    }

    public function archivePlatformPartnerAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('archivePlatformPartner', 'POST', '/platform/partners/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformPartnerResponse::class, false);
    }

    public function connectBulkPartnerCounterparty(?bool $test = null, ?array $filter = null): Model\ConnectBulkPartnerCounterpartyResponse
    {
        return $this->callOperationWithQueryAndBody('connectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect', ['test' => $test], ['filter' => $filter], Model\ConnectBulkPartnerCounterpartyResponse::class);
    }

    public function connectBulkPartnerCounterpartyAsync(?bool $test = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('connectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect', ['test' => $test], ['filter' => $filter], Model\ConnectBulkPartnerCounterpartyResponse::class);
    }

    public function connectPartnerCounterparty(?string $id = null, ?bool $test = null): Model\ConnectPartnerCounterpartyResponse
    {
        return $this->callOperation('connectPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect/{id}', ['id' => $id, 'test' => $test], Model\ConnectPartnerCounterpartyResponse::class, false);
    }

    public function connectPartnerCounterpartyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('connectPartnerCounterparty', 'POST', '/platform/partners/counterparty-connect/{id}', ['id' => $id, 'test' => $test], Model\ConnectPartnerCounterpartyResponse::class, false);
    }

    public function createPlatformPartner(?bool $test = null, ?string $id = null, ?string $name = null, ?array $contact = null, ?array $account = null, ?string $defaultContractId = null, ?string $memo = null, ?array $tags = null, ?array $type = null, ?array $userDefinedProperties = null): Model\CreatePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformPartner', 'POST', '/platform/partners', ['test' => $test], ['id' => $id, 'name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Model\CreatePlatformPartnerResponse::class);
    }

    public function createPlatformPartnerAsync(?bool $test = null, ?string $id = null, ?string $name = null, ?array $contact = null, ?array $account = null, ?string $defaultContractId = null, ?string $memo = null, ?array $tags = null, ?array $type = null, ?array $userDefinedProperties = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformPartner', 'POST', '/platform/partners', ['test' => $test], ['id' => $id, 'name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Model\CreatePlatformPartnerResponse::class);
    }

    public function createPlatformPartners(?bool $test = null, ?array $partners = null): Model\CreatePlatformPartnersResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformPartners', 'POST', '/platform/partners/batch', ['test' => $test], ['partners' => $partners], Model\CreatePlatformPartnersResponse::class);
    }

    public function createPlatformPartnersAsync(?bool $test = null, ?array $partners = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformPartners', 'POST', '/platform/partners/batch', ['test' => $test], ['partners' => $partners], Model\CreatePlatformPartnersResponse::class);
    }

    public function disconnectBulkPartnerCounterparty(?bool $test = null, ?array $filter = null): Model\DisconnectBulkPartnerCounterpartyResponse
    {
        return $this->callOperationWithQueryAndBody('disconnectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect', ['test' => $test], ['filter' => $filter], Model\DisconnectBulkPartnerCounterpartyResponse::class);
    }

    public function disconnectBulkPartnerCounterpartyAsync(?bool $test = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('disconnectBulkPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect', ['test' => $test], ['filter' => $filter], Model\DisconnectBulkPartnerCounterpartyResponse::class);
    }

    public function disconnectPartnerCounterparty(?string $id = null, ?bool $test = null): Model\DisconnectPartnerCounterpartyResponse
    {
        return $this->callOperation('disconnectPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect/{id}', ['id' => $id, 'test' => $test], Model\DisconnectPartnerCounterpartyResponse::class, false);
    }

    public function disconnectPartnerCounterpartyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('disconnectPartnerCounterparty', 'POST', '/platform/partners/counterparty-disconnect/{id}', ['id' => $id, 'test' => $test], Model\DisconnectPartnerCounterpartyResponse::class, false);
    }

    public function getPlatformPartner(?string $id = null, ?bool $test = null): Model\PlatformPartner
    {
        return $this->callOperation('getPlatformPartner', 'GET', '/platform/partners/{id}', ['id' => $id, 'test' => $test], Model\PlatformPartner::class, false);
    }

    public function getPlatformPartnerAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformPartner', 'GET', '/platform/partners/{id}', ['id' => $id, 'test' => $test], Model\PlatformPartner::class, false);
    }

    public function getPlatformPartners(?bool $test = null, ?array $page = null, ?array $filter = null): Model\GetPlatformPartnersResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformPartners', 'GET', '/platform/partners', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformPartnersResponse::class);
    }

    public function getPlatformPartnersAsync(?bool $test = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformPartners', 'GET', '/platform/partners', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformPartnersResponse::class);
    }

    public function recoverPlatformPartner(?string $id = null, ?bool $test = null): Model\RecoverPlatformPartnerResponse
    {
        return $this->callOperation('recoverPlatformPartner', 'POST', '/platform/partners/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformPartnerResponse::class, false);
    }

    public function recoverPlatformPartnerAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('recoverPlatformPartner', 'POST', '/platform/partners/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformPartnerResponse::class, false);
    }

    public function updatePlatformPartner(?string $id = null, ?bool $test = null, ?string $name = null, ?array $contact = null, ?array $account = null, ?string $defaultContractId = null, ?string $memo = null, ?array $tags = null, ?array $type = null, ?array $userDefinedProperties = null): Model\UpdatePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformPartner', 'PATCH', '/platform/partners/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Model\UpdatePlatformPartnerResponse::class);
    }

    public function updatePlatformPartnerAsync(?string $id = null, ?bool $test = null, ?string $name = null, ?array $contact = null, ?array $account = null, ?string $defaultContractId = null, ?string $memo = null, ?array $tags = null, ?array $type = null, ?array $userDefinedProperties = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformPartner', 'PATCH', '/platform/partners/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'contact' => $contact, 'account' => $account, 'defaultContractId' => $defaultContractId, 'memo' => $memo, 'tags' => $tags, 'type' => $type, 'userDefinedProperties' => $userDefinedProperties], Model\UpdatePlatformPartnerResponse::class);
    }
}
