<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\Timeslot;
use App\Models\User;
use App\Models\venue;
use Illuminate\Auth\Access\Response;

class TimeslotPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Timeslot $timeslot): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Timeslot $timeslot): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Timeslot $timeslot): bool
    {
        $group = Group::find($timeslot->group_id);
        //dd($venue);
        $venue = venue::find($group->venue_id);
        return $venue->user()->is($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Timeslot $timeslot): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Timeslot $timeslot): bool
    {
        return true;
    }
}
