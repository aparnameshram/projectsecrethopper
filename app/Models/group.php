<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function getCanClaimTimeslotAttribute()
    {
        $totalClaimes = $this->claimedTimeslotUsers()->get()->count();

        //check if user already claimed any of timeslot
        $alreadyClaimed = $this->users()
            ->wherePivot('user_id', '=', Request()->user()->id)
            ->wherePivotNull('claimed_timeslot_id')
            ->get()->count();

        return (($totalClaimes <= $this->claim_limit) && $alreadyClaimed);
    }

    protected function getVenueNameAttribute()
    {
        return $this->venue()->first()->name;
    }

    protected function getVenueAddressAttribute()
    {
        return $this->venue()->first()->address;
    }
}
