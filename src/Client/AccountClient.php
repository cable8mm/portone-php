<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 계좌 API 작업을 제공합니다.
 */
final class AccountClient extends AbstractClient
{
    /**
     * 예금주 조회 기능입니다.
     * 계좌의 예금주를 조회합니다.
     *
     * @param  string|null  $bank  은행
     * @param  string|null  $accountNumber  '-'를 제외한 계좌 번호
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $birthdate  생년월일: 실명 조회를 위해 추가로 보낼 수 있습니다. birthdate과 businessRegistrationNumber 중 하나만 사용해야 합니다.
     * @param  string|null  $businessRegistrationNumber  사업자등록번호: 실명 조회를 위해 추가로 보낼 수 있습니다. birthdate과 businessRegistrationNumber 중 하나만 사용해야 합니다.
     */
    public function getPlatformAccountHolder(?string $bank = null, ?string $accountNumber = null, ?bool $test = null, ?string $birthdate = null, ?string $businessRegistrationNumber = null): Model\PlatformAccountHolder
    {
        return $this->callOperation('getPlatformAccountHolder', 'GET', '/platform/bank-accounts/{bank}/{accountNumber}/holder', ['bank' => $bank, 'accountNumber' => $accountNumber, 'test' => $test, 'birthdate' => $birthdate, 'businessRegistrationNumber' => $businessRegistrationNumber], Model\PlatformAccountHolder::class, false);
    }

    /**
     * 예금주 조회 기능입니다.
     * 계좌의 예금주를 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $bank  은행
     * @param  string|null  $accountNumber  '-'를 제외한 계좌 번호
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $birthdate  생년월일: 실명 조회를 위해 추가로 보낼 수 있습니다. birthdate과 businessRegistrationNumber 중 하나만 사용해야 합니다.
     * @param  string|null  $businessRegistrationNumber  사업자등록번호: 실명 조회를 위해 추가로 보낼 수 있습니다. birthdate과 businessRegistrationNumber 중 하나만 사용해야 합니다.
     */
    public function getPlatformAccountHolderAsync(?string $bank = null, ?string $accountNumber = null, ?bool $test = null, ?string $birthdate = null, ?string $businessRegistrationNumber = null): Future
    {
        return $this->callOperationAsync('getPlatformAccountHolder', 'GET', '/platform/bank-accounts/{bank}/{accountNumber}/holder', ['bank' => $bank, 'accountNumber' => $accountNumber, 'test' => $test, 'birthdate' => $birthdate, 'businessRegistrationNumber' => $businessRegistrationNumber], Model\PlatformAccountHolder::class, false);
    }
}
