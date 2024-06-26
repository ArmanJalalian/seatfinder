<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Screen extends Model
{
    use HasFactory;
    protected $fillable = [
        'seating_capacity'
    ];
    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

}
