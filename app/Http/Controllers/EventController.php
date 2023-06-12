<?php

namespace App\Http\Controllers;

use App\Core\UseCases\EventSearch\EventSearchUseCase;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private EventSearchUseCase $eventSearchUseCase;

    public function __construct(EventSearchUseCase $eventSearchUseCase)
    {
        $this->eventSearchUseCase = $eventSearchUseCase;
    }
    /**
     * @OA\Get(
     *     path="/api/events",
     *     summary="Get all events",
     *     @OA\Response(response="200", description="Successful operation"),
     *     @OA\Response(response="500", description="An error occurred")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $events = $this->eventSearchUseCase->findAll();

            return response()->json([
                'message' => 'All events',
                'data' => $events,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/events/{id}",
     *     summary="Get an event by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Event ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Event found"),
     *     @OA\Response(response="404", description="Event not found"),
     *     @OA\Response(response="500", description="An error occurred")
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $event = $this->eventSearchUseCase->findById($id);

            if (!$event) {
                return response()->json([
                    'message' => 'Event not found',
                ], 404);
            }

            return response()->json([
                'message' => 'Event found',
                'data' => $event,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/events/search/city",
     *     summary="Search events by city",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="city", type="string")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Events found by city"),
     *     @OA\Response(response="500", description="An error occurred")
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByCity(Request $request)
    {
        $city = $request->input('city');

        try {
            $events = $this->eventSearchUseCase->searchByCity($city);

            return response()->json([
                'message' => 'Events found by city',
                'data' => $events,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
/**
* @OA\Post(
*     path="/api/events/search/location",
*     summary="Search events by location",
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             @OA\Property(property="location", type="string")
*         )
*     ),
*     @OA\Response(response="200", description="Events found by location"),
*     @OA\Response(response="500", description="An error occurred")
* )
*
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\JsonResponse
*/
    public function searchByLocation(Request $request)
    {
        $location = $request->input('location');

        try {
            $events = $this->eventSearchUseCase->searchByLocation($location);

            return response()->json([
                'message' => 'Events found by location',
                'data' => $events,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/events/search/city-and-date",
     *     summary="Search events by city and date",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="date", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Events found by city and date"),
     *     @OA\Response(response="500", description="An error occurred")
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByCityAndDate(Request $request)
    {
        $city = $request->input('city');
        $date = $request->input('date');

        try {
            $events = $this->eventSearchUseCase->searchByCityAndDate($city, $date);

            return response()->json([
                'message' => 'Events found by city and date',
                'data' => $events,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
