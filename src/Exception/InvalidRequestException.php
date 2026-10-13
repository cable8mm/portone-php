<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Exception;

/**
 * 요청 값이 유효하지 않아 PortOne API가 요청을 거부했을 때 발생하는 예외입니다.
 */
final class InvalidRequestException extends PortOneException {}
