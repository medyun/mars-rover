<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/config.php';
require __DIR__ . '/../util.php';
require __DIR__ . '/routes.php';
require __DIR__ . '/../src/Config/RedisConfig.php';
require __DIR__ . '/../src/Config/ResponseConfig.php';
require __DIR__ . '/../src/Controller/PlateauController.php';
require __DIR__ . '/../src/Controller/RoverController.php';
require __DIR__ . '/../src/Controller/CommandController.php';
require __DIR__ . '/../src/Repository/PlateauRepository.php';
require __DIR__ . '/../src/Repository/RoverRepository.php';
require __DIR__ . '/../src/Model/Coordinate.php';
require __DIR__ . '/../src/Model/Plateau.php';
require __DIR__ . '/../src/Model/Rover/Rover.php';
require __DIR__ . '/../src/Model/Rover/RoverSetup.php';
require __DIR__ . '/../src/Model/Direction/Direction.php';
require __DIR__ . '/../src/Model/Command/CommandTypes.php';
require __DIR__ . '/../src/Service/Command/Command.php';
require __DIR__ . '/../src/Service/Command/CommandFactory.php';
require __DIR__ . '/../src/Service/Command/CommandsCollection.php';
require __DIR__ . '/../src/Service/Command/CommandsInit.php';
require __DIR__ . '/../src/Service/Command/Move.php';
require __DIR__ . '/../src/Service/Command/Rotatable.php';
require __DIR__ . '/../src/Service/Command/TurnLeft.php';
require __DIR__ . '/../src/Service/Command/TurnRight.php';
