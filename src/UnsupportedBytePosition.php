<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\Bytes;


final class UnsupportedBytePosition extends \OutOfBoundsException
{
    public static function create()
    {
        return new self('Byte position can be only unsigned integer');
    }
}
