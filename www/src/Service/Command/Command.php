<?php

namespace MarsRover\Service;

use MarsRover\Model\Rover;

interface Command
{
    public function execute(Rover $rover): bool;
}
