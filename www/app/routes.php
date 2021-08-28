<?php

$routes['v1'] = array(
    'create-plateau' => array(
        'method' => 'POST',
        'controller' => 'PlateauController',
        'function' => 'createAction'
    ),
    'get-plateau' => array(
        'method' => 'POST',
        'controller' => 'PlateauController',
        'function' => 'getPlateauAction'
    ),
    'create-rover' => array(
        'method' => 'POST',
        'controller' => 'RoverController',
        'function' => 'createRoverAction'
    ),
    'get-rover' => array(
        'method' => 'GET',
        'controller' => 'RoverController',
        'function' => 'getRoverAction'
    ),
    'get-rover-state' => array(
        'method' => 'GET',
        'controller' => 'RoverController',
        'function' => 'getRoverStateAction'
    ),
    'send-commands' => array(
        'method' => 'POST',
        'controller' => 'CommandController',
        'function' => 'setCommandsAction'
    ),
);