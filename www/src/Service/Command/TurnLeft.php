<?php

namespace MarsRover\Service;

use MarsRover\Model\Direction;
use MarsRover\Model\Rover;
use MarsRover\Model\RoverSetup;
use MarsRover\Service\Command;

class TurnLeft extends Rotatable implements Command
{
    public function execute(Rover $rover): bool
    {
        $currentSetup = $rover->getSetup();
        $currentPositionX = $currentSetup->getCoordinate()->getX();
        $currentPositionY = $currentSetup->getCoordinate()->getY();
        $currentHeading = $currentSetup->getDirection()->getHeading();

        $newSetup['x'] = $currentPositionX;
        $newSetup['y'] = $currentPositionY;
        $newSetup['heading'] = $this->rotateFrom($currentHeading);
        $rover->setSetup(new RoverSetup($newSetup, $rover->getSetup()->getPlateau()));

        return true;
    }

    /**
     * @codeCoverageIgnore
     */
    protected function rotateFrom($currentHeading): string
    {
        switch ($currentHeading) {
            case Direction::NORTH:
                return Direction::WEST;
            case Direction::WEST:
                return Direction::SOUTH;
            case Direction::SOUTH:
                return Direction::EAST;
            case Direction::EAST:
                return Direction::NORTH;
        }
    }
}
