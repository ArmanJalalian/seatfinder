<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeatPostRequest;
use App\Models\Screen;
use App\Services\DetermineSeatsService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ScreenController extends Controller
{

    public function __construct(private readonly DetermineSeatsService $determineSeatsService)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Screens/Index', [
            'screens' => Screen::all()
        ]);
    }

    public function show(SeatPostRequest $request): Response
    {
        $validated = $request->validated();

        $randomTakenSeats = true;
        $screenCapacity = $request->amountOfSeats;
        $percentageTaken = $request->percentageTaken;

        $screenId = null;
        $screen = null;

        if ($screenCapacity <= 0) {
            $screen = Screen::find($request->screen);
            $screenId = $screen->id;
            $screenCapacity = $screen->seating_capacity;
            $randomTakenSeats = false;
            $percentageTaken = null;
        }

        $ticketAmount = $request->input("ticketAmount");
        $availableSeatsMessage = true;

        $availableSeatsArray = $this->determineSeatsService->createAvailableSeatsArray($screen, $screenCapacity, $randomTakenSeats, $percentageTaken);
        $seatNumbersArray = $this->determineSeatsService->determineSeatNumbers($availableSeatsArray, $ticketAmount);

        if (empty($seatNumbersArray)) {
            $availableSeatsMessage = false;
        }

        return Inertia::render('Screens/Show', [
            'screenId' => $screenId,
            'screenCapacity' => $screenCapacity,
            'availableSeats' => $availableSeatsMessage,
            'availableSeatsArray' => array_values($availableSeatsArray),
            'seatNumbersArray' => $seatNumbersArray,
        ]);
    }
}
