<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Exception;

/**
 * PortOne PHP SDK에서 발생하는 예외의 기본 클래스입니다.
 */
class PortOneException extends \RuntimeException
{
    /**
     * PortOneException 객체를 초기화합니다.
     */
    public function __construct(
        string $message,
        public readonly ?int $status = null,
        public readonly ?string $responseBody = null,
        ?\Throwable $previous = null,
        public readonly ?string $errorType = null,
    ) {
        parent::__construct($message, 0, $previous);
    }
}
