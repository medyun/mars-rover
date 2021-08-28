<?php

namespace MarsRover\Model;

use MarsRover\Model\Plateau\Plateau;

class RoverSetup
{
    private $plateau;
    private $coordinate;
    private $direction;

    public function __construct(array $setup, Plateau $plateau)
    {
        $this->coordinate = new Coordinate($setup['x'], $setup['y']);
        $this->direction = new Direction($setup['heading']);
        $this->plateau = $plateau;
    }

    public function __toString(): string
    {
        $data = array(
            'plateauid' => $this->getPlateau()->getId(),
            'x' => $this->coordinate->getX(),
            'y' => $this->coordinate->getY(),
            'heading' => $this->direction->getHeading()
        );
        return json_encode($data);
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function getDirection(): Direction
    {
        return $this->direction;
    }

    public function getPlateau(): Plateau
    {
        return $this->plateau;
    }
}
