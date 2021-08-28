<?php

namespace MarsRover\Model;

class Direction
{
    const EAST = "E";
    const WEST = "W";
    const NORTH = "N";
    const SOUTH = "S";

    private $heading = "";

    public function getHeading(): string
    {
        return $this->heading;
    }

    public function __construct(string $heading)
    {
        $heading = trim($heading);
        if ($this->isValid($heading)) {
            $this->heading = $heading;
            return;
        }

        throw new \Exception("Invalid Heading, given: " . $heading);
    }

    private function isValid($heading): bool
    {
        return in_array($heading, [
            self::NORTH,
            self::WEST,
            self::EAST,
            self::SOUTH
        ], true);
    }
}
