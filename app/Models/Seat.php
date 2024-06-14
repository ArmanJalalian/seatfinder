<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\JsonResponse;

class Seat extends Model
{
    use HasFactory;
    protected $fillable = [
        'screen_id',
        'seat_number'
    ];
    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class);
    }
}
