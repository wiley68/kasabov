<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use App\LandingPage;
use App\User;
use Auth;

class UsersController extends Controller
{
    public function loginRegisterUsers(){
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();

        // Add property
        $property = LandingPage::first();

        return view('users.login_register')->with([
            'holidays'=>$holidays,
            'property'=>$property
        ]);
    }

    public function loginRegisterFirms(){
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();

        // Add property
        $property = LandingPage::first();

        return view('firms.login_register')->with([
            'holidays'=>$holidays,
            'property'=>$property
        ]);
    }

    public function registerUser(Request $request){
        // Add user
        if($request->isMethod('post')){
            $user = new User;
            $user->name = $request->input('register_name');
            $user->email = $request->input('register_email');
            $user->admin = 0;
            $user->password = bcrypt($request->input('register_password'));
            $user->save();
            // Login new user
            if(Auth::attempt(['email' => $request->input('register_email'), 'password' => $request->input('register_password')])){
                return redirect('/home');
            }
        }
    }

    public function registerFirm(Request $request){
        // Add user
        if($request->isMethod('post')){
            $user = new User;
            $user->name = $request->input('register_name');
            $user->email = $request->input('register_email');
            $user->admin = 2;
            $user->password = bcrypt($request->input('register_password'));
            $user->save();
            // Login new user
            if(Auth::attempt(['email' => $request->input('register_email'), 'password' => $request->input('register_password')])){
                return redirect('/home-firm');
            }
        }
    }

    public function loginUser(Request $request){
        // Add user
        if($request->isMethod('post')){
            // Login new user
            if(Auth::attempt(['email' => $request->input('login_email'), 'password' => $request->input('login_password'), 'admin' => 0])){
                return redirect('/home');
            }else{
                return redirect()->back()->with('flash_message_error', 'Грешни email или парола!');
            }
        }
    }

    public function loginFirm(Request $request){
        // Add user
        if($request->isMethod('post')){
            // Login new user
            if(Auth::attempt(['email' => $request->input('login_email'), 'password' => $request->input('login_password'), 'admin' => 2])){
                return redirect('/home-firm');
            }else{
                return redirect()->back()->with('flash_message_error', 'Грешни email или парола!');
            }
        }
    }

    public function checkEmail(Request $request){
        // Check if user e-mail exist
        $usersCount = User::where(['email'=>$request->input('register_email')])->count();
        if ($usersCount > 0){
            return "false";
        }else{
            return "true"; die;
        }
    }
}
