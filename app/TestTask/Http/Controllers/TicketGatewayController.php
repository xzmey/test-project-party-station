<?php

namespace App\TestTask\Http\Controllers;

use App\TestTask\Services\TestTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TicketGatewayController extends Controller
{
    private TestTaskService $testTaskService;

    public function __construct(TestTaskService $testTaskService)
    {
        $this->testTaskService = $testTaskService;
    }

    public function getShows(): JsonResponse
    {
        return response()
            ->json($this->testTaskService->getListShows());
    }

    public function getEvents(Request $request): JsonResponse
    {
        $showId = $request->query('show_id');

        return response()
            ->json($this->testTaskService->getListEvents($showId));
    }

    public function getPlaces(Request $request): JsonResponse
    {
        $eventId = $request->query('event_id');

        return response()
            ->json($this->testTaskService->getListPlaces($eventId));
    }

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
