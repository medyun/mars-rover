<?php

namespace MarsRover\Test\Service\Command;

use MarsRover\Model\Coordinate;
use MarsRover\Model\Plateau\Plateau;
use MarsRover\Model\Rover;
use MarsRover\Model\RoverSetup;
use MarsRover\Service\CommandFactory;
use PHPUnit\Framework\TestCase;

class TurnLeftTest extends TestCase
{
    public function testCanTurnLeftCorrectly()
    {
        $setup = array(
            'x' => 1,
            'y' => 1,
            'heading' => 'E'
        );
        $plateau = new Plateau(0, new Coordinate(0, 0), new Coordinate(5, 5));

        $rover = new Rover();
        $rover->setSetup(new RoverSetup($setup, $plateau));

        $TurnLeft = (new CommandFactory())->createCommand('L');
        $TurnLeft->execute($rover);

        $this->assertEquals('N', $rover->getSetup()->getDirection()->getHeading());
    }
}
