<?php

namespace MarsRover\Controller;

use MarsRover\Model\Coordinate;
use MarsRover\Model\Plateau\Plateau;
use MarsRover\Repository\PlateauRepository;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Mars Rover Api", version="1.0.0")
 */

class PlateauController
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
     *     path="/v1/create-plateau",
     *     summary="The process of creating a new plateau",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="x",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="y",
     *                     type="integer"
     *                 ),
     *                 example={"x": 3, "y": 3}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"status": true,"data": {"plateauid": 1},"message": ""}, summary="Success response")
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
    public function createAction()
    {
        try {
            $repoPlateau = new PlateauRepository($this->redis);

            $newPlateauID = $repoPlateau->getNewPlateauID();

            $coordinateMin = new Coordinate(0, 0);
            $coordinateMax = new Coordinate($this->inputs['x'], $this->inputs['y']);
            $newPlateau = new Plateau($newPlateauID, $coordinateMin, $coordinateMax);

            $repoPlateau->createNewPlateau($newPlateauID, $newPlateau);

            $response = array(
                'plateauid' => $newPlateauID
            );

            responseSuccess($response);

        } catch (\Exception $e) {
            error_log('PlateauController:createAction:error => ' . $e->getMessage());
            responseError('Something went wrong => ' . $e->getMessage(), RESPONSE_HEADER_500);
        }
    }

    /**
     * @OA\Post(
     *     path="/v1/get-plateau",
     *     summary="The process of returning the information of a plateau or all plateaus",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="plateauid",
     *                     type="integer"
     *                 ),
     *                 example={"plateauid": 1}
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
    public function getPlateauAction()
    {
        try {
            $plateauList = array();
            $filter = $this->inputs['plateauid'] ?? 0;

            $repoPlateau = new PlateauRepository($this->redis);

            if ($filter == 0) {

                $plateaus = $repoPlateau->getAllPlateaus();
                if ($plateaus != null) {

                    foreach ($plateaus as $plateauID => $plateau) {
                        $plateauData = json_decode($plateau, true);
                        $plateauData['plateauid'] = $plateauID;
                        $plateauList[] = $plateauData;
                    }
                }
            } else {

                $plateau = $repoPlateau->getSinglePlateaus((int)$filter);
                if ($plateau != null) {
                    $plateau = json_decode($plateau, true);
                    $plateau['plateauid'] = $filter;
                    $plateauList[] = $plateau;
                }
            }

            $response = array(
                'plateaus' => $plateauList
            );

            responseSuccess($response);

        } catch (\Exception $e) {
            error_log('PlateauController:getPlateauAction:error => ' . $e->getMessage());
            responseError('Something went wrong => ' . $e->getMessage(), RESPONSE_HEADER_500);
        }
    }
}