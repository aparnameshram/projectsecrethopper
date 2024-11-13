<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Timeslot;
use App\Models\User;
use App\Models\venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Illuminate\Database\Query\JoinClause;

class TimeslotController extends Controller
{

    public function validate(Request $request)
    {

        $validated = $request->validate([
            'date' => ['required'],
            'start_time' => ['required'],
            'end_time' => ['required', 'after:start_time']
        ]);


        return redirect()->back()->with([
            'data' => 'Something you want to pass to front-end',
        ]);
    }

    public function store(request $request, Group $group) {}

    public function destroy(Timeslot $timeslot, Request $request)
    {
        //authorize
        Gate::authorize('delete', $timeslot);

        Timeslot::destroy($timeslot->id);
        //delete
        return redirect()->back()->with([
            'data' => 'Something you want to pass to front-end',
        ]);
    }

    public function update(Timeslot $timeslot, Request $request)
    {
        //authorize
        Gate::authorize('delete', $timeslot);

        $validated = $request->validate([
            'date' => ['required'],
            'start_time' => ['required'],
            'end_time' => ['required', 'after:start_time']
        ]);


        $timeslot->date = $validated['date'];
        $timeslot->start_time = $validated['start_time'];
        $timeslot->end_time = $validated['end_time'];
        $timeslot->save();

        return redirect()->back();
    }

    /**
     * Function to list timeslots of group
     */
    public function show(Group $group)
    {
        return Inertia::render('Timeslot/Index', [
            'group'  => $group,
            'timeslots' =>  $group->timeslots()->get(),
            'totalClaimes' => $group->claimedTimeslotUsers()->get()->count(),
            'canClaim' => $this->canClaim($group)
        ]);
    }

    /**
     * Function to attched logged in user to claimed timeslot
     */
    public function attachUser(Timeslot $timeslot, Request $request)
    {

        $group = Group::find($timeslot->group_id);
        $group->users()->detach($request->user());
        $group->users()->attach($request->user(), ['claimed_timeslot_id' => $timeslot->id]);

        return redirect()->back();
    }

    /**
     * Determine wheher user can claim timeslot depending on claim limit set on the group table and
     * whether user has already claimed any of timeslot
     * User can claim only one timeslot of group
     */
    protected function canClaim(Group $group)
    {

        $user = Request()->user();
        //get defined claims
        $totalClaimes = $group->claimedTimeslotUsers()->get()->count();

        //check if user already claimed any of timeslot
        $alreadyClaimed = $group->users()
            ->wherePivot('user_id', '=', $user->id)
            ->wherePivotNull('claimed_timeslot_id')
            ->get()->count();

        return (($totalClaimes <= $group->claim_limit) && $alreadyClaimed);
    }

    /**
     * Function to list timeslots of user
     */
    public function index(User $user)
    {
        $user = User::find(Request()->user()->id);
        $groups = $user->groups()
            ->with('timeslots')
            ->get();

        $groups = $groups->append(['canClaimTimeslot'])->groupBy('venue_id')->toArray();
        $venueIds = array_keys($groups);

        $venues = venue::whereIn('id', $venueIds)->select('id', 'address', 'name')->get();
        $data = [];
        foreach ($venues as $venue) {
            $data[] = [
                'venue_id' => $venue->id,
                'address' => $venue->address,
                'name'  => $venue->name,
                'groups' => (isset($groups[$venue->id]) ? $groups[$venue->id] : [])
            ];
        }

        return Inertia::render('Timeslot/Index', [
            'data'  => $data,
        ]);
    }
}
