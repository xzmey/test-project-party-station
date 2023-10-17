<?php

namespace App\TestTask\Http\Controllers;

use App\TestTask\Services\TestTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * @OA\Info(title="API doc", version="0.1")
 */
class TicketGatewayController extends Controller
{
    private TestTaskService $testTaskService;

    public function __construct(TestTaskService $testTaskService)
    {
        $this->testTaskService = $testTaskService;
    }

    /**
     * @OA\Get(
     *     path="/api/get-shows",
     *     tags={"party-station"},
     *     summary="Список мероприятий",
     *     description="Получение списка мероприятий",
     *     operationId="getShows",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example="1"
     *                      ),
     *                  @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Show #1"
     *                      ),
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     ),
     * )
     */
    public function getShows(): JsonResponse
    {
        return response()
            ->json($this->testTaskService->getListShows());
    }

    /**
     * @OA\Get(
     *     path="/api/get-events",
     *     tags={"party-station"},
     *     summary="Список событий",
     *     description="Получение списка событий",
     *     operationId="getEvents",
     *     @OA\Parameter(
     *         name="show_id",
     *         in="query",
     *         description="Id Мероприятия",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example="1"
     *                      ),
     *                  @OA\Property(
     *                         property="show_id",
     *                         type="integer",
     *                         example="1"
     *                      ),
     *                  @OA\Property(
     *                         property="date",
     *                         type="string",
     *                         example="2023-11-12 22:52:18"
     *                      ),
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     ),
     * )
     */
    public function getEvents(Request $request): JsonResponse
    {
        $showId = $request->query('show_id');

        return response()
            ->json($this->testTaskService->getListEvents($showId));
    }

    /**
     * @OA\Get(
     *     path="/api/get-places",
     *     tags={"party-station"},
     *     summary="Список мест",
     *     description="Получение списка мест",
     *     operationId="getPlaces",
     *     @OA\Parameter(
     *         name="event_id",
     *         in="query",
     *         description="Id События",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example="1"
     *                      ),
     *                  @OA\Property(
     *                         property="x",
     *                         type="integer",
     *                         example="0"
     *                      ),
     *                  @OA\Property(
     *                         property="y",
     *                         type="integer",
     *                         example="0"
     *                      ),
     *                  @OA\Property(
     *                         property="width",
     *                         type="integer",
     *                         example="20"
     *                      ),
     *                  @OA\Property(
     *                         property="height",
     *                         type="integer",
     *                         example="20"
     *                      ),
     *                  @OA\Property(
     *                         property="is_available",
     *                         type="bolean",
     *                         example="true"
     *                      ),
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     ),
     * )
     */
    public function getPlaces(Request $request): JsonResponse
    {
        $eventId = $request->query('event_id');

        return response()
            ->json($this->testTaskService->getListPlaces($eventId));
    }

    /**
     * @OA\Post(
     *     path="/api/reserve",
     *     tags={"party-station"},
     *     summary="Бронирование",
     *     description="Забронировать места, для брони нужно имя покупателя",
     *     operationId="reserve",
     *     @OA\RequestBody(
     *         description="Формат входных данных",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="event_id",
     *                     description="Id События",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     description="Имя покупателя",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="places[]",
     *                     description="Массив мест для брони",
     *                     type="array",
     *                      @OA\Items()
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                         property="success",
     *                         type="boolean",
     *                         example="true"
     *                      ),
     *                  @OA\Property(
     *                         property="reservation_id",
     *                         type="integer",
     *                         example="652ee8c5cc144"
     *                      ),
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     ),
     * )
     */
    public function reserve(Request $request): JsonResponse
    {
        $body = $request->all();
        $eventId = $body['event_id'];
        $name = $body['name'];
        $places = $body['places'];

        return response()
            ->json($this->testTaskService->reservePlace($eventId, $name, $places));
    }
}
