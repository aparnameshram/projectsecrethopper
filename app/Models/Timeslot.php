<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Timeslot extends Model
{
    /** @use HasFactory<\Database\Factories\TimeslotFactory> */
    use HasFactory;

    public $fillable = [
        'date',
        'start_time',
        'end_time',
        'group_id'
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function attachecdUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_user', 'claimed_timeslot_id', 'user_id');
    }
}
