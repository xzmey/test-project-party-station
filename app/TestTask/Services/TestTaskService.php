<?php

namespace App\TestTask\Services;

use App\TestTask\Contracts\GateRequestInterface;
use App\TestTask\Requests\SendRequest;

class TestTaskService implements GateRequestInterface
{
    private SendRequest $sendRequest;

    public function __construct(SendRequest $sendRequest)
    {
        $this->sendRequest = $sendRequest;
    }

    public function getListShows(): array
    {
        return $this->sendRequest->get('shows');
    }

    public function getListEvents(int $showId): array
    {
        return $this->sendRequest->get('shows/' . $showId . '/events');
    }

    public function getListPlaces(int $eventId): array
    {
        return $this->sendRequest->get('events/' . $eventId . '/places');
    }

    public function reservePlace(int $eventId, string $name, array $places): array
    {
        $post = [
            'name'      => $name,
            'places'    => $places,
        ];

        return $this->sendRequest->post('events/' . $eventId . '/reserve', [], $post);
    }
}
