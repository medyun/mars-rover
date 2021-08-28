<?php

namespace MarsRover\Controller;

use MarsRover\Model\Coordinate;
use MarsRover\Model\Plateau\Plateau;
use MarsRover\Model\Rover;
use MarsRover\Model\RoverSetup;
use MarsRover\Repository\PlateauRepository;
use MarsRover\Repository\RoverRepository;

class RoverController
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
     *     path="/v1/create-rover",
     *     summary="The process of creating a new rover within a desired plateau",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="plateauid",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="x",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="y",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="heading",
     *                     type="string"
     *                 ),
     *                 example={"plateauid": 1, "x": 0, "y": 1, "heading": "E"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value="", summary="Success response")
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
    public function createRoverAction()
    {
        try {
            $repoPlateau = new PlateauRepository($this->redis);
            $repoRover = new RoverRepository($this->redis);

            $plateauData = $repoPlateau->getSinglePlateaus($this->inputs['plateauid']);
            if ($plateauData == null) {
                responseError('Plateau not found!', RESPONSE_HEADER_400);
            }

            $plateauData = json_decode($plateauData, true);

            if (
                $this->inputs['x'] < $plateauData['min']['x'] ||
                $this->inputs['x'] > $plateauData['max']['x'] ||
                $this->inputs['y'] < $plateauData['min']['y'] ||
                $this->inputs['y'] > $plateauData['max']['y']
            ) {
                responseError('Coordinates wrong!', RESPONSE_HEADER_400);
            }

            // New rover create start
            $plateauCoordinateMin = new Coordinate($plateauData['min']['x'], $plateauData['min']['y']);
            $plateauCoordinateMax = new Coordinate($plateauData['max']['y'], $plateauData['max']['y']);
            $plateau = new Plateau((int)$this->inputs['plateauid'], $plateauCoordinateMin, $plateauCoordinateMax);

            $newRover = new Rover();
            $newRoverSetup = new RoverSetup($this->inputs, $plateau);
            $newRover->setSetup($newRoverSetup);

            $newRoverID = $repoRover->createNewRower($newRover->getSetupAsString());

            $response = array(
                'roverid' => $newRoverID,
                'plateauid' => $newRoverSetup->getPlateau()->getId(),
                'x' => $newRoverSetup->getCoordinate()->getX(),
                'y' => $newRoverSetup->getCoordinate()->getY(),
                'heading' => $newRoverSetup->getDirection()->getHeading(),
            );

            responseSuccess($response);

        } catch (\Exception $e) {
            error_log('RoverController:createRoverAction:error => ' . $e->getMessage());
            responseError('Something went wrong => ' . $e->getMessage(), RESPONSE_HEADER_500);
        }
    }

    /**
     * @OA\Get(
     *     path="/v1/get-rover?roverid={id}",
     *     summary="Process fetching all of a rover's information",
     *     @OA\Parameter(
     *         description="Parameters",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         @OA\Examples(example="int", value="1", summary="An int value."),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"status": true,"data": {"x": 0,"y": 1,"heading": "E","plateauid": 1},"message": ""}, summary="Success response")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Failed",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"status": false,"data": "[]","message": "Rover not found!"}, summary="Failed response")
     *         )
     *     )
     * )
     */
    public function getRoverAction(){
        $this->getRoverDataAction();
    }

    /**
     * @OA\Get(
     *     path="/v1/get-rover-state?roverid={id}",
     *     summary="Process fetching all of a rover's information",
     *     @OA\Parameter(
     *         description="Parameters",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         @OA\Examples(example="int", value="1", summary="An int value."),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"status": true,"data": {"x": 0,"y": 1,"heading": "E","plateauid": 1},"message": ""}, summary="Success response")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Failed",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"status": false,"data": "[]","message": "Rover not found!"}, summary="Failed response")
     *         )
     *     )
     * )
     */
    public function getRoverStateAction(){
        $this->getRoverDataAction(false);
    }

    public function getRoverDataAction($isJustState = false)
    {
        try {
            $repoRover = new RoverRepository($this->redis);

            $roverData = $repoRover->getSingleRover($this->inputs['roverid']);
            if ($roverData == null) {
                responseError('Rover not found!', RESPONSE_HEADER_400);
            }

            $roverData = json_decode($roverData, true);

            $response = array(
                'x' => $roverData['x'],
                'y' => $roverData['y'],
            );

            if (!$isJustState) {
                $response['heading'] = $roverData['heading'];
                $response['plateauid'] = $roverData['plateauid'];
            }

            responseSuccess($response);

        } catch (\Exception $e) {
            error_log('RoverController:getRoverAction:error => ' . $e->getMessage());
            responseError('Something went wrong => ' . $e->getMessage(), RESPONSE_HEADER_500);
        }
    }
}