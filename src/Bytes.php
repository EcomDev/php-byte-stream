<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\Bytes;

/**
 * Stream of bytes
 */
interface Bytes
{
    /**
     * Iterates over bytes
     *
     * @return iterable
     */
    public function bytes(): iterable;

    /**
     * Returns total bytes size
     *
     * @return int
     */
    public function size(): int;

    /**
     * Creates a new byte slice from a specified position
     *
     * @param int $position
     *
     * @return Bytes
     */
    public function sliceFrom(int $position): Bytes;

    /**
     * Creates a new byte slice for a specified length
     *
     * @param int $length
     *
     * @return Bytes
     */
    public function sliceTo(int $length): Bytes;

    /**
     * String representation of current bytes scope
     *
     * @return string
     */
    public function asString(): string;
}
