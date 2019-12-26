<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\Bytes;


class OutOfBoundsException extends \OutOfBoundsException
{
    public static function onlyInPositiveRange()
    {
        return new self('Slice can only be in positive range');
    }

    public static function positionShouldBeAlwaysPositive()
    {
        return new self('Position should be always a positive integer');
    }
}
