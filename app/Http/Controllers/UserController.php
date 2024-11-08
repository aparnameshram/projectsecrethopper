<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
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
}
