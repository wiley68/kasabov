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

        return view('home')->with([
            'holidays'=>$holidays,
            'property'=>$property
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
        return view('users.favorites')->with([
            'holidays'=>$holidays,
            'property'=>$property,
            'products'=>$products
        ]);
    }

    public function privacy()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();

        // Add property
        $property = LandingPage::first();

        return view('users.privacy')->with([
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

}
