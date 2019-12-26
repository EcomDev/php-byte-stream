<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\Bytes;

/**
 * Bytes buffer
 *
 * Allows to accumulate multiple bytes into single buffer
 * And provides same api as in bytes
 */
interface Buffer extends Bytes
{
    public function withBytes(Bytes $bytes): Buffer;
}
