<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\Bytes;

use function strlen;

/**
 * Factory for creating bytes from input data
 */
class BytesFactory
{
    public function createBytesFromString(string $data): Bytes
    {
        return new StringBytes($data, strlen($data));
    }

    public function createBuffer(): Buffer
    {
        return new EmptyBuffer();
    }
}
