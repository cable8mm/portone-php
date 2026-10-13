<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Exception;

/**
 * 인증 정보가 유효하지 않거나 권한이 없어 PortOne API 요청이 거부되었을 때 발생하는 예외입니다.
 */
final class UnauthorizedException extends PortOneException {}
