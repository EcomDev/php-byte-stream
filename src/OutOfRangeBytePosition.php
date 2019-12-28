<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\Bytes;


final class OutOfRangeBytePosition extends \OutOfRangeException
{
    public static function create(): self
    {
        return new self('Supplied byte position is outside of available byte range');
    }
}
