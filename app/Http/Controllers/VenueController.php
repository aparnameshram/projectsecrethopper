<?php

namespace App\Http\Controllers;

use App\Models\venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit') ? $request->query('limit') : Config::get('app.pagination.limit');
        if ($request->query('search') != null) {
            $venues = venue::whereAny(
                [
                    'name',
                    'address'
                ],
                'like',
                '%' . $request->query('search') . '%'
            )->paginate($limit);
        } else {
            $venues = venue::paginate($limit);
        }

        return Inertia::render(
            'Venue/Index',
            [
                'venues' => $venues,
                'limit' => $limit,
                'selectOptions' => Config::get('app.selectOptions'),
                'questionnaire' => Config::get('app.questionnaire')
            ]
        );
    }

    public function edit(Venue $venue)
    {
        return Inertia::render(
            'Venue/Edit',
            [
                'venue' => $venue,
                'selectOptions' => Config::get('app.selectOptions'),
                'questionnaire' => Config::get('app.questionnaire')
            ]
        );
    }


    public function destroy(Venue $venue)
    {
        //authorize
        Gate::authorize('delete', $venue);

        venue::destroy($venue->id);
        //delete
        return redirect()->back()->with([
            'data' => 'Something you want to pass to front-end',
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', venue::class);
        $validated = $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'city' => ['required', 'string', 'min:2'],
            'state' => ['required', 'string', 'min:2'],
            'zip' => ['required', 'min:2'],
            'timezone' => ['required', 'timezone:all'],
            'radius' => ['required', 'numeric'],
            'questionnaire_link' => ['required'],
            'unique_instructions' => ['required'],
            'country' => ['required']
        ]);

        $validated['latitude'] = '67.89';
        $validated['longitude'] = '67.89';

        $request->User()->Venues()->create($validated);
        return redirect(route('venues', absolute: false));
    }

    public function update(venue $venue, Request $request)
    {
        Gate::authorize('update', $venue);
        $validated = $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'city' => ['required', 'string', 'min:2'],
            'state' => ['required', 'string', 'min:2'],
            'zip' => ['required', 'min:2'],
            'timezone' => ['required', 'timezone:all'],
            'radius' => ['required', 'numeric'],
            'questionnaire_link' => ['required'],
            'unique_instructions' => ['required'],
            'country' => ['required']
        ]);

        $validated['latitude'] = '67.89';
        $validated['longitude'] = '67.89';

        $venue->update($validated);
        return redirect(route('venues', absolute: false));
    }
}
