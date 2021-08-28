<?php

namespace MarsRover\Test\Model;

use MarsRover\Model\Coordinate;
use PHPUnit\Framework\TestCase;

class CoordinateTest extends TestCase
{
    public function testCanHandleInputReturningIntegerToXPosition()
    {
        $coordinate = new Coordinate(1, 2);
        $this->assertSame(1, $coordinate->getX());
    }

    public function testCanHandleInputReturningIntegerToYPosition()
    {
        $coordinate = new Coordinate(1, 2);
        $this->assertSame(2, $coordinate->getY());
    }
}
