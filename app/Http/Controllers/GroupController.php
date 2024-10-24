<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Models\venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class GroupController extends Controller
{
    public function index(venue $venue)
    {

        Gate::authorize('view', $venue);

        //get all  groups

        $groups = Group::withCount('users')->where('venue_id', '=', $venue->id)->get();

        return Inertia::render('Group/Index', [
            'groups' => $groups,
            'venue'  => $venue
        ]);
    }

    public function create(Request $request, venue $venue)
    {

        Gate::authorize('view', $venue);
        $limit = $request->query('limit') ? $request->query('limit') : Config::get('app.pagination.limit');

        if ($request->query('name') != null) {
            $users = User::with('userProfile')->whereAny(
                ['first_name', 'last_name'],
                'like',
                '%' . $request->query('name') . '%'
            )->paginate($limit);
        } else {
            $users = User::with('userProfile')->paginate($limit);
        }

        return Inertia::render('Group/Create', [
            'venue'  => $venue,
            'questionnaire' => Config::get('app.questionnaire'),
            'users' => $users,
            'selectOptions' => Config::get('app.selectOptions'),
        ]);
    }

    public function store(Request $request, venue $venue)
    {
        //dd($request);
        Gate::authorize('view', $venue);
        $validated = $request->validate([
            'name' => ['required'],
            'claim_limit' => ['required', 'numeric'],
            'radius' => ['required', 'numeric'],
            'unique_instructions' => ['required'],
        ]);

        $validated['show_in_search'] = $request->input('show_in_search', false);

        //create group
        $group = $venue->groups()->create($validated);

        //create timeslots
        $request->collect('timeslots')->each(function (array $timeslot) use ($group) {
            $group->timeslots()->create($timeslot);
        });

        //attach users to group
        $group->users()->attach($request->collect('users'));

        return redirect(route('venue.groups', $venue->id, absolute: false));
    }

    public function edit(Group $group, Request $request)
    {
        //authorize
        Gate::authorize('update', $group);

        //get required data
        $limit = $request->query('limit') ? $request->query('limit') : Config::get('app.pagination.limit');

        if ($request->query('name') != null) {
            $users = User::with('userProfile')->whereAny(
                ['first_name', 'last_name'],
                'like',
                '%' . $request->query('name') . '%'
            )->paginate($limit);
        } else {
            $users = User::with('userProfile')->paginate($limit);
        }

        $groupData =  Group::with(['timeslots', 'users.userProfile'])->find($group->id);
        dd($groupData);
        //render
        return Inertia::render('Group/edit', [
            'group'  => $groupData,
            'questionnaire' => Config::get('app.questionnaire'),
            'users' => $users,
            'selectOptions' => Config::get('app.selectOptions'),
        ]);
    }

    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'claim_limit' => ['required', 'numeric'],
            'radius' => ['required', 'numeric'],
            'unique_instructions' => ['required'],
        ]);

        $validated['show_in_search'] = $request->input('show_in_search', false);
        //dd($request);
        $group->update($validated);
        //dd($request);

        //create timeslots
        $request->collect('timeslots')->each(function (array $timeslot) use ($group) {
            $group->timeslots()->create($timeslot);
        });

        //attach users to group
        $group->users()->attach($request->collect('users'));

        return redirect(route('venue.groups', $group->venue_id, absolute: false));
    }
}
