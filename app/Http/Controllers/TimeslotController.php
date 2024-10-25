<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Timeslot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TimeslotController extends Controller
{

    public function index()
    {
        dd('here');
    }
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
}
