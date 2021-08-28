# Mars Rovers

## Run the Program
The program can be easily made working with docker. The following commands need to be run sequentially.
```
// docker up
docker-compose up --build &

// get into container
docker exec -it hp_webserver bash

// create settings file
cp .env.example .env

// install required packages
composer update
```

After Docker is up, you can access the project from the domain http://localhost:9971/.

There are 6 calls. You can access the detailed usage documentation of these calls from the http://localhost:9971/swagger/#/ link.

## Requests
  Request | Description
  --- | ---
  `/v1/create-plateau` | The process of creating a new plateau
  `/v1/get-plateau` | The process of returning the information of a plateau or all plateaus
  `/v1/create-rover` | The process of creating a new rover within a desired plateau
  `/v1/get-rover?roverid={id}` | Process fetching all of a rover's information
  `/v1/get-rover-state?roverid={id}` | Process fetching all of a rover's information about its state
  `/v1/send-commands` | The process of sending commands to a rover.

## Test Results
```
PHPUnit 7.5.20 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.2.31 with Xdebug 2.9.6
Configuration: /var/www/html/phpunit.xml

.....................                                             21 / 21 (100%)

Time: 356 ms, Memory: 4.00 MB

OK (21 tests, 21 assertions)

```