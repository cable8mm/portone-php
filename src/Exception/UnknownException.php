<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Exception;

/**
 * 작업별로 정의되지 않은 PortOne API 오류 응답을 나타내는 예외입니다.
 */
final class UnknownException extends PortOneException
{
    /**
     * UnknownException 객체를 초기화합니다.
     */
    public function __construct(
        public readonly string $operation,
        string $message,
        ?int $status = null,
        ?string $responseBody = null,
        ?\Throwable $previous = null,
        ?string $errorType = null,
    ) {
        parent::__construct($message, $status, $responseBody, $previous, $errorType);
    }
}
