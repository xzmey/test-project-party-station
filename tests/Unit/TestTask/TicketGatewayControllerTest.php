<?php

namespace Tests\Unit\TestTask;

use App\TestTask\Services\TestTaskService;
use Tests\TestCase;

class TicketGatewayControllerTest extends TestCase {

    public function test_get_shows_should_return_correct_response() {
        $resultArray = [
            [
                "id" => 1,
                "name" => "Show #1"
            ],
            [
                "id" => 2,
                "name" => "Show #2"]
            ,
        ];

        $testTaskServiceMock = \Mockery::mock(TestTaskService::class);
        $testTaskServiceMock->shouldReceive('getListShows')->andReturn($resultArray);
        $this->app->instance(TestTaskService::class, $testTaskServiceMock);

        $userData = $this->get('api/get-shows')->getContent();
        $expected = json_encode($resultArray);

        $this->assertEquals($expected, $userData);
    }

}
