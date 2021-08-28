<?php

namespace MarsRover\Service;

class CommandsInit
{
    /**
     * @var CommandsCollection
     */
    private $commandsCollection;

    /**
     * @return CommandsCollection
     */
    public function getCommandsCollection(): CommandsCollection
    {
        return $this->commandsCollection;
    }

    public function __construct(string $commandsInput)
    {
        $commandFactory = new CommandFactory();
        $this->commandsCollection = new CommandsCollection();

        $commands = str_split(trim($commandsInput));
        foreach ($commands as $commandType) {

            $newCommand = $commandFactory->createCommand($commandType);
            $this->commandsCollection->append($newCommand);
        }
    }
}
