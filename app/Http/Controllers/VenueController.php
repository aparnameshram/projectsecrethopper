<?php

namespace App\Http\Controllers;

use App\Models\venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Inertia\Inertia;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::id();

        $limit = $request->query('limit') ? $request->query('limit') : Config::get('app.pagination.limit');
        if ($request->query('search') != null) {
            $venues = venue::where([
                'user_id' => $user,
            ])->whereAny(
                [
                    'name',
                    'address'
                ],
                'like',
                '%' . $request->query('search') . '%'
            )->paginate($limit);
        } else {
            $venues = venue::where('user_id', $user)->paginate($limit);
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

    public function show(Venue $venue)
    {
        dd('show' . $venue);
        dd('in show');
    }

    public function destroy(Venue $venue)
    {
        dd('destroy ' . $venue);
        dd('in destroy');
    }

    public function get_venues()
    {
        $user = Auth::id();
        $venues = venue::where('user_id', $user)->paginate(1);
        return $venues;
    }

    public function store(Request $request)
    {
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
}
