<?php

namespace MarsRover\Test\Model;

use MarsRover\Model\Coordinate;
use MarsRover\Model\Plateau\Plateau;
use PHPUnit\Framework\TestCase;

class PlateauTest extends TestCase
{
    public function testHaveMinCoordinateToXAxis()
    {
        $coordinateMin = new Coordinate(1, 1);
        $coordinateMax = new Coordinate(4, 3);
        $plateau = new Plateau(0, $coordinateMin, $coordinateMax);
        $this->assertSame(1, $plateau->getMinBorders()->getX());
    }

    public function testHaveMinCoordinateToYAxis()
    {
        $coordinateMin = new Coordinate(1, 1);
        $coordinateMax = new Coordinate(4, 3);
        $plateau = new Plateau(0, $coordinateMin, $coordinateMax);
        $this->assertSame(1, $plateau->getMinBorders()->getY());
    }

    public function testHaveMaxCoordinateToXAxis()
    {
        $coordinateMin = new Coordinate(1, 1);
        $coordinateMax = new Coordinate(4, 3);
        $plateau = new Plateau(0, $coordinateMin, $coordinateMax);
        $this->assertSame(4, $plateau->getMaxBorders()->getX());
    }

    public function testHaveMaxCoordinateToYAxis()
    {
        $coordinateMin = new Coordinate(1, 1);
        $coordinateMax = new Coordinate(4, 3);
        $plateau = new Plateau(0, $coordinateMin, $coordinateMax);
        $this->assertSame(3, $plateau->getMaxBorders()->getY());
    }
}
