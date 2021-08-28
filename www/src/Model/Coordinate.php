<?php

namespace MarsRover\Model;

class Coordinate
{
    private $x;
    private $y;

    public function __construct($x, $y)
    {
        $this->x = (int)$x;
        $this->y = (int)$y;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function toArray(): array
    {
        return array('x' => $this->x, 'y' => $this->y);
    }
}