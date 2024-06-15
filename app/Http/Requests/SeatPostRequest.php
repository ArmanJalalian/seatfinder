<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeatPostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'screen_id' => ['nullable', 'exists:screens'],
            'amountOfSeats' => ['nullable', 'integer', 'min:1'],
            'percentageTaken' => ['nullable', 'integer', 'min:0'],
            'ticketAmount' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
