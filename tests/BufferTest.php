<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\Bytes;

use PHPUnit\Framework\TestCase;

/**
 * Class BufferTest
 */
class BufferTest extends TestCase
{
    /**
     * @var BytesFactory
     */
    private $factory;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->factory = new BytesFactory();
    }

    /** @test */
    public function emptyBufferReportsSizeOfZero()
    {
        $this->assertEquals(
            0,
            $this->factory->createBuffer()->size()
        );
    }

    /** @test */
    public function emptyBufferReturnsEmptyBytesList()
    {
        $this->assertIterable([], $this->factory->createBuffer()->bytes());
    }
    
    /** @test */
    public function emptyBufferSlicingFromWithNegativePositionErrorsOut()
    {
        $this->expectException(OutOfBoundsException::class);

        $this->factory->createBuffer()->sliceFrom(-1);
    }
    
    /** @test */
    public function slicingEmptyBufferWithAnyPositivePositionErrorsOut()
    {
        $this->expectException(OutOfRangeException::class);

        $this->factory->createBuffer()->sliceFrom(0);
    }


    /** @test */
    public function emptyBufferSlicingToWithNegativePositionErrorsOut()
    {
        $this->expectException(OutOfBoundsException::class);

        $this->factory->createBuffer()->sliceTo(-1);
    }

    /** @test */
    public function slicingEmptyBufferToAnyPositivePositionErrorsOut()
    {
        $this->expectException(OutOfRangeException::class);

        $this->factory->createBuffer()->sliceTo(1);
    }

    /** @test */
    public function emptyBufferIsInspectedAsEmptyString()
    {
        $this->assertEquals(
            '',
            $this->factory->createBuffer()->asString()
        );
    }

    /** @test */
    public function emptyBufferPeekWithNegativePositionErrorsOut()
    {
        $this->expectException(OutOfBoundsException::class);

        $this->factory->createBuffer()->peek(-1);
    }

    /** @test */
    public function peekEmptyBufferAtAnyPositionErrorsOut()
    {
        $this->expectException(OutOfRangeException::class);

        $this->factory->createBuffer()->peek(1);
    }

    /** @test */
    public function singleByteSliceBufferReportsSizeOfBytesInIt()
    {
        $buffer = $this->factory->createBuffer()
            ->withBytes(
                $this->factory->createBytesFromString('Slice 1')
            );

        $this->assertEquals(7, $buffer->size());
    }
    
    /** @test */
    public function returnsIterableBytesFromByteSlice()
    {
        $buffer = $this->factory->createBuffer()
            ->withBytes(
                $this->factory->createBytesFromString('I am a string')
            );

        $this->assertBytes('I am a string', $buffer);
    }
    
    /** @test */
    public function inspectsBytesAsStringFromSingleAssignedBytes()
    {
        $buffer = $this->factory->createBuffer()
            ->withBytes(
                $this->factory->createBytesFromString('Another string')
            )
        ;

        $this->assertEquals('Another string', $buffer->asString());
    }

    /** @test */
    public function sliceFromReturnsBufferWithNewFromSingleBytesSlice()
    {
        $buffer = $this->factory->createBuffer()
            ->withBytes(
                $this->factory->createBytesFromString('String one')
            )
        ;

        $this->assertEquals(
            'one',
            $buffer->sliceFrom(7)->asString()
        );
    }

    /** @test */
    public function sliceToReturnsBufferWithNewToBytesSlice()
    {
        $buffer = $this->factory->createBuffer()
            ->withBytes(
                $this->factory->createBytesFromString('One and the only one')
            )
        ;

        $this->assertEquals(
            'One and the only',
            $buffer->sliceTo(16)->asString()
        );
    }

    /** @test */
    public function emptyBufferIsReturnedAsSliceWhenAllBytesAreProcessed()
    {
        $this->assertEquals(
            $this->factory->createBuffer(),
            $this->factory->createBuffer()
                ->withBytes($this->factory->createBytesFromString('Some discarded bytes'))
                ->sliceFrom(20)
        );
    }
    
    /** @test */
    public function emptyBufferIsReturnedWhenSliceToTheEndOfBuffer()
    {
        $this->assertEquals(
            $this->factory->createBuffer(),
            $this->factory->createBuffer()
                ->withBytes($this->factory->createBytesFromString('Five5'))
                ->sliceTo(5)
        );
    }
    
    /**
     * Asserts iterable result
     */
    private function assertIterable(array $expectedResult, iterable $actualResult): void
    {
        $this->assertEquals(
            $actualResult instanceof \Traversable ? iterator_to_array($actualResult) : $actualResult,
            $expectedResult
        );
    }

    /**
     * Asserts bytes of byte stream
     */
    private function assertBytes(string $expectedBytes, Bytes $actualResult): void
    {
        $this->assertIterable(str_split($expectedBytes), $actualResult->bytes());
    }
}
