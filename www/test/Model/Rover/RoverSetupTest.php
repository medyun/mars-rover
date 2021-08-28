<?php

namespace MarsRover\Test\Model;

use MarsRover\Model\Coordinate;
use MarsRover\Model\Direction;
use MarsRover\Model\Plateau\Plateau;
use MarsRover\Model\RoverSetup;
use PHPUnit\Framework\TestCase;

class RoverSetupTest extends TestCase
{
    public function testParseInput()
    {
        $setup = array(
            'x' => 1,
            'y' => 1,
            'heading' => 'E'
        );
        $plateau = new Plateau(0, new Coordinate(0, 0), new Coordinate(5, 5));

        $this->roverSetup = new RoverSetup($setup, $plateau);
        $this->assertTrue(
            $this->roverSetup->getCoordinate() instanceof Coordinate &&
            $this->roverSetup->getDirection() instanceof Direction
        );
    }

    public function testParseSetupToOutput()
    {
        $setup = array(
            'x' => 1,
            'y' => 1,
            'heading' => 'E'
        );
        $plateau = new Plateau(0, new Coordinate(0, 0), new Coordinate(5, 5));


        $this->roverSetup = new RoverSetup($setup, $plateau);
        $this->assertEquals('{"plateauid":0,"x":1,"y":1,"heading":"E"}', $this->roverSetup->__toString());
    }
}
