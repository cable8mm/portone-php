<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 이체 API 작업을 제공합니다.
 */
final class TransferClient extends AbstractClient
{
    /**
     * 수기 정산건 생성 기능입니다.
     * 성공 응답으로 생성된 수기 정산건 객체가 반환됩니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $partnerId  파트너 아이디
     * @param  string|null  $memo  메모
     * @param  int|null  $settlementAmount  정산 금액
     * @param  int|null  $settlementTaxFreeAmount  정산 면세 금액
     * @param  string|null  $settlementDate  정산 일: 날짜를 나타내는 문자열로, `yyyy-MM-dd` 형식을 따릅니다.
     * @param  bool|null  $isForTest  테스트 모드 여부: Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $userDefinedProperties  사용자 정의 속성
     * @param  string|null  $id  생성할 정산건 아이디: 명시하지 않으면 id 가 임의로 생성됩니다.
     * @param  string|null  $settlementCurrency  통화
     */
    public function createPlatformManualTransfer(?bool $test = null, ?string $partnerId = null, ?string $memo = null, ?int $settlementAmount = null, ?int $settlementTaxFreeAmount = null, ?string $settlementDate = null, ?bool $isForTest = null, ?array $userDefinedProperties = null, ?string $id = null, ?string $settlementCurrency = null): Model\CreateManualTransferResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformManualTransfer', 'POST', '/platform/transfers/manual', ['test' => $test], ['partnerId' => $partnerId, 'memo' => $memo, 'settlementAmount' => $settlementAmount, 'settlementTaxFreeAmount' => $settlementTaxFreeAmount, 'settlementDate' => $settlementDate, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id, 'settlementCurrency' => $settlementCurrency], Model\CreateManualTransferResponse::class);
    }

    /**
     * 수기 정산건 생성 기능입니다.
     * 성공 응답으로 생성된 수기 정산건 객체가 반환됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $partnerId  파트너 아이디
     * @param  string|null  $memo  메모
     * @param  int|null  $settlementAmount  정산 금액
     * @param  int|null  $settlementTaxFreeAmount  정산 면세 금액
     * @param  string|null  $settlementDate  정산 일: 날짜를 나타내는 문자열로, `yyyy-MM-dd` 형식을 따릅니다.
     * @param  bool|null  $isForTest  테스트 모드 여부: Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $userDefinedProperties  사용자 정의 속성
     * @param  string|null  $id  생성할 정산건 아이디: 명시하지 않으면 id 가 임의로 생성됩니다.
     * @param  string|null  $settlementCurrency  통화
     */
    public function createPlatformManualTransferAsync(?bool $test = null, ?string $partnerId = null, ?string $memo = null, ?int $settlementAmount = null, ?int $settlementTaxFreeAmount = null, ?string $settlementDate = null, ?bool $isForTest = null, ?array $userDefinedProperties = null, ?string $id = null, ?string $settlementCurrency = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformManualTransfer', 'POST', '/platform/transfers/manual', ['test' => $test], ['partnerId' => $partnerId, 'memo' => $memo, 'settlementAmount' => $settlementAmount, 'settlementTaxFreeAmount' => $settlementTaxFreeAmount, 'settlementDate' => $settlementDate, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id, 'settlementCurrency' => $settlementCurrency], Model\CreateManualTransferResponse::class);
    }

    /**
     * 주문 취소 정산건 생성 기능입니다.
     * 성공 응답으로 생성된 주문 취소 정산건 객체가 반환됩니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $partnerId  파트너 아이디
     * @param  string|null  $paymentId  결제 아이디
     * @param  string|null  $transferId  정산건 아이디
     * @param  string|null  $cancellationId  취소 내역 아이디
     * @param  string|null  $memo  메모
     * @param  array<string, mixed>|null  $orderDetail  주문 취소 정보: orderAmount, orderLines, all 중에서 하나만 입력하여야 합니다.
     * @param  int|null  $taxFreeAmount  주문 취소 면세 금액: 주문 취소 항목과 취소 면세 금액을 같이 전달하시면 최종 취소 면세 금액은 주문 취소 항목의 면세 금액이 아닌 전달해주신 취소 면세 금액으로 적용됩니다.
     * @param  array<string, mixed>|null  $discounts  할인 정보
     * @param  string|null  $settlementStartDate  정산 시작일: 날짜를 나타내는 문자열로, `yyyy-MM-dd` 형식을 따릅니다.
     * @param  string|null  $settlementDate  정산일: 날짜를 나타내는 문자열로, `yyyy-MM-dd` 형식을 따릅니다.
     * @param  array<string, mixed>|null  $externalCancellationDetail  외부 결제 상세 정보: 해당 정보가 존재하는 경우 외부 결제 취소 정산건으로 등록되고, 존재하지않은 경우 포트원 결제 취소 정산건으로 등록됩니다.
     * @param  bool|null  $isForTest  테스트 모드 여부: Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $userDefinedProperties  사용자 정의 속성
     * @param  string|null  $id  생성할 취소 정산건 아이디: 명시하지 않으면 id 가 임의로 생성됩니다.
     */
    public function createPlatformOrderCancelTransfer(?bool $test = null, ?string $partnerId = null, ?string $paymentId = null, ?string $transferId = null, ?string $cancellationId = null, ?string $memo = null, ?array $orderDetail = null, ?int $taxFreeAmount = null, ?array $discounts = null, ?string $settlementStartDate = null, ?string $settlementDate = null, ?array $externalCancellationDetail = null, ?bool $isForTest = null, ?array $userDefinedProperties = null, ?string $id = null): Model\CreateOrderCancelTransferResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformOrderCancelTransfer', 'POST', '/platform/transfers/order-cancel', ['test' => $test], ['partnerId' => $partnerId, 'paymentId' => $paymentId, 'transferId' => $transferId, 'cancellationId' => $cancellationId, 'memo' => $memo, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'discounts' => $discounts, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'externalCancellationDetail' => $externalCancellationDetail, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Model\CreateOrderCancelTransferResponse::class);
    }

    /**
     * 주문 취소 정산건 생성 기능입니다.
     * 성공 응답으로 생성된 주문 취소 정산건 객체가 반환됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $partnerId  파트너 아이디
     * @param  string|null  $paymentId  결제 아이디
     * @param  string|null  $transferId  정산건 아이디
     * @param  string|null  $cancellationId  취소 내역 아이디
     * @param  string|null  $memo  메모
     * @param  array<string, mixed>|null  $orderDetail  주문 취소 정보: orderAmount, orderLines, all 중에서 하나만 입력하여야 합니다.
     * @param  int|null  $taxFreeAmount  주문 취소 면세 금액: 주문 취소 항목과 취소 면세 금액을 같이 전달하시면 최종 취소 면세 금액은 주문 취소 항목의 면세 금액이 아닌 전달해주신 취소 면세 금액으로 적용됩니다.
     * @param  array<string, mixed>|null  $discounts  할인 정보
     * @param  string|null  $settlementStartDate  정산 시작일: 날짜를 나타내는 문자열로, `yyyy-MM-dd` 형식을 따릅니다.
     * @param  string|null  $settlementDate  정산일: 날짜를 나타내는 문자열로, `yyyy-MM-dd` 형식을 따릅니다.
     * @param  array<string, mixed>|null  $externalCancellationDetail  외부 결제 상세 정보: 해당 정보가 존재하는 경우 외부 결제 취소 정산건으로 등록되고, 존재하지않은 경우 포트원 결제 취소 정산건으로 등록됩니다.
     * @param  bool|null  $isForTest  테스트 모드 여부: Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $userDefinedProperties  사용자 정의 속성
     * @param  string|null  $id  생성할 취소 정산건 아이디: 명시하지 않으면 id 가 임의로 생성됩니다.
     */
    public function createPlatformOrderCancelTransferAsync(?bool $test = null, ?string $partnerId = null, ?string $paymentId = null, ?string $transferId = null, ?string $cancellationId = null, ?string $memo = null, ?array $orderDetail = null, ?int $taxFreeAmount = null, ?array $discounts = null, ?string $settlementStartDate = null, ?string $settlementDate = null, ?array $externalCancellationDetail = null, ?bool $isForTest = null, ?array $userDefinedProperties = null, ?string $id = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformOrderCancelTransfer', 'POST', '/platform/transfers/order-cancel', ['test' => $test], ['partnerId' => $partnerId, 'paymentId' => $paymentId, 'transferId' => $transferId, 'cancellationId' => $cancellationId, 'memo' => $memo, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'discounts' => $discounts, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'externalCancellationDetail' => $externalCancellationDetail, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Model\CreateOrderCancelTransferResponse::class);
    }

    /**
     * 주문 정산건 생성 기능입니다.
     * 성공 응답으로 생성된 주문 정산건 객체가 반환됩니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $partnerId  파트너 아이디
     * @param  string|null  $contractId  기본값은 파트너의 기본 계약 아이디 입니다.
     * @param  string|null  $memo  메모
     * @param  string|null  $paymentId  결제 아이디
     * @param  array<string, mixed>|null  $orderDetail  주문 정보: 주문 금액 또는 주문 항목 하나만 입력 가능합니다.
     * @param  int|null  $taxFreeAmount  주문 면세 금액: 주문 항목과 면세 금액을 같이 전달하시면 최종 면세 금액은 주문 항목의 면세 금액이 아닌 전달해주신 면세 금액으로 적용됩니다.
     * @param  string|null  $settlementStartDate  정산 시작일: 날짜를 나타내는 문자열로, `yyyy-MM-dd` 형식을 따릅니다.
     * @param  string|null  $settlementDate  정산일: 날짜를 나타내는 문자열로, `yyyy-MM-dd` 형식을 따릅니다.
     * @param  array<string, mixed>|null  $discounts  할인 정보
     * @param  array<string, mixed>|null  $additionalFees  추가 수수료 정보
     * @param  array<string, mixed>|null  $externalPaymentDetail  외부 결제 상세 정보: 해당 정보가 존재하는 경우 외부 결제 정산건 으로 등록되고, 존재하지않은 경우 포트원 결제 정산건으로 등록됩니다.
     * @param  bool|null  $isForTest  테스트 모드 여부: Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $parameters  정산 파라미터 (실험기능)
     * @param  array<string, mixed>|null  $userDefinedProperties  사용자 정의 속성
     * @param  string|null  $id  생성할 정산건 아이디: 명시하지 않으면 id 가 임의로 생성됩니다.
     */
    public function createPlatformOrderTransfer(?bool $test = null, ?string $partnerId = null, ?string $contractId = null, ?string $memo = null, ?string $paymentId = null, ?array $orderDetail = null, ?int $taxFreeAmount = null, ?string $settlementStartDate = null, ?string $settlementDate = null, ?array $discounts = null, ?array $additionalFees = null, ?array $externalPaymentDetail = null, ?bool $isForTest = null, ?array $parameters = null, ?array $userDefinedProperties = null, ?string $id = null): Model\CreateOrderTransferResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformOrderTransfer', 'POST', '/platform/transfers/order', ['test' => $test], ['partnerId' => $partnerId, 'contractId' => $contractId, 'memo' => $memo, 'paymentId' => $paymentId, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'discounts' => $discounts, 'additionalFees' => $additionalFees, 'externalPaymentDetail' => $externalPaymentDetail, 'isForTest' => $isForTest, 'parameters' => $parameters, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Model\CreateOrderTransferResponse::class);
    }

    /**
     * 주문 정산건 생성 기능입니다.
     * 성공 응답으로 생성된 주문 정산건 객체가 반환됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $partnerId  파트너 아이디
     * @param  string|null  $contractId  기본값은 파트너의 기본 계약 아이디 입니다.
     * @param  string|null  $memo  메모
     * @param  string|null  $paymentId  결제 아이디
     * @param  array<string, mixed>|null  $orderDetail  주문 정보: 주문 금액 또는 주문 항목 하나만 입력 가능합니다.
     * @param  int|null  $taxFreeAmount  주문 면세 금액: 주문 항목과 면세 금액을 같이 전달하시면 최종 면세 금액은 주문 항목의 면세 금액이 아닌 전달해주신 면세 금액으로 적용됩니다.
     * @param  string|null  $settlementStartDate  정산 시작일: 날짜를 나타내는 문자열로, `yyyy-MM-dd` 형식을 따릅니다.
     * @param  string|null  $settlementDate  정산일: 날짜를 나타내는 문자열로, `yyyy-MM-dd` 형식을 따릅니다.
     * @param  array<string, mixed>|null  $discounts  할인 정보
     * @param  array<string, mixed>|null  $additionalFees  추가 수수료 정보
     * @param  array<string, mixed>|null  $externalPaymentDetail  외부 결제 상세 정보: 해당 정보가 존재하는 경우 외부 결제 정산건 으로 등록되고, 존재하지않은 경우 포트원 결제 정산건으로 등록됩니다.
     * @param  bool|null  $isForTest  테스트 모드 여부: Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $parameters  정산 파라미터 (실험기능)
     * @param  array<string, mixed>|null  $userDefinedProperties  사용자 정의 속성
     * @param  string|null  $id  생성할 정산건 아이디: 명시하지 않으면 id 가 임의로 생성됩니다.
     */
    public function createPlatformOrderTransferAsync(?bool $test = null, ?string $partnerId = null, ?string $contractId = null, ?string $memo = null, ?string $paymentId = null, ?array $orderDetail = null, ?int $taxFreeAmount = null, ?string $settlementStartDate = null, ?string $settlementDate = null, ?array $discounts = null, ?array $additionalFees = null, ?array $externalPaymentDetail = null, ?bool $isForTest = null, ?array $parameters = null, ?array $userDefinedProperties = null, ?string $id = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformOrderTransfer', 'POST', '/platform/transfers/order', ['test' => $test], ['partnerId' => $partnerId, 'contractId' => $contractId, 'memo' => $memo, 'paymentId' => $paymentId, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'discounts' => $discounts, 'additionalFees' => $additionalFees, 'externalPaymentDetail' => $externalPaymentDetail, 'isForTest' => $isForTest, 'parameters' => $parameters, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Model\CreateOrderTransferResponse::class);
    }

    /**
     * 정산건 삭제 기능입니다.
     * scheduled, in_process 상태의 정산건만 삭제가능합니다.
     *
     * @param  string|null  $id  정산건 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function deletePlatformTransfer(?string $id = null, ?bool $test = null): Model\DeletePlatformTransferResponse
    {
        return $this->callOperation('deletePlatformTransfer', 'DELETE', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Model\DeletePlatformTransferResponse::class, false);
    }

    /**
     * 정산건 삭제 기능입니다.
     * scheduled, in_process 상태의 정산건만 삭제가능합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  정산건 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function deletePlatformTransferAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('deletePlatformTransfer', 'DELETE', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Model\DeletePlatformTransferResponse::class, false);
    }

    /**
     * 정산 상세 내역 다운로드 기능입니다.
     * 정산 상세 내역을 csv 파일로 다운로드 합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $filter  정산건 필터 입력 정보: 정산 시작일 범위와 정산 일 범위는 둘 중 하나만 입력 가능합니다.
     * @param  array<string, mixed>|null  $fields  다운로드할 시트 컬럼
     */
    public function downloadPlatformTransferSheet(?bool $test = null, ?array $filter = null, ?array $fields = null): string
    {
        return $this->callStringOperationWithQueryRequestBody('downloadPlatformTransferSheet', 'GET', '/platform/transfer-summaries/sheet-file', ['test' => $test], ['filter' => $filter, 'fields' => $fields]);
    }

    /**
     * 정산 상세 내역 다운로드 기능입니다.
     * 정산 상세 내역을 csv 파일로 다운로드 합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $filter  정산건 필터 입력 정보: 정산 시작일 범위와 정산 일 범위는 둘 중 하나만 입력 가능합니다.
     * @param  array<string, mixed>|null  $fields  다운로드할 시트 컬럼
     */
    public function downloadPlatformTransferSheetAsync(?bool $test = null, ?array $filter = null, ?array $fields = null): Future
    {
        return $this->callStringOperationWithQueryRequestBodyAsync('downloadPlatformTransferSheet', 'GET', '/platform/transfer-summaries/sheet-file', ['test' => $test], ['filter' => $filter, 'fields' => $fields]);
    }

    /**
     * 정산건 조회 기능입니다.
     * 정산건을 조회합니다.
     *
     * @param  string|null  $id  조회하고 싶은 정산건 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function getPlatformTransfer(?string $id = null, ?bool $test = null): Model\PlatformTransfer
    {
        return $this->callOperation('getPlatformTransfer', 'GET', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Model\PlatformTransfer::class, false);
    }

    /**
     * 정산건 조회 기능입니다.
     * 정산건을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  조회하고 싶은 정산건 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function getPlatformTransferAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformTransfer', 'GET', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Model\PlatformTransfer::class, false);
    }

    /**
     * 정산건 다건 조회 기능입니다.
     * 성공 응답으로 조회된 정산건 요약 리스트와 페이지 정보가 반환됩니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  정산건 필터 입력 정보: 정산 시작일 범위와 정산 일 범위는 둘 중 하나만 입력 가능합니다.
     */
    public function getPlatformTransferSummaries(?bool $test = null, ?array $page = null, ?array $filter = null): Model\GetPlatformTransferSummariesResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformTransferSummaries', 'GET', '/platform/transfer-summaries', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformTransferSummariesResponse::class);
    }

    /**
     * 정산건 다건 조회 기능입니다.
     * 성공 응답으로 조회된 정산건 요약 리스트와 페이지 정보가 반환됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  정산건 필터 입력 정보: 정산 시작일 범위와 정산 일 범위는 둘 중 하나만 입력 가능합니다.
     */
    public function getPlatformTransferSummariesAsync(?bool $test = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformTransferSummaries', 'GET', '/platform/transfer-summaries', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformTransferSummariesResponse::class);
    }
}
