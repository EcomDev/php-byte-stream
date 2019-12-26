<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\Bytes;

final class EmptyBuffer implements Buffer
{
    public function withBytes(Bytes $bytes): Buffer
    {
        return new BufferWithSingleBytesSlice($bytes);
    }

    /**
     * @inheritDoc
     */
    public function bytes(): iterable
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function size(): int
    {
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function sliceFrom(int $position): Bytes
    {
        $this->errorOnPositionAccess($position);
    }

    /**
     * @inheritDoc
     */
    public function sliceTo(int $length): Bytes
    {
        $this->errorOnPositionAccess($length);
    }

    /**
     * @inheritDoc
     */
    public function peek(int $position): string
    {
        $this->errorOnPositionAccess($position);
    }

    /**
     * @inheritDoc
     */
    public function asString(): string
    {
        return '';
    }

    /**
     * Returns errors based on position supplied as an argument
     *
     * @param int $position
     */
    private function errorOnPositionAccess(int $position)
    {
        if ($position >=  0) {
            throw OutOfRangeException::bytesAreTooShort();
        }

        throw OutOfBoundsException::onlyInPositiveRange();
    }
}
