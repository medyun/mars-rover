<?php

namespace MarsRover\Controller;

use MarsRover\Model\Coordinate;
use MarsRover\Model\Plateau\Plateau;
use MarsRover\Model\Rover;
use MarsRover\Model\RoverSetup;
use MarsRover\Repository\PlateauRepository;
use MarsRover\Repository\RoverRepository;
use MarsRover\Service\CommandsInit;

class CommandController
{
    protected $redis;
    protected $inputs;

    public function __construct($redisConn, $inputs)
    {
        $this->redis = $redisConn;
        $this->inputs = $inputs;
    }

    /**
     * @OA\Post(
     *     path="/v1/send-commands",
     *     summary="The process of sending commands to a rover.",
     *     description="If the rover reaches the border of the plateau during the process and the next command is the Move command, the process is stopped. Commands that have been executed and commands that have not been executed so far are returned in the reply.",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="roverid",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="commands",
     *                     type="string"
     *                 ),
     *                 example={"roverid": 1, "commands": "LMRMM"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"status": true,"data": {"executed": "","notexecuted": "","rover": {"x": 0,"y": 1,"heading": "S"},"plateau": {"min": {"x": 0,"y": 0},"max": {"x": 3,"y": 3}}},"message": ""}, summary="Success response")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Failed",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"status": false,"data": "[]","message": "Something went wrong"}, summary="Failed response")
     *         )
     *     )
     * )
     */
    public function setCommandsAction()
    {
        try {
            $repoRover = new RoverRepository($this->redis);
            $repoPlateau = new PlateauRepository($this->redis);

            $roverData = $repoRover->getSingleRover($this->inputs['roverid']);
            if ($roverData == null) {
                responseError('Rover not found!', RESPONSE_HEADER_400);
            }

            $roverData = json_decode($roverData, true);

            $plateauData = $repoPlateau->getSinglePlateaus($roverData['plateauid']);
            if ($plateauData == null) {
                responseError('Plateau not found!', RESPONSE_HEADER_400);
            }

            $plateauData = json_decode($plateauData, true);

            // New rover create start
            $plateauCoordinateMin = new Coordinate($plateauData['min']['x'], $plateauData['min']['y']);
            $plateauCoordinateMax = new Coordinate($plateauData['max']['y'], $plateauData['max']['y']);
            $plateau = new Plateau($roverData['plateauid'], $plateauCoordinateMin, $plateauCoordinateMax);

            $rover = new Rover();
            $roverSetup = new RoverSetup($roverData, $plateau);

            $rover->setSetup($roverSetup);

            $commandsCollection = (new CommandsInit($this->inputs['commands']))->getCommandsCollection();
            $rover->setCommands($commandsCollection);

            $executedCommandCount = $rover->execute();
            $repoRover->setRowerCoordinates($this->inputs['roverid'], $rover->getSetupAsString());

            $message = '';
            $executedCommantd = '';
            $notExecutedCommantd = '';
            if ($executedCommandCount < count($commandsCollection)) {
                $message = 'The rover reached the plateau limit and some commands could not be executed.';
                $executedCommantd = substr($this->inputs['commands'], 0, $executedCommandCount);
                $notExecutedCommantd = substr($this->inputs['commands'], $executedCommandCount, count($commandsCollection));
            } else {
                $executedCommantd = $this->inputs['commands'];
            }

            $roverLastData = array(
                'x' => $rover->getSetup()->getCoordinate()->getX(),
                'y' => $rover->getSetup()->getCoordinate()->getY(),
                'heading' => $rover->getSetup()->getDirection()->getHeading(),
            );

            $response = array(
                'executed' => $executedCommantd,
                'notexecuted' => $notExecutedCommantd,
                'rover' => $roverLastData,
                'plateau' => $rover->getSetup()->getPlateau()->toArray()
            );

            responseSuccess($response, $message);

        } catch (\Exception $e) {
            error_log('RoverController:getRoverAction:error => ' . $e->getMessage());
            responseError('Something went wrong => ' . $e->getMessage(), RESPONSE_HEADER_500);
        }
    }
}