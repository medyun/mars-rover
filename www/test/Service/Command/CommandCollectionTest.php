<?php

namespace MarsRover\Test\Service\Command;

use MarsRover\Service\CommandsCollection;
use MarsRover\Service\Move;
use MarsRover\Service\TurnLeft;
use MarsRover\Service\TurnRight;
use PHPUnit\Framework\TestCase;

class CommandCollectionTest extends TestCase
{
    public function testIsPossibleToAddOneCommand()
    {
        $commandCollection = new CommandsCollection();
        $commandCollection->append(new Move());

        $this->expectOutputString(1);
        echo $commandCollection->count();
    }

    public function testIsPossibleToAddMoreThanOneCommand()
    {
        $CommandCollection = new CommandsCollection();
        $CommandCollection->append(new Move());
        $CommandCollection->append(new TurnLeft());
        $CommandCollection->append(new TurnRight());

        $this->expectOutputString(3);
        echo $CommandCollection->count();
    }
}
