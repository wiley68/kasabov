<?php

namespace App\Http\Controllers;

use App\Holiday;
use App\LandingPage;

class HomeController extends Controller
{
    public function index()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();

        // Add property
        $property = LandingPage::first();

        return view('home')->with([
            'holidays'=>$holidays,
            'property'=>$property
        ]);
    }

    public function settings()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();

        // Add property
        $property = LandingPage::first();

        return view('home')->with([
            'holidays'=>$holidays,
            'property'=>$property
        ]);
    }

    public function adds()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();

        // Add property
        $property = LandingPage::first();

        return view('home')->with([
            'holidays'=>$holidays,
            'property'=>$property
        ]);
    }

    public function index_firm()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();

        // Add property
        $property = LandingPage::first();

        return view('home_firm')->with([
            'holidays'=>$holidays,
            'property'=>$property
        ]);
    }
}
