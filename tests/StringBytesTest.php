<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\Bytes;

use PHPUnit\Framework\TestCase;

/**
 * Bytes test
 */
class StringBytesTest extends TestCase
{
    /**
     * @var BytesFactory
     */
    private $factory;

    protected function setUp(): void
    {
        $this->factory = new BytesFactory();
    }

    /** @test */
    public function emptyBytesForEmptyString()
    {
        $this->assertIterable([], $this->factory->createBytesFromString('')->bytes());
    }

    /** @test */
    public function zeroSizeForEmptyString()
    {
        $this->assertEquals(0, $this->factory->createBytesFromString('')->size());
    }

    /** @test */
    public function iteratesOverByteStreamForSingleACharacter()
    {
        $this->assertIterable(['a'], $this->factory->createBytesFromString('a')->bytes());
    }

    /** @test */
    public function returnsOriginalStringSize()
    {
        $this->assertEquals(5, $this->factory->createBytesFromString('abcde')->size());
    }

    /** @test */
    public function iteratesOverEveryByteInTheString()
    {
        $this->assertIterable(['a', 'b', 'c', 'd', 'e', 'f', 'g'], $this->factory->createBytesFromString('abcdefg')->bytes());
    }

    /** @test */
    public function sliceFromZeroEqualsTheSameString()
    {
        $this->assertEquals(
            $this->factory->createBytesFromString('i am a string slice'),
            $this->factory->createBytesFromString('i am a string slice')->sliceFrom(0)
        );
    }

    /** @test */
    public function slicesFromPosition()
    {
        $this->assertBytes(
            'slice',
            $this->factory->createBytesFromString('i am a string slice')
                ->sliceFrom(14)
        );
    }

    /** @test */
    public function sliceReportsSizeOfASliceNotTheOriginal()
    {
        $this->assertEquals(
            5,
            $this->factory->createBytesFromString('i am a slice')->sliceFrom(7)->size()
        );
    }

    /** @test */
    public function createsDoubleFromSlice()
    {
        $this->assertBytes(
            'second part',
            $this->factory->createBytesFromString('i am a first part second part')
                ->sliceFrom(7)
                ->sliceFrom(11)
        );
    }


    /** @test */
    public function errorsOnOutOfBoundsFromSlice()
    {
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage('Bytes are shorter then requested slice');

        $this->factory->createBytesFromString('I am short string')
            ->sliceFrom(10)
            ->sliceFrom(8);
    }

    /** @test */
    public function sliceToTheSameLengthResultsInTheSameSliceAsOriginal()
    {
        $this->assertEquals(
            $this->factory->createBytesFromString('Original slice'),
            $this->factory->createBytesFromString('Original slice')
                ->sliceTo(14)
        );
    }
    
    /** @test */
    public function slicesToIgnoresBytesAfterSpecifiedLength()
    {
        $this->assertBytes(
            'Only this visible',
            $this->factory->createBytesFromString('Only this visible, not the rest')->sliceTo(17)
        );
    }
    
    /** @test */
    public function slicesToAndFromBytes()
    {
        $this->assertBytes(
            'Middle part.',
            $this->factory->createBytesFromString('Not visible. Middle part. Not visible')
                ->sliceFrom(13)
                ->sliceTo(12)
        );
    }
    
    /** @test */
    public function errorsOnOutOfBoundToSlice()
    {
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage('Bytes are shorter then requested slice');

        $this->factory->createBytesFromString('I am short string')
            ->sliceFrom(10)
            ->sliceTo(8);
    }
    
    /** @test */
    public function sliceOrderDoesNotMatter()
    {
        $this->assertBytes(
            'in the middle',
            $this->factory->createBytesFromString('The most interesting, in the middle, of the text')
                ->sliceTo(35)
                ->sliceFrom(22)
        );
    }

    /** @test */
    public function errorsOnOutOnNegativeFromSlice()
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Slice can only be in positive range');

        $this->factory->createBytesFromString('I am short string')
            ->sliceFrom(-10);
    }

    /** @test */
    public function errorsOnOutOnNegativeToSlice()
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Slice can only be in positive range');

        $this->factory->createBytesFromString('I am short string')
            ->sliceTo(-10);
    }
    
    /** @test */
    public function sizeOfCombinedSliceEqualsToByteSizeOfIt()
    {
        $this->assertEquals(
            13,
            $this->factory->createBytesFromString('First part, in the middle, second part')
                ->sliceTo(25)
                ->sliceFrom(12)
                ->size()
        );
    }

    /** @test */
    public function allowsToInspectBytesSliceAsString()
    {
        $this->assertEquals(
            'I am a string.',
            $this->factory->createBytesFromString('Some noise at start. I am a string. Noise in the end.')
                ->sliceFrom(21)
                ->sliceTo(14)
                ->asString()
        );
    }

    /** @test */
    public function allowsToPeekIntoFirstCharacterOfAString()
    {
        $this->assertEquals(
            'a',
            $this->factory->createBytesFromString('abcde')
                ->peek(0)
        );
    }
    
    /** @test */
    public function allowsToPeekIntoTheEndOfTheString()
    {
        $this->assertEquals(
            'e',
            $this->factory->createBytesFromString('abcde')
                ->peek(4)
        );
    }

    /** @test */
    public function negativeOffsetErrorsDuringPeek()
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Position should be always a positive integer');

        $this->factory->createBytesFromString('some-data')
            ->peek(-1);
    }

    /** @test */
    public function outOfBoundPeekOperationTriggersAnError()
    {
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage('Requested position is not available in the bytes');

        $this->factory->createBytesFromString('Data of 11b')->peek(11);
    }
    
    /** @test */
    public function slicedFromBytesArePeekedRelatively()
    {
        $this->assertEquals(
            'A',
            $this->factory
                ->createBytesFromString('I am not picked slice A I am rest of the slice')
                ->sliceFrom(20)
                ->peek(2)
        );
    }

    /** @test */
    public function slicedToLimitsPickedBytesAfterLastCharacter()
    {
        $slice = $this->factory->createBytesFromString('I am short slice')->sliceTo(10);
        $slice->peek(9);

        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage('Requested position is not available in the bytes');

        $slice->peek(10);
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
