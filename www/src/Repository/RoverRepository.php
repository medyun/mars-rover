<?php

namespace MarsRover\Repository;

class RoverRepository
{

    public $redis;

    public function __construct($redis)
    {
        $this->redis = $redis;
    }

    public function getAllRovers()
    {
        return $this->redis->hGetAll(REDIS_ROVER_LIST);
    }

    public function getSingleRover(int $plateauid)
    {
        return $this->redis->hGet(REDIS_ROVER_LIST, $plateauid);
    }

    public function createNewRower(string $setup)
    {
        $newRoverID = $this->redis->incr(REDIS_LAST_ROVER_ID);
        $this->redis->hSet(REDIS_ROVER_LIST, $newRoverID, $setup);
        return $newRoverID;
    }

    public function setRowerCoordinates($newRoverID, $setup): void
    {
        $this->redis->hSet(REDIS_ROVER_LIST, $newRoverID, $setup);
    }
}
