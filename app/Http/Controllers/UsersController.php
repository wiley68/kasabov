<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use App\LandingPage;

class UsersController extends Controller
{
    public function registerUsers(Request $request){
        // Register new User


        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();

        // Add property
        $property = LandingPage::first();

        return view('users.login_register')->with([
            'holidays'=>$holidays,
            'property'=>$property
        ]);
    }
}
