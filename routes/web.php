<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimeslotController;
use App\Http\Controllers\userController;
use App\Http\Controllers\VenueController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/venues', [VenueController::class, 'index'])->name('venues');
    Route::get('/venue/{venue}', [VenueController::class, 'show'])->name('venue.show');
    Route::get('/venue/create', [VenueController::class, 'create'])->name('venue.create');
    Route::post('/venue/create', [VenueController::class, 'store'])->name('venue.save');
    Route::get('/venue/{venue}/edit', [VenueController::class, 'edit'])->name('venue.edit');
    Route::patch('/venue', [VenueController::class, 'update'])->name('venue.update');
    Route::delete('/venue', [VenueController::class, 'destroy'])->name('venue.delete');
    Route::get('/get_venues', [VenueController::class, 'index'])->name('get_venues');
    Route::get('/groups/{venue}', [GroupController::class, 'index'])->name('venue.groups');
    Route::get('/group/{venue}/create', [GroupController::class, 'create'])->name('group.create');
    Route::post('/group/{venue}', [GroupController::class, 'store'])->name('group.store');
    Route::get('/group/{group}/edit', [GroupController::class, 'edit'])->name('group.edit');
    Route::patch('/group/{group}', [GroupController::class, 'update'])->name('group.update');
    Route::post('/timeslot/validate', [TimeslotController::class, 'validate'])->name('timeslot.validate');
    Route::post('/timeslot/{group}/store', [TimeslotController::class, 'store'])->name('timeslot.store');
    Route::get('/user/getUsers', [userController::class, 'getUsers'])->name('user.getUsers');
});

Route::get('/examples', function () {
    $listitems = [
        ['value' => 'male', 'label' => 'Male'],
        ['value' => 'female', 'label' => 'Female'],
        ['value' => 'not_binary', 'label' => 'Non binary'],
        ['value' => 'prefer_no_say', 'label' => 'Prefer not to say']
    ];
    //$listitems = (object) ['name' => 'test'];
    //dd($listitems->name);
    return Inertia::render('examples', ['listitems' => (object)$listitems]);
});
Route::post('process', [dashboardController::class, 'store'])->name('process');


require __DIR__ . '/auth.php';
