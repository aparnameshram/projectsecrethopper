<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class userController extends Controller
{

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Auth::user());
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

        return Inertia::render(
            'User/Index',
            [
                'users' => $users,
                'limit' => $limit,
                'selectOptions' => Config::get('app.selectOptions')
            ]
        );
    }

    public function getUsers(Request $request)
    {
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
        //dd($users);
        return redirect()->back()->with([
            'users' => $users
        ]);
    }

    public function edit(User $user, Request $request)
    {
        Gate::authorize('update', $user);
        return Inertia::render(
            'User/Index',
            [
                'user' => $user,
                'selectOptions' => Config::get('app.selectOptions')
            ]
        );
    }

    public function update(User $user, Request $request)
    {
        Gate::authorize('update', $user);
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',' . $user->id],
            'phone' => ['required'],
            'user_profile.gender' => ['required'],
            'user_profile.address' => ['required', 'string', 'min:3'],
            'user_profile.timezone' => ['required', 'timezone:all'],
            'user_profile.date_signed' => ['required', 'date'],
        ]);

        $user->update($validated);

        $user->userProfile()->update([
            'gender' => $validated['user_profile']['gender'],
            'address' => $validated['user_profile']['address'],
            'timezone' => $validated['user_profile']['timezone'],
            'date_signed' => $validated['user_profile']['date_signed'],
        ]);

        return redirect()->back()->with([
            'users' => $user
        ]);
    }

    public function show(User $user, Request $request)
    {
        Gate::authorize('view', $user);
        $user = User::with('userProfile')->find($user->id);
        $claimedTimeslots = $user->attachedTimeslots()
            ->with('group.venue')
            ->get();

        return Inertia::render(
            'User/Show',
            [
                'user' => $user,
                'claimedTimeslots' => $claimedTimeslots
            ]
        );
    }

    public function destroy(User $user, Request $request)
    {
        Gate::authorize('delete', $user);
        User::destroy($user->id);

        if (isset($request->redirect)) {
            return redirect(route('users'));
        }
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required'],
            'user_profile.gender' => ['required'],
            'user_profile.address' => ['required', 'string', 'min:3'],
            'user_profile.timezone' => ['required', 'timezone:all'],
            'user_profile.date_signed' => ['required', 'date'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' =>  Hash::make(Config::get('newUserPassword')),
            'phone' => $request->phone,
            'role_id' => USER::DEFAULT_ROLE_ID
        ]);

        //setting lat long manually for now, later we will get them by google api
        $defaults = [
            'latitude' => '19.614960',
            'longitude' => '74.618560',
            'city' => '',
            'state' => '',
            'zip' => '',
            'country' => '',
            'drinker_type' => 'new',
            'how_did_hear' => '',
            'recent_experience' => '',
            'qualification_for_hopper' => '',
            'acknowledge_text' => '',
            'acknowledge_name' => '',
            'practice_report' => 0,
            'date_of_birth' => ''
        ];

        $userProfile = array_merge($request->collect()->get('user_profile'), $defaults);
        $user->userProfile()->create($userProfile);

        return redirect()->back()->with([
            'user' => $user
        ]);
    }
}
