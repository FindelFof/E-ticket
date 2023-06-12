<?php

namespace App\Http\Controllers;
use App\Core\Entities\Reservation;
use App\Core\Repositories\EmailSenderInterface;
use App\Core\UseCases\ReservationBooking\ReservationBookingUseCase;
use Illuminate\Http\Request;


/**
 * @OA\Schema(
 *     schema="Reservation",
 *     required={"id", "event_id", "user_id", "ticket_count", "card_holder_info"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="event_id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="ticket_count", type="integer", example=2),
 *     @OA\Property(property="card_holder_info", type="string", example="Findel Fofana"),
 * )
 */
class ReservationController extends Controller
{
    private $reservationBookingUseCase;
    private $emailSender;

    /**
     * ReservationController constructor.
     *
     * @param ReservationBookingUseCase $reservationBookingUseCase
     * @param EmailSenderInterface $emailSender
     */
    public function __construct(
        ReservationBookingUseCase $reservationBookingUseCase,
        EmailSenderInterface $emailSender
    ) {
        $this->reservationBookingUseCase = $reservationBookingUseCase;
        $this->emailSender = $emailSender;
    }

    /**
     * Book a reservation.
     *
     * @OA\Post(
     *     path="/reservations",
     *     summary="Book a reservation",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="event_id",
     *                     type="integer",
     *                     description="The ID of the event",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     description="The ID of the user",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="ticket_count",
     *                     type="integer",
     *                     description="The number of tickets",
     *                     example=2
     *                 ),
     *                 @OA\Property(
     *                     property="card_holder_info",
     *                     type="string",
     *                     description="The card holder information",
     *                     example="Findel Fofana"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reservation created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Reservation created successfully"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Reservation"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="An error occurred"
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string"
     *             )
     *         )
     *     )
     * )
     */
    public function bookReservation(Request $request)
    {
        $validatedData = $request->validate([
            'event_id' => 'required|integer',
            'user_id' => 'required|integer',
            'ticket_count' => 'required|integer',
            'card_holder_info' => 'required|string',
        ]);

        $createdReservation =  $this->reservationBookingUseCase->bookReservation(
            null,
            $validatedData['event_id'],
            $validatedData['user_id'],
            $validatedData['ticket_count'],
            $validatedData['card_holder_info']
        );

        return response()->json([
            'message' => 'Reservation created successfully',
            'data' => $createdReservation,
        ], 201);
    }

    /**
     * Cancel a reservation.
     *
     * @OA\Post(
     *     path="/reservations/{id}",
     *     summary="Cancel a reservation",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the reservation",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation cancelled successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Reservation cancelled successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reservation not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Reservation not found"
     *             )
     *         )
     *     )
     * )
     */
    public function cancelReservation(int $reservationId)
    {
        $reservation = $this->reservationBookingUseCase->cancelReservation($reservationId);

        if (!$reservation) {
            return response()->json([
                'message' => 'Reservation not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Reservation cancelled successfully',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
