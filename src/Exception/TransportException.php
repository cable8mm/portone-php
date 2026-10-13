<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Exception;

/**
 * 네트워크 오류 또는 시간 초과로 PortOne API 요청을 완료하지 못했을 때 발생하는 예외입니다.
 */
final class TransportException extends PortOneException {}
