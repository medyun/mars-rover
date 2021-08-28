<?php

namespace MarsRover\Test\Service\Command;

use MarsRover\Service\CommandsCollection;
use MarsRover\Service\CommandsInit;
use PHPUnit\Framework\TestCase;

class CommandsInitTest extends TestCase
{
    public function testCanParseValidInputToCommandsCollection()
    {
        $parser = new CommandsInit('MRMLMM');
        $this->assertTrue($parser->getCommandsCollection() instanceof CommandsCollection);
    }
}
