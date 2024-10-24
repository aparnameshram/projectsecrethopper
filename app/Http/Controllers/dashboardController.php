<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {

        $widgetData = collect([
            ['title' => 'Total Locations', 'total' => 12],
            ['title' => 'Total Shoppers', 'total' => 121],
            ['title' => 'Total Managers', 'total' => 32],
            ['title' => 'Total Slots', 'total' => 82],
            ['title' => 'Total Calimed Visits', 'total' => 92]
        ]);
        /*$data = [
            'locations' => 10,
            'shoppers' => 20,
            'managers' => 30,
            'slots' => 23,
            'claimed_visits' => 50
        ];*/

        return view('dashboard/index', ['widgetData' => $widgetData]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'gender' => 'required',
        ]);
        dd($request);
        return redirect(route('dashboard', absolute: false));
    }
}
