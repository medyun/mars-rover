<?php

namespace MarsRover\Repository;

class PlateauRepository
{

    public $redis;

    public function __construct($redis)
    {
        $this->redis = $redis;
    }

    public function getAllPlateaus(): array
    {
        return $this->redis->hGetAll(REDIS_PLATEAU_LIST);
    }

    public function getSinglePlateaus(int $plateauid): string
    {
        return $this->redis->hGet(REDIS_PLATEAU_LIST, $plateauid);
    }

    public function getNewPlateauID(): int
    {
        return (int)$this->redis->incr(REDIS_LAST_PLATEAU_ID);
    }

    public function createNewPlateau($newPlateauID, string $coordinates): void
    {
        $this->redis->hSet(REDIS_PLATEAU_LIST, $newPlateauID, $coordinates);
    }
}
