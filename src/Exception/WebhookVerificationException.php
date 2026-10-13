<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Exception;

/**
 * 웹훅 서명 또는 본문 검증에 실패했을 때 발생하는 예외입니다.
 */
final class WebhookVerificationException extends PortOneException {}
