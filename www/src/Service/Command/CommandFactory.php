<?php

namespace MarsRover\Service;

use MarsRover\Model\CommandTypes;

class CommandFactory
{
    public function createCommand(string $commandType): Command
    {
        switch ($commandType) {
            case CommandTypes::MOVE:
                return new Move();
            case CommandTypes::TURN_RIGHT:
                return new TurnRight();
            case CommandTypes::TURN_LEFT:
                return new TurnLeft();
            default:
                throw new \Exception("Invalid Command Type, given: " . $commandType);
        }
    }
}
