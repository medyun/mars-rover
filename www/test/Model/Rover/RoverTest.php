<?php

namespace MarsRover\Test\Model;

use MarsRover\Model\Coordinate;
use MarsRover\Model\Plateau\Plateau;
use MarsRover\Model\Rover;
use MarsRover\Model\RoverSetup;
use MarsRover\Service\CommandsInit;
use PHPUnit\Framework\TestCase;

class RoverTest extends TestCase
{
    public function setUp()
    {
        $this->rover = new Rover();
    }

    public function testAcceptsRoverSetup()
    {
        $setup = array(
            'x' => 3,
            'y' => 3,
            'heading' => 'E'
        );
        $plateau = new Plateau(0, new Coordinate(0, 0), new Coordinate(3, 3));

        $this->rover->setSetup(new RoverSetup($setup, $plateau));
        $this->assertTrue($this->rover->getSetup() instanceof RoverSetup);
    }

    public function testExecuteCommands()
    {
        $setup = array(
            'x' => 1,
            'y' => 1,
            'heading' => 'E'
        );
        $plateau = new Plateau(0, new Coordinate(0, 0), new Coordinate(5, 5));

        $this->rover->setSetup(new RoverSetup($setup, $plateau));
        $this->rover->setCommands((new CommandsInit("MMLMMR"))->getCommandsCollection());
        $this->rover->execute();

        $this->expectOutputString('{"plateauid":0,"x":3,"y":3,"heading":"E"}');
        echo $this->rover->getSetupAsString();
    }
}
