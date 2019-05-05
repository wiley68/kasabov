<?php

namespace App\Http\Controllers;

use App\Category;
use App\City;
use App\Favorite;
use App\Holiday;
use App\LandingPage;
use App\Order;
use App\Product;
use App\ProductsCity;
use App\ProductsImage;
use App\ProductsTags;
use App\Speditor;
use App\Tag;
use App\User;
use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    public function index()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        return view('home')->with([
            'holidays' => $holidays,
            'property' => $property,
            'user' => $user,
        ]);
    }

    public function settings(Request $request)
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // Add cities
        $cities = City::all();
        $user = User::where(['id' => Auth::user()->id])->first();
        if ($request->isMethod('post')) {
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
            if (!empty($request->input('user_name'))) {
                $user->name = $request->input('user_name');
            }
            if (!empty($request->input('user_phone'))) {
                $user->phone = $request->input('user_phone');
            }
            $user->address = $request->input('user_address');
            if (empty($request->input('user_address'))) {
                $user->address = '';
            }
            $user->city_id = $request->input('city_id');
            $user->image = $filename;
            $user->save();
            return redirect('/home-settings')->with('flash_message_success', 'Успешно записахте промените!');
        }

        return view('users.settings')->with([
            'holidays' => $holidays,
            'property' => $property,
            'cities' => $cities,
            'user' => $user,
        ]);
    }

    public function adds()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        $orders = Order::where(['user_id' => $user->id])->get();
        return view('users.adds')->with([
            'holidays' => $holidays,
            'property' => $property,
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    public function favorites()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // Get Favorites
        $favorites = Favorite::where(['user_id' => Auth::user()->id])->get();
        $favorites_ids = [];
        foreach ($favorites as $favorite) {
            $favorites_ids[] = $favorite->product_id;
        }
        $products = Product::whereIn('id', $favorites_ids)->get();
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        return view('users.favorites')->with([
            'holidays' => $holidays,
            'property' => $property,
            'products' => $products,
            'user' => $user,
        ]);
    }

    public function privacy(Request $request)
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        if ($request->isMethod('post')) {
            if ($request->has('monthizvestia')) {
                $user->monthizvestia = 1;
            } else {
                $user->monthizvestia = 0;
            }
            if ($request->has('porackiizvestia')) {
                $user->porackiizvestia = 1;
            } else {
                $user->porackiizvestia = 0;
            }
            if ($request->has('newizvestia')) {
                $user->newizvestia = 1;
            } else {
                $user->newizvestia = 0;
            }
            $user->save();
            return redirect('/home-privacy')->with('flash_message_success', 'Успешно записахте промените!');
        }
        return view('users.privacy')->with([
            'holidays' => $holidays,
            'property' => $property,
            'user' => $user,
        ]);
    }

    public function privacyDelete(Request $request)
    {
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        if ($request->isMethod('post')) {
            if ($request->input('pricina') != '0') {
                $user->delete();
                return redirect()->route('logout-front-user');
            } else {
                return redirect()->back();
            }
        }
    }

    public function index_firm()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        $products = Product::where(['user_id' => Auth::user()->id])->get();
        return view('home_firm')->with([
            'holidays' => $holidays,
            'property' => $property,
            'user' => $user,
            'products' => $products,
        ]);
    }

    public function deleteFirmAdd(Request $request, $id = null)
    {
        if (!empty($id)) {
            $this->deleteProduct($id);
            return redirect('/home-firm')->with('flash_message_success', 'Успешно изтрихте офертата!');
        }
    }

    private function deleteProduct($id=null){
        if($id != null){
            // Delete orders
            Order::where(['product_id'=>$id])->delete();
            // Delete products_cities
            ProductsCity::where(['product_id'=>$id])->delete();
            // Delete products images
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
            ProductsImage::where(['product_id'=>$id])->delete();
            // Delete products tag
            ProductsTags::where(['product_id'=>$id])->delete();
            // Delete favorites
            Favorite::where(['product_id'=>$id])->delete();
            Product::where(['id'=>$id])->delete();
        }
    }

    public function firmSettings(Request $request)
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // Add cities
        $cities = City::all();
        $user = User::where(['id' => Auth::user()->id])->first();
        if ($request->isMethod('post')) {
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
            if (!empty($request->input('user_name'))) {
                $user->name = $request->input('user_name');
            }
            if (!empty($request->input('user_phone'))) {
                $user->phone = $request->input('user_phone');
            }
            $user->address = $request->input('user_address');
            if (empty($request->input('user_address'))) {
                $user->address = '';
            }
            $user->info = $request->input('user_info');
            $user->city_id = $request->input('city_id');
            $user->image = $filename;
            $user->save();
            return redirect('/home-firm-settings')->with('flash_message_success', 'Успешно записахте промените!');
        }

        return view('firms.settings')->with([
            'holidays' => $holidays,
            'property' => $property,
            'cities' => $cities,
            'user' => $user,
        ]);
    }

    public function firmAdds()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        $products = Product::where(['user_id' => Auth::user()->id])->get();
        return view('firms.adds')->with([
            'holidays' => $holidays,
            'property' => $property,
            'user' => $user,
            'products' => $products,
        ]);
    }

    public function firmOrders()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        $products = Product::where(['user_id' => Auth::user()->id])->get();
        $products_ids = [];
        foreach ($products as $product) {
            $products_ids[] = $product->id;
        }
        $orders = Order::whereIn('product_id', $products_ids)->get();
        return view('firms.orders')->with([
            'holidays' => $holidays,
            'property' => $property,
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    public function firmPrivacy(Request $request)
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        if ($request->isMethod('post')) {
            if ($request->has('monthizvestia')) {
                $user->monthizvestia = 1;
            } else {
                $user->monthizvestia = 0;
            }
            if ($request->has('porackiizvestia')) {
                $user->porackiizvestia = 1;
            } else {
                $user->porackiizvestia = 0;
            }
            if ($request->has('newizvestia')) {
                $user->newizvestia = 1;
            } else {
                $user->newizvestia = 0;
            }
            $user->save();
            return redirect('/home-firm-privacy')->with('flash_message_success', 'Успешно записахте промените!');
        }
        return view('firms.privacy')->with([
            'holidays' => $holidays,
            'property' => $property,
            'user' => $user,
        ]);
    }

    public function privacyFirmDelete(Request $request)
    {
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        if ($request->isMethod('post')) {
            if ($request->input('pricina') != '0') {
                // Delete products
                $products = Product::where(['user_id'=>$user->id])->get();
                foreach ($products as $product) {
                    $this->deleteProduct($product->id);
                }
                $user->delete();
                return redirect()->route('logout-front-firm');
            } else {
                return redirect()->back();
            }
        }
    }

    public function firmPayments()
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        return view('firms.payments')->with([
            'holidays' => $holidays,
            'property' => $property,
            'user' => $user,
        ]);
    }

    public function deleteUserImage(Request $request, $id = null)
    {
        if (!empty($id)) {
            $user_image = User::where(['id' => $id])->first()->image;
            if (File::exists('images/backend_images/users/' . $user_image)) {
                File::delete('images/backend_images/users/' . $user_image);
            }
            User::where(['id' => $id])->update(['image' => '']);
            return redirect('/home-settings')->with('flash_message_success', 'Успешно изтрихте снимката!');
        }
    }

    public function firmProductEdit(Request $request, $id = null)
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        // Add Categories
        $categories = Category::where(['parent_id' => 0])->get();
        // Add Speditors
        $speditors = Speditor::all();
        $cities = City::all();
        $oblasti = City::whereColumn('city', 'oblast')->get();
        if ($id != null) {
            $product = Product::where(['id' => $id])->first();
            $tags = ProductsTags::where(['product_id' => $product->id])->get();
            if ($request->isMethod('post')) {
                // Validate fields
                if (empty($request->input('category_id')) || $request->input('category_id') == 0) {
                    return redirect('/home-firm-product-edit/' . $product->id)->with('flash_message_error', 'Трябва да изберете категория!');
                }
                //upload image
                if ($request->hasFile('image')) {
                    // Delete old image
                    $product_image = $product->image;
                    if (File::exists('images/backend_images/products/small/' . $product_image)) {
                        File::delete('images/backend_images/products/small/' . $product_image);
                    }
                    if (File::exists('images/backend_images/products/medium/' . $product_image)) {
                        File::delete('images/backend_images/products/medium/' . $product_image);
                    }
                    if (File::exists('images/backend_images/products/large/' . $product_image)) {
                        File::delete('images/backend_images/products/large/' . $product_image);
                    }
                    $image_temp = Input::file('image');
                    if ($image_temp->isValid()) {
                        $extension = $image_temp->getClientOriginalExtension();
                        $filename = rand(111, 99999) . '.' . $extension;
                        $large_image_path = 'images/backend_images/products/large/' . $filename;
                        $medium_image_path = 'images/backend_images/products/medium/' . $filename;
                        $small_image_path = 'images/backend_images/products/small/' . $filename;
                        // Resize images
                        Image::make($image_temp)->resize(null, 1200, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save($large_image_path);
                        Image::make($image_temp)->resize(null, 600, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save($medium_image_path);
                        Image::make($image_temp)->resize(null, 300, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save($small_image_path);
                    }
                } else {
                    $filename = $request->input('current_image');
                    if (empty($request->input('current_image'))) {
                        $filename = '';
                    }
                }
                $product->category_id = $request->input('category_id');
                $product->holiday_id = $request->input('holiday_id');
                $product->product_name = $request->input('product_name');
                $product->product_code = $request->input('product_code');
                if (empty($request->input('quantity'))) {
                    $product->quantity = 0;
                } else {
                    $product->quantity = $request->input('quantity');
                }
                $product->price = $request->input('price');
                $product->description = $request->input('description');
                if (empty($product->description)) {
                    $product->description = '';
                }
                $product->image = $filename;
                $product->first_color = $request->input('first_color');
                $product->second_color = $request->input('second_color');
                $product->age = $request->input('age');
                $product->pol = $request->input('pol');
                $product->condition = $request->input('condition');
                $product->send_id = $request->input('send_id');
                $product->send_from_id = $request->input('send_from_id');
                if (empty($request->input('price_send'))) {
                    $product->price_send = 0.00;
                } else {
                    $product->price_send = $request->input('price_send');
                }
                $product->send_free = $request->input('send_free');
                $product->send_free_id = $request->input('send_free_id');
                $product->available_for = $request->input('available_for');
                $available_cities = [];
                switch ($product->available_for) {
                    case 'country':
                        $available_for_city = 0;
                        break;
                    case 'city':
                        $available_for_city = $request->input('available_for_city');
                        break;
                    case 'cities':
                        $available_for_city = 0;
                        foreach ($request->input('available_for_cities') as $item) {
                            $available_cities[] = $item;
                        }
                        break;
                    case 'area':
                        $available_for_city = $request->input('available_for_oblast');
                        break;
                    default:
                        $available_for_city = 0;
                        break;
                }
                $product->available_for_city = $available_for_city;
                $product->object = $request->input('object');
                if (empty($request->input('object_name'))) {
                    $product->object_name = '';
                } else {
                    $product->object_name = $request->input('object_name');
                }
                $product->personalize = $request->input('personalize');
                $product->status = $request->input('status');
                $product->save();

                // Add tags to tags table
                // Delete all tags
                $tags_count = ProductsTags::where(['product_id' => $product->id])->count();
                if ($tags_count > 0) {
                    ProductsTags::where(['product_id' => $product->id])->delete();
                }
                if (!empty($request->input('tags'))) {
                    foreach ($request->input('tags') as $tag) {
                        if (Tag::where(['name' => $tag])->get()->count() > 0) {
                            $tag_id = Tag::where(['name' => $tag])->first()->id;
                        } else {
                            $new_tag = new Tag();
                            $new_tag->name = $tag;
                            $new_tag->save();
                            $tag_id = $new_tag->id;
                        }
                        $products_tag = new ProductsTags();
                        $products_tag->product_id = $product->id;
                        $products_tag->tag_id = $tag_id;
                        $products_tag->save();
                    }
                }

                // Add city to cities table
                // Delete old cities
                $products_cities_count = ProductsCity::where(['product_id' => $product->id])->count();
                if ($products_cities_count > 0) {
                    ProductsCity::where(['product_id' => $product->id])->delete();
                }
                // Add new cities
                if (!empty($available_cities)) {
                    foreach ($available_cities as $available_city) {
                        $new_city = new ProductsCity();
                        $new_city->product_id = $product->id;
                        $new_city->city_id = $available_city;
                        $new_city->save();
                    }
                }

                return redirect('/home-firm-product-edit/' . $product->id)->with('flash_message_success', 'Успешно редактирахте продукта!');
            }
            return view('firms.product_edit')->with([
                'holidays' => $holidays,
                'property' => $property,
                'user' => $user,
                'product' => $product,
                'speditors' => $speditors,
                'cities' => $cities,
                'categories' => $categories,
                'oblasti' => $oblasti,
                'tags' => $tags,
            ]);
        } else {
            return redirect('/home-firm');
        }
    }

    public function firmProductNew(Request $request)
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        // Add Categories
        $categories = Category::where(['parent_id' => 0])->get();
        // Add Speditors
        $speditors = Speditor::all();
        $cities = City::all();
        $oblasti = City::whereColumn('city', 'oblast')->get();

        $product = new Product();
        if ($request->isMethod('post')) {
            // Validate fields
            if (empty($request->input('category_id')) || $request->input('category_id') == 0) {
                return redirect('/home-firm-product-new/' . $product->id)->with('flash_message_error', 'Трябва да изберете категория!');
            }
            //upload image
            if ($request->hasFile('image')) {
                $image_temp = Input::file('image');
                if ($image_temp->isValid()) {
                    $extension = $image_temp->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/products/large/' . $filename;
                    $medium_image_path = 'images/backend_images/products/medium/' . $filename;
                    $small_image_path = 'images/backend_images/products/small/' . $filename;
                    // Resize images
                    Image::make($image_temp)->resize(null, 1200, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($large_image_path);
                    Image::make($image_temp)->resize(null, 600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($medium_image_path);
                    Image::make($image_temp)->resize(null, 300, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($small_image_path);
                }
            } else {
                $filename = $request->input('current_image');
                if (empty($request->input('current_image'))) {
                    $filename = '';
                }
            }
            $product->user_id = Auth::user()->id;
            $product->category_id = $request->input('category_id');
            $product->holiday_id = $request->input('holiday_id');
            $product->product_name = $request->input('product_name');
            $product->product_code = $request->input('product_code');
            if (empty($request->input('quantity'))) {
                $product->quantity = 0;
            } else {
                $product->quantity = $request->input('quantity');
            }
            $product->price = $request->input('price');
            $product->description = $request->input('description');
            if (empty($product->description)) {
                $product->description = '';
            }
            $product->image = $filename;
            $product->first_color = $request->input('first_color');
            $product->second_color = $request->input('second_color');
            $product->age = $request->input('age');
            $product->pol = $request->input('pol');
            $product->condition = $request->input('condition');
            $product->send_id = $request->input('send_id');
            $product->send_from_id = $request->input('send_from_id');
            if (empty($request->input('price_send'))) {
                $product->price_send = 0.00;
            } else {
                $product->price_send = $request->input('price_send');
            }
            $product->send_free = $request->input('send_free');
            $product->send_free_id = $request->input('send_free_id');
            $product->available_for = $request->input('available_for');
            $available_cities = [];
            switch ($product->available_for) {
                case 'country':
                    $available_for_city = 0;
                    break;
                case 'city':
                    $available_for_city = $request->input('available_for_city');
                    break;
                case 'cities':
                    $available_for_city = 0;
                    foreach ($request->input('available_for_cities') as $item) {
                        $available_cities[] = $item;
                    }
                    break;
                case 'area':
                    $available_for_city = $request->input('available_for_oblast');
                    break;
                default:
                    $available_for_city = 0;
                    break;
            }
            $product->available_for_city = $available_for_city;
            $product->object = $request->input('object');
            if (empty($request->input('object_name'))) {
                $product->object_name = '';
            } else {
                $product->object_name = $request->input('object_name');
            }
            $product->personalize = $request->input('personalize');
            $product->status = $request->input('status');
            $product->save();

            // Add tags to tags table
            if (!empty($request->input('tags'))) {
                foreach ($request->input('tags') as $tag) {
                    if (Tag::where(['name' => $tag])->get()->count() > 0) {
                        $tag_id = Tag::where(['name' => $tag])->first()->id;
                    } else {
                        $new_tag = new Tag();
                        $new_tag->name = $tag;
                        $new_tag->save();
                        $tag_id = $new_tag->id;
                    }
                    $products_tag = new ProductsTags();
                    $products_tag->product_id = $product->id;
                    $products_tag->tag_id = $tag_id;
                    $products_tag->save();
                }
            }

            // Add city to cities table
            // Add new cities
            if (!empty($available_cities)) {
                foreach ($available_cities as $available_city) {
                    $new_city = new ProductsCity();
                    $new_city->product_id = $product->id;
                    $new_city->city_id = $available_city;
                    $new_city->save();
                }
            }

            return redirect('/home-firm-product-edit/' . $product->id)->with('flash_message_success', 'Успешно добавихте продукта!');
        }
        return view('firms.product_new')->with([
            'holidays' => $holidays,
            'property' => $property,
            'user' => $user,
            'product' => $product,
            'speditors' => $speditors,
            'cities' => $cities,
            'categories' => $categories,
            'oblasti' => $oblasti
        ]);
    }

    public function deleteProductImage(Request $request, $id = null)
    {
        if (!empty($id)) {
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
            Product::where(['id' => $id])->update(['image' => '']);
            return redirect('/home-firm-product-edit/' . $id)->with('flash_message_success', 'Успешно изтрихте снимката на продукта!');
        }
    }

    public function addImages(Request $request, $id = null)
    {
        $product = Product::with('images')->where(['id' => $id])->first();
        $user = User::where(['id' => Auth::user()->id])->first();
        $holidays = Holiday::where(['parent_id' => 0])->get();
        $property = LandingPage::first();

        if ($request->isMethod('post')) {
            if ($request->hasFile('image')) {
                $files = $request->file('image');
                //upload images
                foreach ($files as $file) {
                    if ($file->isValid()) {
                        $extension = $file->getClientOriginalExtension();
                        $filename = rand(111, 99999) . '.' . $extension;
                        $large_image_path = 'images/backend_images/products/large/' . $filename;
                        $medium_image_path = 'images/backend_images/products/medium/' . $filename;
                        $small_image_path = 'images/backend_images/products/small/' . $filename;
                        // Resize images
                        Image::make($file)->resize(null, 1200, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save($large_image_path);
                        Image::make($file)->resize(null, 600, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save($medium_image_path);
                        Image::make($file)->resize(null, 300, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save($small_image_path);
                        // Store image in table
                        $productsImage = new ProductsImage();
                        $productsImage->product_id = $id;
                        $productsImage->image = $filename;
                        $productsImage->save();
                    }
                }
                return redirect('/home-add-product-images/' . $id)->with('flash_message_success', 'Успешно добавихте снимките на продукта!');
            }
        }

        return view('firms.add_images')->with([
            'product' => $product,
            'user' => $user,
            'holidays' => $holidays,
            'property' => $property,
        ]);
    }

}
