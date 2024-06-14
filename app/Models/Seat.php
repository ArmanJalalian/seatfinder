<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\JsonResponse;

class Seat extends Model
{
    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class);
    }
}
