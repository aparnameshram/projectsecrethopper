<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timeslot extends Model
{
    /** @use HasFactory<\Database\Factories\TimeslotFactory> */
    use HasFactory;

    public $fillable = [
        'date',
        'start_time',
        'end_time'
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
