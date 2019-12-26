<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\Bytes;

final class BufferWithSingleBytesSlice implements Buffer
{
    /**
     * @var Bytes
     */
    private $bytes;

    public function __construct(Bytes $bytes)
    {
        $this->bytes = $bytes;
    }

    /**
     * @inheritDoc
     */
    public function bytes(): iterable
    {
        return $this->bytes->bytes();
    }

    /**
     * @inheritDoc
     */
    public function size(): int
    {
        return $this->bytes->size();
    }

    /**
     * @inheritDoc
     */
    public function asString(): string
    {
        return $this->bytes->asString();
    }

    /**
     * @inheritDoc
     */
    public function sliceFrom(int $position): Bytes
    {
        if ($this->bytes->size() === $position) {
            return new EmptyBuffer();
        }

        return new self($this->bytes->sliceFrom($position));
    }

    /**
     * @inheritDoc
     */
    public function sliceTo(int $length): Bytes
    {
        if ($this->bytes->size() === $length) {
            return new EmptyBuffer();
        }

        return new self($this->bytes->sliceTo($length));
    }

    /**
     * @inheritDoc
     */
    public function peek(int $position): string
    {
        // TODO: Implement peek() method.
    }

    /**
     * @inheritDoc
     */
    public function withBytes(Bytes $bytes): Buffer
    {
        // TODO: Implement withBytes() method.
    }
}
