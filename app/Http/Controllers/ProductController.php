<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Product;
use App\User;
use App\Category;
use Intervention\Image\Facades\Image;
use File;
use App\ProductsImage;
use App\Tag;
use App\ProductsTags;
use App\Speditor;
use App\City;
use App\Holiday;
use App\LandingPage;
use Carbon\Carbon;
use App\ProductsCity;

class ProductController extends Controller
{
    public function addProduct(Request $request){
        if ($request->isMethod('post')){
            $user_id = $request->input('user_id');
            if ($user_id === "0"){
                return redirect('/admin/add-product')->with('flash_message_error', 'Необходимо е да изберете собственик на продукта!');
            }
            $category_id = $request->input('category_id');
            if ($category_id === "0"){
                return redirect('/admin/add-product')->with('flash_message_error', 'Необходимо е да изберете категория за продукта!');
            }
            $holiday_id = $request->input('holiday_id');
            $product_name = $request->input('product_name');
            $product_code = $request->input('product_code');
            $first_color = $request->input('first_color');
            $second_color = $request->input('second_color');
            $age = $request->input('age');
            $pol = $request->input('pol');
            $condition = $request->input('condition');
            $send_id = $request->input('send_id');
            $send_from_id = $request->input('send_from_id');
            if (empty($request->input('price_send'))){
                $price_send = 0.00;
            }else{
                $price_send = $request->input('price_send');
            }
            $send_free = $request->input('send_free');
            $send_free_id = $request->input('send_free_id');
            $available_for = $request->input('available_for');
            $available_cities = [];
            switch ($available_for) {
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
            $object = $request->input('object');
            if (empty($request->input('object_name'))){
                $object_name = '';
            }else{
                $object_name = $request->input('object_name');
            }
            $personalize = $request->input('personalize');
            $description = $request->input('description');
            if (empty($request->input('quantity'))){
                $quantity = 0;
            }else{
                $quantity = $request->input('quantity');
            }
            $price = $request->input('price');
            // Create product column
            $product = new Product();
            $product->user_id = $user_id;
            $product->category_id = $category_id;
            $product->holiday_id = $holiday_id;
            $product->product_name = $product_name;
            $product->product_code = $product_code;
            $product->first_color = $first_color;
            $product->second_color = $second_color;
            $product->age = $age;
            $product->pol = $pol;
            $product->condition = $condition;
            $product->send_id = $send_id;
            $product->send_from_id = $send_from_id;
            $product->price_send = $price_send;
            $product->send_free = $send_free;
            $product->send_free_id = $send_free_id;
            $product->available_for = $available_for;
            $product->available_for_city = $available_for_city;
            $product->object = $object;
            $product->object_name = $object_name;
            $product->personalize = $personalize;
            $product->description = $description;
            if (empty($description)){
                $product->description = '';
            }
            $product->quantity = $quantity;
            $product->price = $price;
            //upload image
            if ($request->hasFile('image')){
                $image_temp = Input::file('image');
                if ($image_temp->isValid()){
                    $extension = $image_temp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
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
                    // Store image names in table
                    $product->image = $filename;
                }
            }else{
                $product->image = '';
            }
            $product->save();
            // Add city to cities table
            if(!empty($available_cities)){
                foreach ($available_cities as $available_city) {
                    $new_city = new ProductsCity();
                    $new_city->product_id = $product->id;
                    $new_city->city_id = $available_city;
                    $new_city->save();
                }
            }
            // Add tags to tags table
            // Delete oll tags
            if (!empty($request->tags)){
                foreach ($request->tags as $tag) {
                    if (Tag::where(['name'=>$tag])->get()->count() > 0){
                        $tag_id = Tag::where(['name'=>$tag])->first()->id;
                    }else{
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
            return redirect('/admin/view-products')->with('flash_message_success', 'Успешно създадохте нов продукт!');
        }
        $categories = Category::where(['parent_id'=>0])->get();
        $users = User::where(['admin'=>0])->get();
        $speditors = Speditor::all();
        $cities = City::all();
        $holidays = Holiday::where(['parent_id'=>0])->get();
        return view('admin.products.add_product')->with([
            'categories'=>$categories,
            'users'=>$users,
            'speditors'=>$speditors,
            'cities'=>$cities,
            'holidays'=>$holidays
            ]);
    }

    public function editProduct(Request $request, $id=null){
        $product = Product::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            //upload image
            if ($request->hasFile('image')){
                // Delete old image
                $product_image = $product->image;
                if (File::exists('images/backend_images/products/small/'.$product_image)){
                    File::delete('images/backend_images/products/small/'.$product_image);
                }
                if (File::exists('images/backend_images/products/medium/'.$product_image)){
                    File::delete('images/backend_images/products/medium/'.$product_image);
                }
                if (File::exists('images/backend_images/products/large/'.$product_image)){
                    File::delete('images/backend_images/products/large/'.$product_image);
                }
                $image_temp = Input::file('image');
                if ($image_temp->isValid()){
                    $extension = $image_temp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
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
            }else{
                $filename = $request->input('current_image');
                if (empty($request->input('current_image'))){
                    $filename = '';
                }
            }
            $product->user_id = $request->input('user_id');
            $product->category_id = $request->input('category_id');
            $product->holiday_id = $request->input('holiday_id');
            $product->product_name = $request->input('product_name');
            $product->product_code = $request->input('product_code');
            $product->first_color = $request->input('first_color');
            $product->second_color = $request->input('second_color');
            $product->age = $request->input('age');
            $product->pol = $request->input('pol');
            $product->condition = $request->input('condition');
            $product->send_id = $request->input('send_id');
            $product->send_from_id = $request->input('send_from_id');
            if (empty($request->input('price_send'))){
                $product->price_send = 0.00;
            }else{
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
            if (empty($request->input('object_name'))){
                $product->object_name = '';
            }else{
                $product->object_name = $request->input('object_name');
            }
            $product->personalize = $request->input('personalize');
            $product->description = $request->input('description');
            if (empty($product->description)){
                $product->description = '';
            }
            if (empty($request->input('quantity'))){
                $product->quantity = 0;
            }else{
                $product->quantity = $request->input('quantity');
            }
            $product->price = $request->input('price');
            $product->image = $filename;
            $product->save();

            // Add tags to tags table
            // Delete all tags
            $tags_count = ProductsTags::where(['product_id'=>$product->id])->count();
            if ($tags_count > 0){
                ProductsTags::where(['product_id'=>$product->id])->delete();
                foreach ($request->tags as $tag) {
                    if (Tag::where(['name'=>$tag])->get()->count() > 0){
                        $tag_id = Tag::where(['name'=>$tag])->first()->id;
                    }else{
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
            $products_cities_count = ProductsCity::where(['product_id'=>$product->id])->count();
            if ($products_cities_count > 0){
                ProductsCity::where(['product_id'=>$product->id])->delete();
            }
            // Add new cities
            if(!empty($available_cities)){
                foreach ($available_cities as $available_city) {
                    $new_city = new ProductsCity();
                    $new_city->product_id = $product->id;
                    $new_city->city_id = $available_city;
                    $new_city->save();
                }
            }

            return redirect('/admin/edit-product/'.$product->id)->with('flash_message_success', 'Успешно редактирахте продукта!');
        }
        $categories = Category::where(['parent_id'=>0])->get();
        $users = User::where(['admin'=>0])->get();
        $tags = ProductsTags::where(['product_id'=>$product->id])->get();
        $speditors = Speditor::all();
        $cities = City::all();
        $holidays = Holiday::where(['parent_id'=>0])->get();
        return view('admin.products.edit_product')->with([
            'product'=>$product,
            'categories'=>$categories,
            'users'=>$users,
            'tags'=>$tags,
            'speditors'=>$speditors,
            'cities'=>$cities,
            'holidays'=>$holidays
            ]);
    }

    public function deleteProduct(Request $request, $id=null){
        if (!empty($id)){
            $product = Product::where(['id'=>$id])->first();
            // Delete image
            $product_image = $product->image;
            if (File::exists('images/backend_images/products/small/'.$product_image)){
                File::delete('images/backend_images/products/small/'.$product_image);
            }
            if (File::exists('images/backend_images/products/medium/'.$product_image)){
                File::delete('images/backend_images/products/medium/'.$product_image);
            }
            if (File::exists('images/backend_images/products/large/'.$product_image)){
                File::delete('images/backend_images/products/large/'.$product_image);
            }
            // Delete images
            $productsImage = ProductsImage::where(['product_id'=>$id])->get();
            foreach ($productsImage as $image) {
                if (File::exists('images/backend_images/products/small/'.$image->image)){
                    File::delete('images/backend_images/products/small/'.$image->image);
                }
                if (File::exists('images/backend_images/products/medium/'.$image->image)){
                    File::delete('images/backend_images/products/medium/'.$image->image);
                }
                if (File::exists('images/backend_images/products/large/'.$image->image)){
                    File::delete('images/backend_images/products/large/'.$image->image);
                }
                $image->delete();
            }
            // Delete products_cities
            $productsCities = ProductsCity::where(['product_id'=>$id])->get();
            foreach ($productsCities as $product_city) {
                $product_city->delete();
            }
            // Delete product
            $product->delete();
            return redirect('/admin/view-products')->with('flash_message_success', 'Успешно изтрихте продукта!');
        }
    }

    public function viewProducts(){
        $products = Product::all();
        return view('admin.products.view_products')->with(['products'=>$products]);
    }

    public static function getProductById($id=null){
        if (!empty($id)){
            $product = Product::where(['id'=>$id])->first();
            return $product;
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
            return redirect('/admin/edit-product/'.$id)->with('flash_message_success', 'Успешно изтрихте снимката на продукта!');
        }
    }

    public function addImages(Request $request, $id=null){
        $product = Product::with('images')->where(['id'=>$id])->first();

        if ($request->isMethod('post')){
            if ($request->hasFile('image')){
                $files = $request->file('image');
                //upload images
                foreach ($files as $file) {
                    if ($file->isValid()){
                        $extension = $file->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extension;
                        $large_image_path = 'images/backend_images/products/large/'.$filename;
                        $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                        $small_image_path = 'images/backend_images/products/small/'.$filename;
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
                return redirect('/admin/add-images/'.$id)->with('flash_message_success', 'Успешно добавихте снимките на продукта!');
            }
        }

        return view('admin.products.add_images')->with(['product'=>$product]);
    }

    public function deleteProductImages(Request $request, $id=null){
        if (!empty($id)){
            $product_image = ProductsImage::where(['id'=>$id])->first()->image;
            if (File::exists('images/backend_images/products/small/'.$product_image)){
                File::delete('images/backend_images/products/small/'.$product_image);
            }
            if (File::exists('images/backend_images/products/medium/'.$product_image)){
                File::delete('images/backend_images/products/medium/'.$product_image);
            }
            if (File::exists('images/backend_images/products/large/'.$product_image)){
                File::delete('images/backend_images/products/large/'.$product_image);
            }
            ProductsImage::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success', 'Успешно изтрихте снимката на продукта!');
        }
    }

    public function frontViewProducts(){
        // Filter products result
        $products = new Product;
        $paginate = 8;
        $queries = [];
        // Get max price
        $max_price_filter = $products->max('price');

        // Get requests
        $holiday_id = [];
        $category_id = [];
        $first_color = 'white';
        $second_color = 'white';
        $age = 'any';
        $pol = 'any';
        $condition = 'new';
        $send_id = '0';
        $send_free = 0;
        $object = 0;
        $personalize = 0;
        $min_price = 0;
        $max_price = 0;

        // Get holiday requests
        if (!empty(request('holiday_id'))){
            // Get root holiday and parent holidays
            $holiday_id = request('holiday_id');
            foreach (request('holiday_id') as $item) {
                $holidays_parent = Holiday::where(['parent_id'=>$item])->get();
                $holidays_in[] = $item;
                foreach ($holidays_parent as $holiday_parent) {
                    $holidays_in[] = $holiday_parent->id;
                }
            }
            // filter products
            $products = $products->whereIn('holiday_id', $holidays_in);
            // save queries
            $queries['holiday_id'] = request('holiday_id');
        }

        // Get category requests
        if (!empty(request('category_id'))){
            // Get root category and parent categories
            $category_id = request('category_id');
            foreach (request('category_id') as $item) {
                $categories_parent = Category::where(['parent_id'=>$item])->get();
                $categories_in[] = $item;
                foreach ($categories_parent as $category_parent) {
                    $categories_in[] = $category_parent->id;
                }
            }
            // filter products
            $products = $products->whereIn('category_id', $categories_in);
            // save queries
            $queries['category_id'] = request('category_id');
        }

        // Get first_color requests
        if (!empty(request('first_color'))){
            if (request('first_color') != '0'){
                // Get first_color request var
                $first_color = request('first_color');
                // filter products
                $products = $products->where('first_color', 'like', $first_color);
                // save queries
                $queries['first_color'] = request('first_color');
            }
        }

        // Get second_color requests
        if (!empty(request('second_color'))){
            if (request('second_color') != '0'){
                // Get second_color request var
                $second_color = request('second_color');
                // filter products
                $products = $products->where('second_color', 'like', $second_color);
                // save queries
                $queries['second_color'] = request('second_color');
            }
        }

        // Get age requests
        if (!empty(request('age'))){
            if (request('age') != '0'){
                // Get age request var
                $age = request('age');
                // filter products
                $products = $products->where('age', 'like', $age);
                // save queries
                $queries['age'] = request('age');
            }
        }

        // Get pol requests
        if (!empty(request('pol'))){
            if (request('pol') != '0'){
                // Get pol request var
                $pol = request('pol');
                // filter products
                $products = $products->where('pol', 'like', $pol);
                // save queries
                $queries['pol'] = request('pol');
            }
        }

        // Get condition requests
        if (!empty(request('condition'))){
            if (request('condition') != '0'){
                // Get condition request var
                $condition = request('condition');
                // filter products
                $products = $products->where('condition', 'like', $condition);
                // save queries
                $queries['condition'] = request('condition');
            }
        }

        // Get send_id requests
        if (!empty(request('send_id'))){
            if (request('send_id') != '0'){
                // Get send_id request var
                $send_id = request('send_id');
                // filter products
                $products = $products->where('send_id', $send_id);
                // save queries
                $queries['send_id'] = request('send_id');
            }
        }

        // Get send_free requests
        if (!empty(request('send_free'))){
            if (request('send_free') != 0){
                // Get send_free request var
                $send_free = request('send_free');
                // filter products
                $products = $products->where('send_free', $send_free);
                // save queries
                $queries['send_free'] = request('send_free');
            }
        }

        // Get object requests
        if (!empty(request('object'))){
            if (request('object') != 0){
                // Get object request var
                $object = request('object');
                // filter products
                $products = $products->where('object', $object);
                // save queries
                $queries['object'] = request('object');
            }
        }

        // Get personalize requests
        if (!empty(request('personalize'))){
            if (request('personalize') != 0){
                // Get personalize request var
                $personalize = request('personalize');
                // filter products
                $products = $products->where('personalize', $personalize);
                // save queries
                $queries['personalize'] = request('personalize');
            }
        }

        // Get min_price requests
        if (!empty(request('min_price'))){
            if (request('min_price') != 0){
                // Get min_price request var
                $min_price = request('min_price');
                // filter products
                $products = $products->where('price', '>=', $min_price);
                // save queries
                $queries['min_price'] = request('min_price');
            }
        }

        // Get max_price requests
        if (!empty(request('max_price'))){
            if (request('max_price') != 0){
                // Get max_price request var
                $max_price = request('max_price');
                // filter products
                $products = $products->where('price', '<=', $max_price);
                // save queries
                $queries['max_price'] = request('max_price');
            }
        }

        // Sorting products
        if (request()->has('order_by')){
            if (request('order_by') == 'product_name_asc'){
                $products = $products->orderBy('product_name', 'asc');
                $queries['order_by'] = request('order_by');
            }
            if (request('order_by') == 'product_name_desc'){
                $products = $products->orderBy('product_name', 'desc');
                $queries['order_by'] = request('order_by');
            }
            if (request('order_by') == 'price_asc'){
                $products = $products->orderBy('price', 'asc');
                $queries['order_by'] = request('order_by');
            }
            if (request('order_by') == 'price_desc'){
                $products = $products->orderBy('price', 'desc');
                $queries['order_by'] = request('order_by');
            }
        }

        // result products paginating
        $all_products_count = $products->count();
        $products = $products->paginate($paginate)->appends($queries);

        // Add holidays
        $holidays = Holiday::where(['parent_id'=>0])->get();
        // Add property
        $property = LandingPage::first();
        // Add category
        $categories = Category::where(['parent_id'=>0])->get();
        // Add speditors
        $speditors = Speditor::all();

        return view('/front/view_products')->with([
            'holidays'=>$holidays,
            'property'=>$property,
            'categories'=>$categories,
            'products'=>$products,
            'all_products_count'=>$all_products_count,
            'paginate'=>$paginate,
            'speditors'=>$speditors,
            'max_price_filter'=>$max_price_filter
        ]);
    }

    public function frontGetProduct(Request $request, $id=null){
        $product = Product::where(['id'=>$id])->first();
        $holidays_count = Holiday::where(['parent_id'=>0])->count();
        if ($holidays_count >= 5){
            $holidays_count = 5;
        }
        $holidays = Holiday::where(['parent_id'=>0])->take($holidays_count)->get();
        $property = LandingPage::first();

        return view('/front/get_product')->with([
            'product'=>$product,
            'holidays'=>$holidays,
            'property'=>$property
        ]);
    }

    public static function getCreatedAtAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i:s');
    }

    public static function getUpdatedAtAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i:s');
    }

    public static function frontGetProductByUser($user_id){
        $products_by_user_count = Product::where(['user_id'=>$user_id])->count();
        if ($products_by_user_count >= 5){
            $products_by_user_count = 5;
        }
        $products_by_user = Product::where(['user_id'=>$user_id])->take($products_by_user_count)->get();

        return $products_by_user;
    }

}
