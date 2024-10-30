<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Timeslot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

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

        return redirect()->back()->with([
            'timeslot' =>  $timeslot,
        ]);
    }

    public function index(Group $group)
    {
        //get all timeslots connected to group
        //$timeslots = $group->timeslots()->get();
        //get claim limit of group
        //dd($group->timeslots()->get());
        return Inertia::render('Timeslot/Index', [
            'group'  => $group,
            'timeslots' =>  $group->timeslots()->get(),
        ]);
    }
}
