<?php

use Dotenv\Dotenv;

$dotenv = new DotEnv(__DIR__ . '/../');
$dotenv->load();

$redis = new Predis\Client(array(
    "host" => getenv("REDIS_HOST"),
    "port" => getenv("REDIS_PORT"),
    "password" => getenv("REDIS_PASSWORD")
));

if (getenv('ENV') == 'DEV') {
    error_reporting(E_ALL);
}