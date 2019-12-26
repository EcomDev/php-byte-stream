<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\Bytes;


class OutOfRangeException extends \OutOfRangeException
{
    public static function bytesAreTooShort(): self
    {
        return new self('Bytes are shorter then requested slice');
    }

    public static function requestedPositionNotAvailable(): self
    {
        return new self('Requested position is not available in the bytes');
    }
}
