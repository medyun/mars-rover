<?php

namespace MarsRover\Test\Model;

use MarsRover\Model\Direction;
use PHPUnit\Framework\TestCase;

class DirectionTest extends TestCase
{
    public function testThrowsExceptionWhenInvalidOrientationGiven()
    {
        $this->expectException(\Exception::class);
        new Direction("FE");
    }
}
