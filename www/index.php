<?php

declare(strict_types=1);

// imports START
require __DIR__ . '/app/imports.php';
require __DIR__ . '/app/configure.php';
// imports END

// request configuration START
$requestMethod = getRequestMethod();
$uri = getUris();

$version = DEFAULT_VERSION;
if (isset($uri[0]) && in_array($uri[0], VERSIONS)) {
    $version = $uri[0];
}

$command = '';
if (isset($uri[1])) {
    $command = $uri[1];
}
// request configuration END

// request controls START
if (!isset($routes[$version][$command])) {
    responseError('Command not found! - ' . $command, RESPONSE_HEADER_400);
}

if ($routes[$version][$command]['method'] != $requestMethod) {
    responseError('Method not allowed!', RESPONSE_HEADER_400);
}

if ($requestMethod == 'POST') {
    $inputs = createUserFromRequest();
} else {
    $inputs = getQueryStringParams();
}
// request controls END

// processes START
$controllerName = $routes[$version][$command]['controller'];
$controllerFunc = $routes[$version][$command]['function'];

try {
    $class = new ReflectionClass('MarsRover\Controller\\' . $controllerName);
    $controller = $class->newInstance($redis, $inputs);
    $controller->$controllerFunc();
} catch (Exception $e) {
    responseError('Something went wrong :( => ' . $e->getMessage(), RESPONSE_HEADER_400);
}
// processes END