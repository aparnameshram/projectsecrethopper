<?php

namespace App\Listeners;

use App\Events\GroupProcessed;
use App\Models\Group;
use App\Models\User;
use App\Notifications\NewGroup;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class SendGroupNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(GroupProcessed $event): void
    {

        $group = Group::find($event->group->id);

        //get timeslots addded to group
        $timeslots = $group->timeslots()->get();
        foreach (User::whereIn('id', $group->users()->get()->pluck('id'))->cursor() as $user) {
            $user->notify(new NewGroup($event->group, $timeslots));
        }
    }
}
