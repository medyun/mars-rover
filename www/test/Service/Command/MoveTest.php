<?php

namespace MarsRover\Test\Service\Command;

use MarsRover\Model\Coordinate;
use MarsRover\Model\Plateau\Plateau;
use MarsRover\Model\Rover;
use MarsRover\Model\RoverSetup;
use MarsRover\Service\CommandFactory;
use MarsRover\Service\CommandsCollection;
use PHPUnit\Framework\TestCase;

class MoveTest extends TestCase
{
    public function testCanMoveCorrectly()
    {
        $move = (new CommandFactory())->createCommand('M');
        $commandCollection = new CommandsCollection();
        $commandCollection->append($move);

        $setup = array(
            'x' => 1,
            'y' => 1,
            'heading' => 'E'
        );
        $plateau = new Plateau(0, new Coordinate(0, 0), new Coordinate(5, 5));

        $Rover = new Rover();
        $Rover->setSetup(new RoverSetup($setup, $plateau));
        $Rover->setCommands($commandCollection);
        $Rover->execute();

        $this->expectOutputString('{"plateauid":0,"x":2,"y":1,"heading":"E"}');
        echo $Rover->getSetupAsString();
    }
}
