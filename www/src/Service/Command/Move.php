<?php

namespace MarsRover\Service;

use MarsRover\Model\Direction;
use MarsRover\Model\Rover;
use MarsRover\Model\RoverSetup;

class Move implements Command
{
    public function execute(Rover $rover): bool
    {
        $currentSetup = $rover->getSetup();
        $currentPositionX = $currentSetup->getCoordinate()->getX();
        $currentPositionY = $currentSetup->getCoordinate()->getY();
        $currentHeading = $currentSetup->getDirection()->getHeading();

        switch ($currentHeading) {
            case Direction::EAST:
                $newSetup['x'] = $currentPositionX + 1;
                $newSetup['y'] = $currentPositionY;
                $newSetup['heading'] = $currentHeading;
                break;
            case Direction::WEST:
                $newSetup['x'] = $currentPositionX - 1;
                $newSetup['y'] = $currentPositionY;
                $newSetup['heading'] = $currentHeading;
                break;
            case Direction::NORTH:
                $newSetup['x'] = $currentPositionX;
                $newSetup['y'] = $currentPositionY + 1;
                $newSetup['heading'] = $currentHeading;
                break;
            case Direction::SOUTH:
                $newSetup['x'] = $currentPositionX;
                $newSetup['y'] = $currentPositionY - 1;
                $newSetup['heading'] = $currentHeading;
                break;
        }

        if (
            $newSetup['x'] < $rover->getSetup()->getPlateau()->getMinBorders()->getX() ||
            $newSetup['x'] > $rover->getSetup()->getPlateau()->getMaxBorders()->getX() ||
            $newSetup['y'] < $rover->getSetup()->getPlateau()->getMinBorders()->getY() ||
            $newSetup['y'] > $rover->getSetup()->getPlateau()->getMaxBorders()->getY()
        ){
            return false;
        }

        $rover->setSetup(new RoverSetup($newSetup, $rover->getSetup()->getPlateau()));
        return true;
    }
}
