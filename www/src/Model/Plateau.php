<?php

namespace MarsRover\Model\Plateau;

use MarsRover\Model\Coordinate;

class Plateau
{
    private $id;
    private $minBorders;
    private $maxBorders;

    public function __construct(int $id, Coordinate $minBordersCoordinate, Coordinate $maxBordersCoordinate)
    {
        $this->id = $id;
        $this->minBorders = $minBordersCoordinate;
        $this->maxBorders = $maxBordersCoordinate;
    }

    public function getMinBorders(): Coordinate
    {
        return $this->minBorders;
    }

    public function getMaxBorders(): Coordinate
    {
        return $this->maxBorders;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return json_encode(array('min' => $this->getMinBorders()->toArray(), 'max' => $this->getMaxBorders()->toArray()));
    }

    public function toArray(): array
    {
        return array('min' => $this->getMinBorders()->toArray(), 'max' => $this->getMaxBorders()->toArray());
    }
}
