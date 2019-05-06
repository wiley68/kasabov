<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use App\LandingPage;
use App\User;
use Auth;
use App\City;
use Illuminate\Support\Facades\Session;
use File;

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
                Session::put('frontUserLogin', $request->input('register_email'));
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
                Session::put('frontFirmLogin', $request->input('register_email'));
                return redirect('/home-firm');
            }
        }
    }

    public function loginUser(Request $request){
        // Add user
        if($request->isMethod('post')){
            // Login new user
            if(Auth::attempt(['email' => $request->input('login_email'), 'password' => $request->input('login_password'), 'admin' => 0])){
                Session::put('frontUserLogin', $request->input('login_email'));
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
                Session::put('frontFirmLogin', $request->input('login_email'));
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

    public function logoutUser(){
        Auth::logout();
        Session::forget('frontUserLogin');
        return redirect('/');
    }

    public function logoutFirm(){
        Auth::logout();
        Session::forget('frontFirmLogin');
        return redirect('/');
    }

    public function viewFirms(){
        $firms = User::where(['admin'=>2])->get();
        return view('admin.firms.view_firms')->with(['firms'=>$firms]);
    }

    public function editFirm(Request $request, $id=null){
        $firm = User::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            $firm->name = $request->input('firm_name');
            $firm->email = $request->input('firm_email');
            $firm->phone = $request->input('firm_phone');
            $firm->save();
            return redirect('/admin/edit-firm/'.$id)->with('flash_message_success', 'Успешно редактирахте фирмата!');
        }
        $cities = City::all();
        return view('admin.firms.edit_firm')->with([
            'firm'=>$firm,
            'cities'=>$cities
            ]);
    }

    public function deleteFirmImage(Request $request, $id=null){
        if (!empty($id)){
            $firm_image = User::where(['id'=>$id])->first()->image;
            if (File::exists('images/backend_images/users/'.$firm_image)){
                File::delete('images/backend_images/users/'.$firm_image);
            }
            User::where(['id'=>$id])->update(['image'=>'']);
            return redirect('/admin/edit-firm/'.$id)->with('flash_message_success', 'Успешно изтрихте снимката на продукта!');
        }
    }

}
