<?php

namespace MarsRover\Model;

use MarsRover\Service\CommandsCollection;

class Rover
{
    /**
     * @var RoverSetup
     */
    private $setup;

    /**
     * @var CommandsCollection
     */
    private $commands;

    public function getSetup(): RoverSetup
    {
        return $this->setup;
    }

    public function setCommands(CommandsCollection $commands): void
    {
        $this->commands = $commands;
    }

    public function getCommands(): CommandsCollection
    {
        return $this->commands;
    }

    public function setSetup(RoverSetup $roverSetup): void
    {
        $this->setup = $roverSetup;
    }

    public function execute(): int
    {
        $processedCommands = 0;
        $iterator = $this->commands->getIterator();
        $iterator->rewind();

        while ($iterator->valid()) {
            $command = $iterator->current();
            $isSuccess = $command->execute($this);
            if (!$isSuccess) {
                break;
            }

            $processedCommands++;
            $iterator->next();
        }

        return $processedCommands;
    }

    public function getSetupAsString(): string
    {
        return $this->setup;
    }
}
