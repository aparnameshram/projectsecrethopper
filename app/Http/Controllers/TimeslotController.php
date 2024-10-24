<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

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
}
