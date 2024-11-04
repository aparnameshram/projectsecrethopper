<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    /** @use HasFactory<\Database\Factories\GroupFactory> */
    use HasFactory;

    public $guarded = [];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(venue::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('claimed_timeslot_id');
    }

    public function timeslots(): HasMany
    {
        return $this->hasMany(Timeslot::class);
    }

    /**
     * Function to return users who claimed timeslots
     */
    public function claimedTimeslotUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->wherePivotNotNull('claimed_timeslot_id');
    }
}
