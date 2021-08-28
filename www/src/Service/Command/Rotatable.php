<?php

namespace MarsRover\Service;

abstract class Rotatable
{
    abstract protected function rotateFrom($currentHeading): string;
}