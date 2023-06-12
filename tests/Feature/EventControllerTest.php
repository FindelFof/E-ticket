<?php

namespace Tests\Feature;

use App\Core\UseCases\EventSearch\EventSearchUseCase;
use App\Http\Controllers\EventController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Response;
use Illuminate\Testing\TestResponse;
use Mockery;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\App\Http\Middleware\Authenticate::class);
    }

    public function testIndex()
    {
        $eventSearchUseCase = Mockery::mock(EventSearchUseCase::class);
        $eventSearchUseCase->shouldReceive('findAll')->once()->andReturn([]);

        $controller = new EventController($eventSearchUseCase);
        $response = $controller->index();

        $testResponse = TestResponse::fromBaseResponse($response);
        $testResponse->assertStatus(200)
            ->assertJson([
                'message' => 'All events',
                'data' => [],
            ]);
    }


    public function testShowWithExistingEvent()
    {
        $eventId = 1;
        $eventSearchUseCase = Mockery::mock(EventSearchUseCase::class);
        $eventSearchUseCase->shouldReceive('findById')->once()->with($eventId)->andReturn(['id' => $eventId]);

        $controller = new EventController($eventSearchUseCase);
        $response = $controller->show($eventId);

        $testResponse = TestResponse::fromBaseResponse($response);
        $testResponse->assertStatus(200)
            ->assertJson([
                'message' => 'Event found',
                'data' => ['id' => $eventId],
            ]);
    }

    public function testShowWithNonExistingEvent()
    {
        $eventId = 1;
        $eventSearchUseCase = Mockery::mock(EventSearchUseCase::class);
        $eventSearchUseCase->shouldReceive('findById')->once()->with($eventId)->andReturn(null);

        $controller = new EventController($eventSearchUseCase);
        $response = $controller->show($eventId);

        $testResponse = TestResponse::fromBaseResponse($response);
        $testResponse->assertNotFound()
            ->assertJson([
                'message' => 'Event not found',
            ]);
    }

    public function testSearchByCity()
    {
        $city = 'Korhogo';
        $eventSearchUseCase = Mockery::mock(EventSearchUseCase::class);
        $eventSearchUseCase->shouldReceive('searchByCity')->once()->with($city)->andReturn([]);

        $controller = new EventController($eventSearchUseCase);
        $response = $controller->searchByCity($this->createRequestWithInput('city', $city));

        $testResponse = TestResponse::fromBaseResponse($response);
        $testResponse->assertStatus(200)
            ->assertJson([
                'message' => 'Events found by city',
                'data' => [],
            ]);
    }

    public function testSearchByLocation()
    {
        $location = 'Hôtel Ivoire';
        $eventSearchUseCase = Mockery::mock(EventSearchUseCase::class);
        $eventSearchUseCase->shouldReceive('searchByLocation')->once()->with($location)->andReturn([]);

        $controller = new EventController($eventSearchUseCase);
        $response = $controller->searchByLocation($this->createRequestWithInput('location', $location));

        $testResponse = TestResponse::fromBaseResponse($response);
        $testResponse->assertStatus(200)
            ->assertJson([
                'message' => 'Events found by location',
                'data' => [],
            ]);
    }

    public function testSearchByCityAndDate()
    {
        $city = 'Bouaké';
        $date = '2023-06-30';
        $eventSearchUseCase = Mockery::mock(EventSearchUseCase::class);
        $eventSearchUseCase->shouldReceive('searchByCityAndDate')->once()->with($city, $date)->andReturn([]);

        $controller = new EventController($eventSearchUseCase);
        $response = $controller->searchByCityAndDate($this->createRequestWithInputs(['city' => $city, 'date' => $date]));

        $testResponse = TestResponse::fromBaseResponse($response);
        $testResponse->assertStatus(200)
            ->assertJson([
                'message' => 'Events found by city and date',
                'data' => [],
            ]);
    }

    private function createRequestWithInput($key, $value)
    {
        return \Illuminate\Http\Request::create('/', 'GET', [$key => $value]);
    }

    private function createRequestWithInputs($inputs)
    {
        return \Illuminate\Http\Request::create('/', 'GET', $inputs);
    }
}
