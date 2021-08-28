<?php

namespace MarsRover\Test\Service\Command;

use MarsRover\Service\CommandFactory;
use MarsRover\Service\Move;
use MarsRover\Service\TurnLeft;
use MarsRover\Service\TurnRight;
use PHPUnit\Framework\TestCase;

class CommandFactoryTest extends TestCase
{
    public function testIfGiven_M_CommandMoveIsCreated()
    {
        $move = (new CommandFactory())->createCommand('M');
        $this->assertTrue($move instanceof Move);
    }

    public function testIfGiven_L_CommandTurnRightIsCreated()
    {
        $turnLeft = (new CommandFactory())->createCommand('L');
        $this->assertTrue($turnLeft instanceof TurnLeft);
    }

    public function testIfGiven_R_CommandTurnRightIsCreated()
    {
        $turnRight = (new CommandFactory())->createCommand('R');
        $this->assertTrue($turnRight instanceof TurnRight);
    }

    public function testIfGivenInvalidInputThrowsException()
    {
        $this->expectException(\Exception::class);
        (new CommandFactory())->createCommand('S');
    }
}
