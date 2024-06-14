<?php

namespace App\Services;

use App\Models\Screen;

class DetermineSeatsService
{
    /**
     * @param Screen|null $screen
     * @param int $screenCapacity
     * @param bool $randomTakenSeats
     * @param int|null $percentageTaken
     * @return array
     */
    public function createAvailableSeatsArray (?Screen $screen, int $screenCapacity, bool $randomTakenSeats, ?int $percentageTaken): array
    {
        $capacityArray = [];
        $takenSeatsArray = [];

        // Create array for all seat numbers in the cinema
        for ($i = 0; $i < $screenCapacity; $i++) {
            $capacityArray[] = $i + 1;
        }

        // If a screen is chosen get all taken seats from db and create an takenSeatsArray
        $takenSeats = $screen?->seats()->get();
        if (!empty($takenSeats)) {
            foreach ($takenSeats as $takenSeat) {
                $takenSeatsArray[] = $takenSeat->seat_number;
            }
        }

        // If a random method is chosen this creates an array with random taken seats based on a chosen screencapacity
        // and a chosen percentage.
        if ($randomTakenSeats) {
            $takenSeatsCount = ceil(($screenCapacity / 100) * $percentageTaken);
            $allSeatsArray = range(1, $screenCapacity);
            shuffle($allSeatsArray);
            $takenSeatsArray = array_slice($allSeatsArray, 0, $takenSeatsCount);
        }

        // Because the array is filled randomly a sort is necessary
        sort($takenSeatsArray);

        // Check which seats are available by comparing the array for all seat numbers with the takenSeatsArray
        $availableSeats = array_diff($capacityArray, $takenSeatsArray);

        return $availableSeats;
    }

    /**
     * @param array $availableSeats
     * @param int $ticketAmount
     * @return array
     */
    public function determineSeatNumbers(array $availableSeats, int $ticketAmount): array
    {
        $result = [];
        $enoughSeats = $this->checkIfEnoughSeatsAreAvailable($availableSeats, $ticketAmount);

        if (!$enoughSeats) {
            return $result;
        }

        // The keys in the array are not necessary so only the values (seatNumbers) will be used
        $seatNumbers = array_values($availableSeats);
        // Create an array that clusters consecutive seats
        $consecutiveSeatsArray = $this->findConsecutiveSeats($seatNumbers);
        // Loop through the consecutive seats and determine if the persons can sit next to each other
        foreach ($consecutiveSeatsArray as $sitNextToEachOther) {
            $count = $sitNextToEachOther["count"];
            if ($count == $ticketAmount) {
                $result = $sitNextToEachOther["seatNumbers"];
                break;
            }
        }

        // If it is not able for everyone to sit next to each other try splitting up the group
        if (empty($result)) {
            $result = $this->seatNumbersWhenSplittingGroup($consecutiveSeatsArray, $ticketAmount);
        }

        return $result;
    }

    /**
     * @param array $consecutiveSeatsArray
     * @param int $ticketAmount
     * @return array
     */
    public function seatNumbersWhenSplittingGroup (array $consecutiveSeatsArray, int $ticketAmount): array
    {
        $result = [];
        $originalWantedSeats = $ticketAmount;

        // Loop through consecutive seats to be able to determine where the group should sit
        foreach ($consecutiveSeatsArray as $sitNextToEachOther) {

            // Stop the loop when all tickets have seat numbers
            if ($ticketAmount <= 0) {
                break;
            }

            // Every time seats are found substract the amount of seats found from the amount of tickets that are left
            $ticketAmount = $ticketAmount - $sitNextToEachOther["count"];
            // Loop through seat numbers and give a ticket a seat number
            foreach ($sitNextToEachOther["seatNumbers"] as $seatNumber) {
                array_push($result, $seatNumber);
                // When enough tickets are given seat numbers stop the loop
                if ($originalWantedSeats == count($result)) {
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * @param array $availableSeats
     * @param int $ticketAmount
     * @return bool
     */
    public function checkIfEnoughSeatsAreAvailable(array $availableSeats, int $ticketAmount): bool
    {
        // Very simple check if there are enough seats available for the amount of tickets that are wanted
        if (count($availableSeats) < $ticketAmount) {
            return false;
        }

        return true;
    }

    /**
     * @param $seatNumbers
     * @return array
     */
    public function findConsecutiveSeats($seatNumbers): array
    {
        $result = [];
        $currentSequence = [];
        $previousNumber = null;

        // Loop through all seat numbers and check if they are consecutive
        foreach ($seatNumbers as $seatNumber) {
            if ($previousNumber !== null && $seatNumber != $previousNumber + 1) {
                // Save the current sequence of consecutive seat numbers to the result and start a new sequence
                $result[] = ['count' => count($currentSequence), 'seatNumbers' => $currentSequence];
                $currentSequence = [];
            }
            // Add the current number to the current sequence
            $currentSequence[] = $seatNumber;
            $previousNumber = $seatNumber;
        }

        // Count and seat numbers of consecutive seat numbers and seat numbers in one array
        if (!empty($currentSequence)) {
            $result[] = ['count' => count($currentSequence), 'seatNumbers' => $currentSequence];
        }

        return $result;
    }

}
