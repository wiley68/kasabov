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
use App\Payment;
use App\ProductsCitySend;
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
        $orders = Order::where(['user_id' => $user->id]);
        $paginate = 5;
        $orders = $orders->paginate($paginate);
        return view('users.adds')->with([
            'holidays' => $holidays,
            'property' => $property,
            'user' => $user,
            'orders' => $orders,
            'paginate'=>$paginate
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
        Product::where(['user_id' => Auth::user()->id, 'status'=>'active'])->where('active_at', '<=', date("Y-m-d", strtotime("-1 months")))->update(array('status' => 'expired'));
        $products = Product::where(['user_id' => Auth::user()->id]);
        $paginate = 5;
        $products = $products->paginate($paginate);
        $active_payments = Payment::where(['user_id'=>Auth::user()->id, 'status'=>'active', 'forthe'=>'standart'])->where('active_at', '>=', date("Y-m-d", strtotime("-2 months")))->count();
        $active_products = Product::where(['user_id'=>Auth::user()->id, 'status'=>'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->count();
        $active_payments_r1 = Payment::where(['user_id'=>Auth::user()->id, 'status'=>'active', 'forthe'=>'reklama1'])->where('active_at', '>=', date("Y-m-d", strtotime("-5 days")))->count();
        $active_payments_r3 = Payment::where(['user_id'=>Auth::user()->id, 'status'=>'active', 'forthe'=>'reklama3'])->where('active_at', '>=', date("Y-m-d", strtotime("-10 days")))->count();
        $featured_products = Product::where(['user_id'=>Auth::user()->id, 'status'=>'active', 'featured'=>1])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->count();
        return view('home_firm')->with([
            'holidays' => $holidays,
            'property' => $property,
            'user' => $user,
            'products' => $products,
            'paginate'=>$paginate,
            'active_payments'=> intval($active_payments) * 20 + 10,
            'active_products'=>intval($active_products),
            'products_ostatak'=>intval($active_payments) * 20 + 10 - intval($active_products),
            'active_reklama'=>intval($active_payments_r1) * 1 + intval($active_payments_r3) * 3,
            'featured_products'=>intval($featured_products),
            'featured_ostatak'=>intval($active_payments_r1) * 1 + intval($active_payments_r3) * 3 - intval($featured_products),
            'active_payments_all'=>intval($active_payments) + intval($active_payments_r1) + intval($active_payments_r3)
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
            // Delete products_cities
            $productsCities = ProductsCity::where(['product_id'=>$id])->get();
            foreach ($productsCities as $product_city) {
                $product_city->delete();
            }
            $productsCitiesSend = ProductsCitySend::where(['product_id'=>$id])->get();
            foreach ($productsCitiesSend as $product_city) {
                $product_city->delete();
            }
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

    public function firmAdds($payed='No')
    {
        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // User
        $user = User::where(['id' => Auth::user()->id])->first();
        Product::where(['user_id' => Auth::user()->id, 'status'=>'active'])->where('active_at', '<=', date("Y-m-d", strtotime("-1 months")))->update(array('status' => 'expired'));
        if ($payed == 'Yes'){
            $products = Product::where([
                'user_id' => Auth::user()->id,
                'featured' => 1
            ]);
        }else{
            $products = Product::where(['user_id' => Auth::user()->id]);
        }
        $paginate = 5;
        $products = $products->paginate($paginate);
        return view('firms.adds')->with([
            'holidays' => $holidays,
            'property' => $property,
            'user' => $user,
            'products' => $products,
            'paginate'=>$paginate
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
        $orders = Order::whereIn('product_id', $products_ids);
        $paginate = 5;
        $orders = $orders->paginate($paginate);
        return view('firms.orders')->with([
            'holidays' => $holidays,
            'property' => $property,
            'user' => $user,
            'orders' => $orders,
            'paginate'=>$paginate
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
                $product->price = $request->input('price');
                $product->description = $request->input('description');
                if (empty($product->description)) {
                    $product->description = '';
                }
                $product->image = $filename;
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
                $product->send_free_available_for = $request->input('send_free_available_for');
                $send_free_available_cities = [];
                switch ($product->send_free_available_for) {
                    case 'country':
                        $send_free_id = 0;
                        break;
                    case 'city':
                        $send_free_id = $request->input('send_free_id');
                        break;
                    case 'cities':
                        $send_free_id = 0;
                        if(!empty($request->input('send_free_available_for_cities'))){
                            foreach ($request->input('send_free_available_for_cities') as $item) {
                                $send_free_available_cities[] = $item;
                            }
                        }
                        break;
                    case 'area':
                        $send_free_id = $request->input('send_free_oblast');
                        break;
                    default:
                        $send_free_id = 0;
                        break;
                }
                $product->send_free_id = $send_free_id;

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
                        if (!empty($request->input('available_for_cities'))){
                            foreach ($request->input('available_for_cities') as $item) {
                                $available_cities[] = $item;
                            }    
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

                // check statuses
                $old_status = $product->status;
                $new_status = $request->input('status');
                if ($new_status == 'active'){
                    if ($old_status != 'active'){
                        // test for available items
                        $products_count = Product::where(['user_id'=>$product->user_id, 'status'=>'active'])->count();
                        // check active payments
                        $active_payments = Payment::where(['user_id'=>$product->user_id, 'status'=>'active', 'forthe'=>'standart'])->where('active_at', '>=', date("Y-m-d", strtotime("-2 months")))->count();
                        $active_products = intval($active_payments) * 20 + 10;
                        if ($products_count > $active_products){
                            return redirect('/home-firm-product-edit/'.$product->id)->with('flash_message_error', 'Вече имате ' . $active_products . ' броя активни реклами! Моля ако желаете да увеличите бройката им, закупете си допълнителен пакет.');
                        }else{
                            $product->status = $request->input('status');
                            $product->active_at = date('Y-m-d H:i:s');
                        }
                    }
                }else{
                    $product->status = $request->input('status');
                }

                // check featured
                $old_featured = $product->featured;
                $new_featured = $request->input('featured');
                if ($new_featured == 1){
                    if ($old_featured != 1){
                        // test for available featured
                        $products_count_f = Product::where(['user_id'=>$product->user_id, 'featured'=>1])->count();
                        // check active payments
                        $active_payments_1 = Payment::where(['user_id'=>$product->user_id, 'status'=>'active', 'forthe'=>'reklama1'])->where('active_at', '>=', date("Y-m-d", strtotime("-5 days")))->count();
                        $active_payments_2 = Payment::where(['user_id'=>$product->user_id, 'status'=>'active', 'forthe'=>'reklama3'])->where('active_at', '>=', date("Y-m-d", strtotime("-10 days")))->count();
                        $active_products_f = intval($active_payments_1) * 1 + intval($active_payments_2) * 3;
                        if ($products_count_f >= $active_products_f){
                            return redirect('/home-firm-product-edit/'.$product->id)->with('flash_message_error', 'Вече имате ' . $active_products_f . ' броя промоционални реклами! Моля ако желаете да увеличите бройката им, закупете си допълнителен пакет.');
                        }else{
                         $product->featured = $request->input('featured');
                        }
                    }
                }else{
                    $product->featured = $request->input('featured');
                }

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
                // Delete old cities send
                $products_cities_send_count = ProductsCitySend::where(['product_id'=>$product->id])->count();
                if ($products_cities_send_count > 0){
                 ProductsCitySend::where(['product_id'=>$product->id])->delete();
                }
                // Add new cities send
                if(!empty($send_free_available_cities)){
                    foreach ($send_free_available_cities as $available_city) {
                        $new_city = new ProductsCitySend();
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
            $product->price = $request->input('price');
            $product->description = $request->input('description');
            if (empty($product->description)) {
                $product->description = '';
            }
            $product->image = $filename;
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
            
            $send_free = $request->input('send_free');
            $send_free_available_for = $request->input('send_free_available_for');
            $send_free_available_cities = [];
            switch ($send_free_available_for) {
                case 'country':
                    $send_free_id = 0;
                    break;
                case 'city':
                    $send_free_id = $request->input('send_free_id');
                    break;
                case 'cities':
                    $send_free_id = 0;
                    if(!empty($request->input('send_free_available_for_cities'))){
                        foreach ($request->input('send_free_available_for_cities') as $item) {
                            $send_free_available_cities[] = $item;
                        }
                    }
                    break;
                case 'area':
                    $send_free_id = $request->input('send_free_oblast');
                    break;
                default:
                    $send_free_id = 0;
                    break;
            }
            $product->send_free = $send_free;
            $product->send_free_id = $send_free_id;
            $product->send_free_available_for = $send_free_available_for;

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
                    if ($request->input('available_for_cities') != null){
                        foreach ($request->input('available_for_cities') as $item) {
                            $available_cities[] = $item;
                        }    
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

            // check statuses
            $new_status = $request->input('status');
            if ($new_status == 'active'){
                // test for available items
                $products_count = Product::where(['user_id'=>Auth::user()->id, 'status'=>'active'])->count();
                // check active payments
                $active_payments = Payment::where(['user_id'=>Auth::user()->id, 'status'=>'active', 'forthe'=>'standart'])->where('active_at', '>=', date("Y-m-d", strtotime("-2 months")))->count();
                $active_products = intval($active_payments) * 20 + 10;
                if ($products_count > $active_products){
                    return redirect('/home-firm-product-new')->with('flash_message_error', 'Вече имате ' . $active_products . ' броя активни реклами! Моля ако желаете да увеличите бройката им, закупете си допълнителен пакет.');
                }else{
                    $product->status = $request->input('status');
                    $product->active_at = date('Y-m-d H:i:s');
                }
            }else{
                $product->status = $request->input('status');
            }

            // check featured
            $new_featured = $request->input('featured');
            if ($new_featured == 1){
                // test for available featured
                $products_count_f = Product::where(['user_id'=>Auth::user()->id, 'featured'=>1])->count();
                // check active payments
                $active_payments_1 = Payment::where(['user_id'=>Auth::user()->id, 'status'=>'active', 'forthe'=>'reklama1'])->where('active_at', '>=', date("Y-m-d", strtotime("-5 days")))->count();
                $active_payments_2 = Payment::where(['user_id'=>Auth::user()->id, 'status'=>'active', 'forthe'=>'reklama3'])->where('active_at', '>=', date("Y-m-d", strtotime("-10 days")))->count();
                $active_products_f = intval($active_payments_1) * 1 + intval($active_payments_2) * 3;
                if ($products_count_f >= $active_products_f){
                    return redirect('/home-firm-product-new')->with('flash_message_error', 'Вече имате ' . $active_products_f . ' броя промоционални реклами! Моля ако желаете да увеличите бройката им, закупете си допълнителен пакет.');
                }else{
                    $product->featured = $request->input('featured');
                }
            }else{
                $product->featured = $request->input('featured');
            }

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
            if(!empty($send_free_available_cities)){
                foreach ($send_free_available_cities as $available_city) {
                    $new_city = new ProductsCitySend();
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
