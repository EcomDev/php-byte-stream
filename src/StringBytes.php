<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\Bytes;

use function substr;

/**
 * Implementation of bytes based on string value
 */
final class StringBytes implements Bytes
{
    /**
     * @var string
     */
    private $bytes;

    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $offset = 0;

    /**
     * @var int
     */
    private $limit;

    public function __construct(string $bytes, int $size)
    {
        $this->bytes = $bytes;
        $this->size = $size;
        $this->limit = $size;
    }

    /**
     * @inheritDoc
     */
    public function bytes(): iterable
    {
        for ($position = $this->offset; $position < $this->limit; $position ++) {
            yield $this->bytes[$position];
        }
    }

    /**
     * @inheritDoc
     */
    public function size(): int
    {
        return $this->limit - $this->offset;
    }

    /**
     * @inheritDoc
     */
    public function sliceFrom(int $position): Bytes
    {
        return $this->slice($position, null);
    }

    /**
     * @inheritDoc
     */
    public function sliceTo(int $length): Bytes
    {
        return $this->slice(0, $length);
    }

    /**
     * Creates a specific slice
     *
     * @param int $offset
     * @param int $limit
     *
     * @return Bytes
     */
    private function slice(int $offset, ?int $limit = null): Bytes
    {
        $limit = $limit ?? ($this->limit - $this->offset - $offset);
        $offset += $this->offset;
        $limit += $offset;

        if ($offset < 0 || $limit < 0) {
            throw OutOfBoundsException::onlyInPositiveRange();
        }

        if ($limit > $this->size || $offset > $this->size) {
            throw OutOfRangeException::bytesAreTooShort();
        }

        $slice = new self($this->bytes, $this->size);
        $slice->offset = $offset;
        $slice->limit = $limit;

        return $slice;
    }

    /**
     * String representation of current bytes scope
     *
     * @return string
     */
    public function asString(): string
    {
        return substr($this->bytes, $this->offset, $this->limit - $this->offset);
    }

    /**
     * @inheritDoc
     */
    public function peek(int $position): string
    {
        if ($position < 0) {
            throw OutOfBoundsException::positionShouldBeAlwaysPositive();
        }

        $position += $this->offset;

        if ($position >= $this->limit) {
            throw OutOfRangeException::requestedPositionNotAvailable();
        }

        return $this->bytes[$position];
    }
}
