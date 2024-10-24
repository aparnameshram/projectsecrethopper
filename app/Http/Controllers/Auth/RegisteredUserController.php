<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use DateTimeZone;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {

        return Inertia::render('Auth/Register', ['selectOptions' => Config::get('app.selectOptions')]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required'],
            'address' => ['required', 'string', 'min:3'],
            'city' => ['required', 'string', 'min:2'],
            'state' => ['required', 'string', 'min:2'],
            'zip' => ['required', 'min:2'],
            'timezone' => ['required', 'timezone:all'],
            'drinker_type' => ['required', 'string', 'min:2'],
            'how_did_hear' => ['required', 'string', 'min:2'],
            'recent_experience' => ['required', 'string', 'min:5'],
            'qualification_for_hopper' => ['required', 'string', 'min:3'],
            'acknowledge_text' => ['required', 'string', 'min:5'],
            'acknowledge_name' => ['required', 'string', 'min:5'],
            'date_signed' => ['required', 'date'],
            //'practice_report ' => ['required']
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role_id' => USER::DEFAULT_ROLE_ID
        ]);

        //setting lat long manually for now, later we will get them by google api
        $defaultLatLong = [
            'latitude' => '19.614960',
            'longitude' => '74.618560'
        ];

        $userProfile = $request->collect()->except([
            'first_name',
            'last_name',
            'email',
            'password',
            'phone',
            '_token',
            'password_confirmation'
        ])->merge($defaultLatLong)->toArray();

        $user->userProfile()->create($userProfile);
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
