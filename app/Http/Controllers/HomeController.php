<?php

namespace App\Http\Controllers;

use App\Holiday;
use App\LandingPage;
use App\City;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Favorite;
use App\Product;
use File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use App\Order;
use App\Category;
use App\Speditor;

class HomeController extends Controller
{
    public function index()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id'=>Auth::user()->id])->first();
        return view('home')->with([
            'holidays'=>$holidays,
            'property'=>$property,
            'user'=>$user
        ]);
    }

    public function settings(Request $request)
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();
        // Add property
        $property = LandingPage::first();
        // Add cities
        $cities = City::all();
        $user = User::where(['id'=>Auth::user()->id])->first();
        if($request->isMethod('post')){
            //upload image
            if ($request->hasFile('image')){
                // Delete old image
                $user_image = $user->image;
                if (File::exists('images/backend_images/users/'.$user_image)){
                    File::delete('images/backend_images/users/'.$user_image);
                }
                $image_temp = Input::file('image');
                if ($image_temp->isValid()){
                    $extension = $image_temp->getClientOriginalExtension();
                    $filename = $user->id.rand(111,99999).'.'.$extension;
                    $image_path = 'images/backend_images/users/'.$filename;
                    // Resize images
                    Image::make($image_temp)->resize(null, 75, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save($image_path);
                }
            }else{
                $filename = $request->input('current_image');
                if (empty($request->input('current_image'))){
                    $filename = '';
                }
            }
            if(!empty($request->input('user_name'))){
                $user->name = $request->input('user_name');
            }
            if(!empty($request->input('user_phone'))){
                $user->phone = $request->input('user_phone');
            }
            $user->address = $request->input('user_address');
            if(empty($request->input('user_address'))){
                $user->address = '';
            }
            $user->city_id = $request->input('city_id');
            $user->image = $filename;
            $user->save();
        }

        return view('users.settings')->with([
            'holidays'=>$holidays,
            'property'=>$property,
            'cities'=>$cities,
            'user'=>$user
        ]);
    }

    public function adds()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id'=>Auth::user()->id])->first();
        $orders = Order::where(['user_id'=>$user->id])->get();
        return view('users.adds')->with([
            'holidays'=>$holidays,
            'property'=>$property,
            'user'=>$user,
            'orders'=>$orders
        ]);
    }

    public function favorites()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();
        // Add property
        $property = LandingPage::first();
        // Get Favorites
        $favorites = Favorite::where(['user_id'=>Auth::user()->id])->get();
        $favorites_ids = [];
        foreach ($favorites as $favorite) {
            $favorites_ids[] = $favorite->product_id;
        }
        $products = Product::whereIn('id', $favorites_ids)->get();
        // User
        $user = User::where(['id'=>Auth::user()->id])->first();
        return view('users.favorites')->with([
            'holidays'=>$holidays,
            'property'=>$property,
            'products'=>$products,
            'user'=>$user
        ]);
    }

    public function privacy(Request $request)
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id'=>Auth::user()->id])->first();
        if($request->isMethod('post')){
            if($request->has('monthizvestia')){
                $user->monthizvestia = 1;
            }else{
                $user->monthizvestia = 0;
            }
            if($request->has('porackiizvestia')){
                $user->porackiizvestia = 1;
            }else{
                $user->porackiizvestia = 0;
            }
            if($request->has('newizvestia')){
                $user->newizvestia = 1;
            }else{
                $user->newizvestia = 0;
            }
            $user->save();
        }
        return view('users.privacy')->with([
            'holidays'=>$holidays,
            'property'=>$property,
            'user'=>$user
        ]);
    }

    public function privacyDelete(Request $request)
    {
        // User
        $user = User::where(['id'=>Auth::user()->id])->first();
        if($request->isMethod('post')){
            if($request->input('pricina') != '0'){
                $user->delete();
                return redirect()->route('logout-front-user');
            }else{
                return redirect()->back();
            }
        }
    }

    public function index_firm()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id'=>Auth::user()->id])->first();
        $products = Product::where(['user_id'=>Auth::user()->id])->get();
        return view('home_firm')->with([
            'holidays'=>$holidays,
            'property'=>$property,
            'user'=>$user,
            'products'=>$products
        ]);
    }

    public function deleteFirmAdd(Request $request, $id=null){
        if (!empty($id)){
            $product = Product::where(['id'=>$id])->first();
            $product->delete();
            return redirect('/home-firm')->with('flash_message_success', 'Успешно изтрихте офертата!');
        }
    }

    public function firmSettings(Request $request)
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();
        // Add property
        $property = LandingPage::first();
        // Add cities
        $cities = City::all();
        $user = User::where(['id'=>Auth::user()->id])->first();
        if($request->isMethod('post')){
            //upload image
            if ($request->hasFile('image')){
                // Delete old image
                $user_image = $user->image;
                if (File::exists('images/backend_images/users/'.$user_image)){
                    File::delete('images/backend_images/users/'.$user_image);
                }
                $image_temp = Input::file('image');
                if ($image_temp->isValid()){
                    $extension = $image_temp->getClientOriginalExtension();
                    $filename = $user->id.rand(111,99999).'.'.$extension;
                    $image_path = 'images/backend_images/users/'.$filename;
                    // Resize images
                    Image::make($image_temp)->resize(null, 75, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save($image_path);
                }
            }else{
                $filename = $request->input('current_image');
                if (empty($request->input('current_image'))){
                    $filename = '';
                }
            }
            if(!empty($request->input('user_name'))){
                $user->name = $request->input('user_name');
            }
            if(!empty($request->input('user_phone'))){
                $user->phone = $request->input('user_phone');
            }
            $user->address = $request->input('user_address');
            if(empty($request->input('user_address'))){
                $user->address = '';
            }
            $user->info = $request->input('user_info');
            $user->city_id = $request->input('city_id');
            $user->image = $filename;
            $user->save();
        }

        return view('firms.settings')->with([
            'holidays'=>$holidays,
            'property'=>$property,
            'cities'=>$cities,
            'user'=>$user
        ]);
    }

    public function firmAdds()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id'=>Auth::user()->id])->first();
        $products = Product::where(['user_id'=>Auth::user()->id])->get();
        return view('firms.adds')->with([
            'holidays'=>$holidays,
            'property'=>$property,
            'user'=>$user,
            'products'=>$products
        ]);
    }

    public function firmOrders()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id'=>Auth::user()->id])->first();
        $products = Product::where(['user_id'=>Auth::user()->id])->get();
        $products_ids = [];
        foreach ($products as $product) {
            $products_ids[] = $product->id;
        }
        $orders = Order::whereIn('product_id', $products_ids)->get();
        return view('firms.orders')->with([
            'holidays'=>$holidays,
            'property'=>$property,
            'user'=>$user,
            'orders'=>$orders
        ]);
    }

    public function firmPrivacy(Request $request)
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id'=>Auth::user()->id])->first();
        if($request->isMethod('post')){
            if($request->has('monthizvestia')){
                $user->monthizvestia = 1;
            }else{
                $user->monthizvestia = 0;
            }
            if($request->has('porackiizvestia')){
                $user->porackiizvestia = 1;
            }else{
                $user->porackiizvestia = 0;
            }
            if($request->has('newizvestia')){
                $user->newizvestia = 1;
            }else{
                $user->newizvestia = 0;
            }
            $user->save();
        }
        return view('firms.privacy')->with([
            'holidays'=>$holidays,
            'property'=>$property,
            'user'=>$user
        ]);
    }

    public function privacyFirmDelete(Request $request)
    {
        // User
        $user = User::where(['id'=>Auth::user()->id])->first();
        if($request->isMethod('post')){
            if($request->input('pricina') != '0'){
                $user->delete();
                return redirect()->route('logout-front-firm');
            }else{
                return redirect()->back();
            }
        }
    }

    public function firmPayments()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id'=>Auth::user()->id])->first();
        return view('firms.payments')->with([
            'holidays'=>$holidays,
            'property'=>$property,
            'user'=>$user
        ]);
    }

    public function deleteUserImage(Request $request, $id=null){
        if (!empty($id)){
            $user_image = User::where(['id'=>$id])->first()->image;
            if (File::exists('images/backend_images/users/'.$user_image)){
                File::delete('images/backend_images/users/'.$user_image);
            }
            User::where(['id'=>$id])->update(['image'=>'']);
            return redirect('/home-settings')->with('flash_message_success', 'Успешно изтрихте снимката!');
        }
    }

    public function firmProductEdit(Request $request, $id=null)
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id'=>Auth::user()->id])->first();
        // Add Categories
        $categories = Category::where(['parent_id'=>0])->get();
        // Add Speditors
        $speditors = Speditor::all();
        if($id != null){
            $product = Product::where(['id'=>$id])->first();
            if($request->isMethod('post')){

            }
            return view('firms.product_edit')->with([
                'holidays'=>$holidays,
                'property'=>$property,
                'user'=>$user,
                'product'=>$product,
                'speditors'=>$speditors,
                'categories'=>$categories
            ]);
        }else{
            return redirect('/home-firm');
        }
    }

    public function deleteProductImage(Request $request, $id=null){
        if (!empty($id)){
            $product_image = Product::where(['id'=>$id])->first()->image;
            if (File::exists('images/backend_images/products/small/'.$product_image)){
                File::delete('images/backend_images/products/small/'.$product_image);
            }
            if (File::exists('images/backend_images/products/medium/'.$product_image)){
                File::delete('images/backend_images/products/medium/'.$product_image);
            }
            if (File::exists('images/backend_images/products/large/'.$product_image)){
                File::delete('images/backend_images/products/large/'.$product_image);
            }
            Product::where(['id'=>$id])->update(['image'=>'']);
            return redirect('/home-firm-product-edit/'.$id)->with('flash_message_success', 'Успешно изтрихте снимката на продукта!');
        }
    }

}
