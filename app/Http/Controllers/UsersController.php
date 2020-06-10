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
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use App\Favorite;
use App\Order;
use App\ProductsCity;
use App\ProductsImage;
use App\ProductsTags;
use App\Product;

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
        $this->validate($request, [
            'register_name' => 'required',
            'register_email' => 'required',
            'register_password' => 'min:6|required_with:register_password_again|same:register_password_again',
            'register_password_again' => 'min:6',
            'checkedall' => 'required',
            'g-recaptcha-response' => 'required|recaptcha'
        ],
        [
            'register_name.required' => 'Задължително е въвеждането на Вашето име!',
            'register_email.required' => 'Задължително е въвеждането на вашия e-mail адрес!',
            'register_password.min' => 'Минималната дължина на паролата е 6 символа!',
            'register_password.required_with' => 'Трябва да въведете два пъти паролата!',
            'register_password.same' => 'Повторната парола трябва да съответства на въведената първа!',
            'register_password_again.min' => 'Минималната дължина на паролата е 6 символа!',
            'checkedall.required' => 'Задължително е да приемете Общите ни условия за да се регистрирате!',
            'g-recaptcha-response.required' => 'Задължително е да преминете проверката за бот!',
            'g-recaptcha-response.recaptcha' => 'Неуспешна проверка за бот!'
        ]);
        
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
            $firm->email = $request->input('register_email');
            $firm->phone = $request->input('firm_phone');
            $firm->city_id = $request->input('firm_city');
            $firm->address = $request->input('firm_address');
            $firm->info = $request->input('info');
            //upload image
            if ($request->hasFile('image')) {
                // Delete old image
                $firm_image = $firm->image;
                if (File::exists('images/backend_images/users/' . $firm_image)) {
                    File::delete('images/backend_images/users/' . $firm_image);
                }
                $image_temp = Input::file('image');
                if ($image_temp->isValid()) {
                    $extension = $image_temp->getClientOriginalExtension();
                    $filename = $firm->id . rand(111, 99999) . '.' . $extension;
                    $image_path = 'images/backend_images/users/' . $filename;
                    // Resize images
                    Image::make($image_temp)->resize(null, 75, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($image_path);
                }
            } else {
                $filename = $request->input('current_image');
                if (empty($request->input('current_image'))) {
                    $filename = '';
                }
            }
            $firm->image = $filename;
            $firm->monthizvestia = $request->input('monthizvestia');
            $firm->porackiizvestia = $request->input('porackiizvestia');
            $firm->newizvestia = $request->input('newizvestia');
            $firm->save();
            return redirect('/admin/edit-firm/'.$id)->with('flash_message_success', 'Успешно редактирахте фирмата!');
        }
        $cities = City::all();
        return view('admin.firms.edit_firm')->with([
            'firm'=>$firm,
            'cities'=>$cities
            ]);
    }

    public function addFirm(Request $request){
        $firm = new User();
        if ($request->isMethod('post')){
            $firm->name = $request->input('firm_name');
            $firm->email = $request->input('register_email');
            $firm->phone = $request->input('firm_phone');
            $firm->city_id = $request->input('firm_city');
            $firm->address = $request->input('firm_address');
            $firm->info = $request->input('info');
            $firm->image = '';
            $firm->monthizvestia = $request->input('monthizvestia');
            $firm->porackiizvestia = $request->input('porackiizvestia');
            $firm->newizvestia = $request->input('newizvestia');
            $firm->password = bcrypt($request->input('password'));
            $firm->admin = 2;
            $firm->save();
            return redirect('/admin/edit-firm/'.$firm->id)->with('flash_message_success', 'Успешно създадохте търговеца!');
        }
        $cities = City::all();
        return view('admin.firms.add_firm')->with([
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
            return redirect('/admin/edit-firm/'.$id)->with('flash_message_success', 'Успешно изтрихте снимката на търговеца!');
        }
    }

    public function deleteFirm(Request $request, $id=null){
        if (!empty($id)){
            // Delete favorites
            Favorite::where(['user_id'=>$id])->delete();
            $products = Product::where(['user_id'=>$id])->get();
            foreach ($products as $product) {
                // Delete products_images
                $product_image = Product::where(['id' => $id])->first()->image;
                if (File::exists('images/backend_images/products/small/' . $product_image)) {
                    File::delete('images/backend_images/products/small/' . $product_image);
                }
                if (File::exists('images/backend_images/products/medium/' . $product_image)) {
                    File::delete('images/backend_images/products/medium/' . $product_image);
                }
                if (File::exists('images/backend_images/products/large/' . $product_image)) {
                    File::delete('images/backend_images/products/large/' . $product_image);
                }
                $product_images = ProductsImage::where(['product_id'=>$id])->get();
                foreach ($product_images as $image) {
                    if (File::exists('images/backend_images/products/small/' . $image->image)) {
                        File::delete('images/backend_images/products/small/' . $image->image);
                    }
                    if (File::exists('images/backend_images/products/medium/' . $image->image)) {
                        File::delete('images/backend_images/products/medium/' . $image->image);
                    }
                    if (File::exists('images/backend_images/products/large/' . $image->image)) {
                        File::delete('images/backend_images/products/large/' . $image->image);
                    }
                }
                ProductsImage::where(['product_id'=>$product->id])->delete();
                // Delete products_cities
                ProductsCity::where(['product_id'=>$product->id])->delete();
                // Delete products_tags
                ProductsTags::where(['product_id'=>$product->id])->delete();
                // Delete products
                Product::where(['id'=>$product->id])->delete();
            }
            // Delete user image
            $user_image = User::where(['id' => $id])->first()->image;
            if (File::exists('images/backend_images/users/' . $user_image)) {
                File::delete('images/backend_images/users/' . $user_image);
            }

            User::where(['id'=>$id])->delete();

            return redirect('/admin/view-firms')->with('flash_message_success', 'Успешно изтрихте търговеца!');
        }
    }

    public function viewUsers(){
        $users = User::where(['admin'=>0])->get();
        return view('admin.users.view_users')->with(['users'=>$users]);
    }

    public function editUser(Request $request, $id=null){
        $user = User::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            $user->name = $request->input('user_name');
            $user->email = $request->input('register_email');
            $user->phone = $request->input('user_phone');
            $user->city_id = $request->input('user_city');
            $user->address = $request->input('user_address');
            $user->info = $request->input('info');
            //upload image
            if ($request->hasFile('image')) {
                // Delete old image
                $user_image = $user->image;
                if (File::exists('images/backend_images/users/' . $user_image)) {
                    File::delete('images/backend_images/users/' . $user_image);
                }
                $image_temp = Input::file('image');
                if ($image_temp->isValid()) {
                    $extension = $image_temp->getClientOriginalExtension();
                    $filename = $user->id . rand(111, 99999) . '.' . $extension;
                    $image_path = 'images/backend_images/users/' . $filename;
                    // Resize images
                    Image::make($image_temp)->resize(null, 75, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($image_path);
                }
            } else {
                $filename = $request->input('current_image');
                if (empty($request->input('current_image'))) {
                    $filename = '';
                }
            }
            $user->image = $filename;
            $user->monthizvestia = $request->input('monthizvestia');
            $user->porackiizvestia = $request->input('porackiizvestia');
            $user->newizvestia = $request->input('newizvestia');
            $user->save();
            return redirect('/admin/edit-user/'.$id)->with('flash_message_success', 'Успешно редактирахте клиента!');
        }
        $cities = City::all();
        return view('admin.users.edit_user')->with([
            'user'=>$user,
            'cities'=>$cities
            ]);
    }

    public function addUser(Request $request){
        $user = new User();
        if ($request->isMethod('post')){
            $user->name = $request->input('user_name');
            $user->email = $request->input('register_email');
            $user->phone = $request->input('user_phone');
            $user->city_id = $request->input('user_city');
            $user->address = $request->input('user_address');
            $user->info = $request->input('info');
            $user->image = '';
            $user->monthizvestia = $request->input('monthizvestia');
            $user->porackiizvestia = $request->input('porackiizvestia');
            $user->newizvestia = $request->input('newizvestia');
            $user->password = bcrypt($request->input('password'));
            $user->admin = 0;
            $user->save();
            return redirect('/admin/edit-user/'.$user->id)->with('flash_message_success', 'Успешно създадохте клиента!');
        }
        $cities = City::all();
        return view('admin.users.add_user')->with([
            'user'=>$user,
            'cities'=>$cities
            ]);
    }

    public function deleteUserImage(Request $request, $id=null){
        if (!empty($id)){
            $user_image = User::where(['id'=>$id])->first()->image;
            if (File::exists('images/backend_images/users/'.$user_image)){
                File::delete('images/backend_images/users/'.$user_image);
            }
            User::where(['id'=>$id])->update(['image'=>'']);
            return redirect('/admin/edit-user/'.$id)->with('flash_message_success', 'Успешно изтрихте снимката на клиента!');
        }
    }

    public function deleteUser(Request $request, $id=null){
        if (!empty($id)){
            // Delete favorites
            Favorite::where(['user_id'=>$id])->delete();
            // Delete orders
            Order::where(['user_id'=>$id])->delete();
            $products = Product::where(['user_id'=>$id])->get();
            foreach ($products as $product) {
                // Delete products_images
                $product_image = Product::where(['id' => $id])->first()->image;
                if (File::exists('images/backend_images/products/small/' . $product_image)) {
                    File::delete('images/backend_images/products/small/' . $product_image);
                }
                if (File::exists('images/backend_images/products/medium/' . $product_image)) {
                    File::delete('images/backend_images/products/medium/' . $product_image);
                }
                if (File::exists('images/backend_images/products/large/' . $product_image)) {
                    File::delete('images/backend_images/products/large/' . $product_image);
                }
                $product_images = ProductsImage::where(['product_id'=>$id])->get();
                foreach ($product_images as $image) {
                    if (File::exists('images/backend_images/products/small/' . $image->image)) {
                        File::delete('images/backend_images/products/small/' . $image->image);
                    }
                    if (File::exists('images/backend_images/products/medium/' . $image->image)) {
                        File::delete('images/backend_images/products/medium/' . $image->image);
                    }
                    if (File::exists('images/backend_images/products/large/' . $image->image)) {
                        File::delete('images/backend_images/products/large/' . $image->image);
                    }
                }
                ProductsImage::where(['product_id'=>$product->id])->delete();
                // Delete products_cities
                ProductsCity::where(['product_id'=>$product->id])->delete();
                // Delete products_tags
                ProductsTags::where(['product_id'=>$product->id])->delete();
                // Delete products
                Product::where(['id'=>$product->id])->delete();
            }
            // Delete user image
            $user_image = User::where(['id' => $id])->first()->image;
            if (File::exists('images/backend_images/users/' . $user_image)) {
                File::delete('images/backend_images/users/' . $user_image);
            }

            User::where(['id'=>$id])->delete();

            return redirect('/admin/view-users')->with('flash_message_success', 'Успешно изтрихте клиента!');
        }
    }

}
