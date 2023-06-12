<?php

namespace Tests\Feature;

use App\Models\Reservation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;


class ReservationControllerTest extends TestCase
{
    use DatabaseTransactions;
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\App\Http\Middleware\Authenticate::class);
    }

    public function testBookReservation()
    {

        $reservationData = [
            'event_id' => 1,
            'user_id' => 1,
            'ticket_count' => 2,
            'card_holder_info' => 'Findel Fofana',
        ];

        $response = $this->postJson('/reservations', $reservationData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Reservation created successfully',
            ])
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'event_id',
                    'user_id',
                    'ticket_count',
                    'card_holder_info',
                ],
            ]);

        $this->assertDatabaseHas('reservations', $reservationData);
    }




}

