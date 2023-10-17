<?php

namespace App\TestTask\Contracts;

interface GateRequestInterface
{
    public function getListShows(): array;

    public function getListEvents(int $showId): array;

    public function getListPlaces(int $eventId): array;

    public function reservePlace(int $eventId, string $name, array $places): array;
}
