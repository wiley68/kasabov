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
use App\Order;
use App\Tag;
use App\ProductsTags;
use App\Speditor;
use App\City;
use App\Holiday;
use App\LandingPage;
use Carbon\Carbon;
use App\ProductsCity;
use App\Favorite;
use Auth;
use App\Payment;
use App\ProductsCitySend;
use App\Reklama;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        if ($request->isMethod('post')) {
            $user_id = $request->input('user_id');
            if ($user_id === "0") {
                return redirect('/admin/add-product')->with('flash_message_error', 'Необходимо е да изберете собственик на продукта!');
            }
            $category_id = $request->input('category_id');
            if ($category_id === "0") {
                return redirect('/admin/add-product')->with('flash_message_error', 'Необходимо е да изберете категория за продукта!');
            }
            $holiday_id = $request->input('holiday_id');
            $product_name = $request->input('product_name');
            $product_code = $request->input('product_code');
            $age = $request->input('age');
            $send_id = $request->input('send_id');
            $send_from_id = $request->input('send_from_id');
            if (empty($request->input('price_send'))) {
                $price_send = 0.00;
            } else {
                $price_send = $request->input('price_send');
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
                    if (!empty($request->input('send_free_available_for_cities'))) {
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

            $object = $request->input('object');
            if (empty($request->input('object_name'))) {
                $object_name = '';
            } else {
                $object_name = $request->input('object_name');
            }
            $personalize = $request->input('personalize');
            $description = $request->input('description');
            $price = $request->input('price');
            if (empty($request->input('likes'))) {
                $likes = 0;
            } else {
                $likes = $request->input('likes');
            }
            $top = $request->input('top');
            if (empty($request->input('views'))) {
                $views = 0;
            } else {
                $views = $request->input('views');
            }
            // Create product column
            $product = new Product();
            $product->user_id = $user_id;
            $product->category_id = $category_id;
            $product->holiday_id = $holiday_id;
            $product->product_name = $product_name;
            $product->product_code = $product_code;
            $product->age = $age;
            $product->send_id = $send_id;
            $product->send_from_id = $send_from_id;
            $product->price_send = $price_send;
            $product->send_free = $send_free;
            $product->send_free_id = $send_free_id;
            $product->send_free_available_for = $send_free_available_for;
            $product->object = $object;
            $product->object_name = $object_name;
            $product->personalize = $personalize;
            $product->description = $description;
            if (empty($description)) {
                $product->description = '';
            }
            $product->price = $price;

            // check featured
            $new_featured = $request->input('featured');
            if ($new_featured == 1) {
                // test for available featured
                $products_count_f = Product::where(['user_id' => $user_id, 'featured' => 1])->count();
                // check active payments
                $active_payments_1 = Payment::where(['user_id' => $user_id, 'status' => 'active', 'forthe' => 'reklama1'])->where('active_at', '>=', date("Y-m-d", strtotime("-5 days")))->count();
                $active_payments_2 = Payment::where(['user_id' => $user_id, 'status' => 'active', 'forthe' => 'reklama3'])->where('active_at', '>=', date("Y-m-d", strtotime("-10 days")))->count();
                $active_products_f = intval($active_payments_1) * 1 + intval($active_payments_2) * 3;
                if ($products_count_f >= $active_products_f) {
                    return redirect('/admin/add-product')->with('flash_message_error', 'Вече имате ' . $active_products_f . ' броя промоционални реклами! Моля ако желаете да увеличите бройката им, закупете си допълнителен пакет.');
                } else {
                    $product->featured = $request->input('featured');
                }
            } else {
                $product->featured = $request->input('featured');
            }

            $product->likes = $likes;
            $product->top = $top;
            $product->views = $views;

            // check statuses
            $new_status = $request->input('status');
            if ($new_status == 'active') {
                // test for available items
                $products_count = Product::where(['user_id' => $user_id, 'status' => 'active'])->count();
                // check active payments
                $active_payments = Payment::where(['user_id' => $user_id, 'status' => 'active', 'forthe' => 'standart'])->where('active_at', '>=', date("Y-m-d", strtotime("-2 months")))->count();
                $active_products = intval($active_payments) * 20 + 10;
                if ($products_count >= $active_products) {
                    return redirect('/admin/add-product')->with('flash_message_error', 'Вече имате ' . $active_products . ' броя активни реклами! Моля ако желаете да увеличите бройката им, закупете си допълнителен пакет.');
                } else {
                    $product->status = $request->input('status');
                }
            } else {
                $product->status = $request->input('status');
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
                    // Store image names in table
                    $product->image = $filename;
                }
            } else {
                $product->image = '';
            }
            $product->active_at = date('Y-m-d H:i:s');
            $product->save();
            // Add city to cities table
            if (!empty($available_cities)) {
                foreach ($available_cities as $available_city) {
                    $new_city = new ProductsCity();
                    $new_city->product_id = $product->id;
                    $new_city->city_id = $available_city;
                    $new_city->save();
                }
            }
            if (!empty($send_free_available_cities)) {
                foreach ($send_free_available_cities as $available_city) {
                    $new_city = new ProductsCitySend();
                    $new_city->product_id = $product->id;
                    $new_city->city_id = $available_city;
                    $new_city->save();
                }
            }
            // Add tags to tags table
            // Delete oll tags
            if (!empty($request->tags)) {
                foreach ($request->tags as $tag) {
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
            return redirect('/admin/view-products')->with('flash_message_success', 'Успешно създадохте нов продукт!');
        }
        $categories = Category::where(['parent_id' => 0])->get();
        $users = User::where('admin', '!=', 1)->get();
        $speditors = Speditor::all();
        $cities = City::all();
        $holidays = Holiday::where(['parent_id' => 0])->get();
        return view('admin.products.add_product')->with([
            'categories' => $categories,
            'users' => $users,
            'speditors' => $speditors,
            'cities' => $cities,
            'holidays' => $holidays
        ]);
    }

    public function editProduct(Request $request, $id = null)
    {
        $product = Product::where(['id' => $id])->first();
        if ($request->isMethod('post')) {
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
            $product->user_id = $request->input('user_id');
            $product->category_id = $request->input('category_id');
            $product->holiday_id = $request->input('holiday_id');
            $product->product_name = $request->input('product_name');
            $product->product_code = $request->input('product_code');
            $product->age = $request->input('age');
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
                    if (!empty($request->input('send_free_available_for_cities'))) {
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

            $product->object = $request->input('object');
            if (empty($request->input('object_name'))) {
                $product->object_name = '';
            } else {
                $product->object_name = $request->input('object_name');
            }
            $product->personalize = $request->input('personalize');
            $product->description = $request->input('description');
            if (empty($product->description)) {
                $product->description = '';
            }
            $product->price = $request->input('price');
            $product->image = $filename;

            // check featured
            $old_featured = $product->featured;
            $new_featured = $request->input('featured');
            if ($new_featured == 1) {
                if ($old_featured != 1) {
                    // test for available featured
                    $products_count_f = Product::where(['user_id' => $request->input('user_id'), 'featured' => 1])->count();
                    // check active payments
                    $active_payments_1 = Payment::where(['user_id' => $request->input('user_id'), 'status' => 'active', 'forthe' => 'reklama1'])->where('active_at', '>=', date("Y-m-d", strtotime("-5 days")))->count();
                    $active_payments_2 = Payment::where(['user_id' => $request->input('user_id'), 'status' => 'active', 'forthe' => 'reklama3'])->where('active_at', '>=', date("Y-m-d", strtotime("-10 days")))->count();
                    $active_products_f = intval($active_payments_1) * 1 + intval($active_payments_2) * 3;
                    if ($products_count_f >= $active_products_f) {
                        return redirect('/admin/edit-product/' . $product->id)->with('flash_message_error', 'Вече имате ' . $active_products_f . ' броя промоционални реклами! Моля ако желаете да увеличите бройката им, закупете си допълнителен пакет.');
                    } else {
                        $product->featured = $request->input('featured');
                    }
                }
            } else {
                $product->featured = $request->input('featured');
            }

            if (empty($request->input('likes'))) {
                $product->likes = 0;
            } else {
                $product->likes = $request->input('likes');
            }
            $product->top = $request->input('top');
            if (empty($request->input('views'))) {
                $product->views = 0;
            } else {
                $product->views = $request->input('views');
            }
            // check statuses
            $old_status = $product->status;
            $new_status = $request->input('status');
            if ($new_status == 'active') {
                if ($old_status != 'active') {
                    // test for available items
                    $products_count = Product::where(['user_id' => $product->user_id, 'status' => 'active'])->count();
                    // check active payments
                    $active_payments = Payment::where(['user_id' => $product->user_id, 'status' => 'active', 'forthe' => 'standart'])->where('active_at', '>=', date("Y-m-d", strtotime("-2 months")))->count();
                    $active_products = intval($active_payments) * 20 + 10;
                    if ($products_count >= $active_products) {
                        return redirect('/admin/edit-product/' . $product->id)->with('flash_message_error', 'Вече имате ' . $active_products . ' броя активни реклами! Моля ако желаете да увеличите бройката им, закупете си допълнителен пакет.');
                    } else {
                        $product->status = $request->input('status');
                        $product->active_at = date('Y-m-d H:i:s');
                    }
                }
            } else {
                $product->status = $request->input('status');
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
            $products_cities_send_count = ProductsCitySend::where(['product_id' => $product->id])->count();
            if ($products_cities_send_count > 0) {
                ProductsCitySend::where(['product_id' => $product->id])->delete();
            }
            // Add new cities send
            if (!empty($send_free_available_cities)) {
                foreach ($send_free_available_cities as $available_city) {
                    $new_city = new ProductsCitySend();
                    $new_city->product_id = $product->id;
                    $new_city->city_id = $available_city;
                    $new_city->save();
                }
            }

            return redirect('/admin/edit-product/' . $product->id)->with('flash_message_success', 'Успешно редактирахте продукта!');
        }
        $categories = Category::where(['parent_id' => 0])->get();
        $users = User::where('admin', '!=', 1)->get();
        $tags = ProductsTags::where(['product_id' => $product->id])->get();
        $speditors = Speditor::all();
        $cities = City::all();
        $holidays = Holiday::where(['parent_id' => 0])->get();
        return view('admin.products.edit_product')->with([
            'product' => $product,
            'categories' => $categories,
            'users' => $users,
            'tags' => $tags,
            'speditors' => $speditors,
            'cities' => $cities,
            'holidays' => $holidays
        ]);
    }

    public function checkProduct(Request $request)
    {
        // Check if product code exist
        $product = Product::where(['product_code' => $request->input('product_code')])->first();
        if (empty($product) || $product->id == $request->input('id')) {
            return "true";
            die;
        } else {
            return "false";
        }
    }

    public function deleteProduct(Request $request, $id = null)
    {
        if (!empty($id)) {
            $product = Product::where(['id' => $id])->first();

            if (Order::where(['product_id' => $product->id])->first()) {
                return redirect('/admin/view-products')->with('flash_message_error', 'Продуктът не може да бъде изтрит, тъй като имате заявки за него!');
            } else {
                // Delete image
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
                // Delete images
                $productsImage = ProductsImage::where(['product_id' => $id])->get();
                foreach ($productsImage as $image) {
                    if (File::exists('images/backend_images/products/small/' . $image->image)) {
                        File::delete('images/backend_images/products/small/' . $image->image);
                    }
                    if (File::exists('images/backend_images/products/medium/' . $image->image)) {
                        File::delete('images/backend_images/products/medium/' . $image->image);
                    }
                    if (File::exists('images/backend_images/products/large/' . $image->image)) {
                        File::delete('images/backend_images/products/large/' . $image->image);
                    }
                    $image->delete();
                }
                // Delete products_cities
                $productsCities = ProductsCity::where(['product_id' => $id])->get();
                foreach ($productsCities as $product_city) {
                    $product_city->delete();
                }
                $productsCitiesSend = ProductsCitySend::where(['product_id' => $id])->get();
                foreach ($productsCitiesSend as $product_city) {
                    $product_city->delete();
                }
                // Delete product
                $product->delete();
                return redirect('/admin/view-products')->with('flash_message_success', 'Успешно изтрихте продукта!');
            }
        }
    }

    public function viewProducts()
    {
        $products = Product::all();
        return view('admin.products.view_products')->with(['products' => $products]);
    }

    public static function getProductById($id = null)
    {
        if (!empty($id)) {
            $product = Product::where(['id' => $id])->first();
            return $product;
        }
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
            return redirect('/admin/edit-product/' . $id)->with('flash_message_success', 'Успешно изтрихте снимката на продукта!');
        }
    }

    public function addImages(Request $request, $id = null)
    {
        $product = Product::with('images')->where(['id' => $id])->first();

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
                return redirect('/admin/add-images/' . $id)->with('flash_message_success', 'Успешно добавихте снимките на продукта!');
            }
        }

        return view('admin.products.add_images')->with(['product' => $product]);
    }

    public function deleteProductImages(Request $request, $id = null)
    {
        if (!empty($id)) {
            $product_image = ProductsImage::where(['id' => $id])->first()->image;
            if (File::exists('images/backend_images/products/small/' . $product_image)) {
                File::delete('images/backend_images/products/small/' . $product_image);
            }
            if (File::exists('images/backend_images/products/medium/' . $product_image)) {
                File::delete('images/backend_images/products/medium/' . $product_image);
            }
            if (File::exists('images/backend_images/products/large/' . $product_image)) {
                File::delete('images/backend_images/products/large/' . $product_image);
            }
            ProductsImage::where(['id' => $id])->delete();
            return redirect()->back()->with('flash_message_success', 'Успешно изтрихте снимката на продукта!');
        }
    }

    public function frontViewProducts()
    {
        // Filter products result
        $products = Product::where(['status' => 'active']);
        $products = $products->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")));
        $paginate = 9;
        $queries = [];
        // Get max price
        $max_price_filter = $products->max('price');

        // Get requests
        $age = 'any';
        $send_id = '0';
        $send_free = 0;
        $object = 0;
        $personalize = 0;
        $min_price = 0;
        $max_price = 0;
        $turgovetsName = "";
        $turgovetsCityName = "Не е отбелязано";
        $turgovetsDate = "";
        $numberOfOrders = 0;

        // Get tag requests
        if (!empty(request('tag'))) {
            // Get products_tags
            $products_tags = ProductsTags::where(['tag_id' => request('tag')])->get();
            foreach ($products_tags as $product_tag) {
                $products_id_in[] = $product_tag->product_id;
            }
            // filter products
            $products = $products->whereIn('id', $products_id_in);
            // save queries
            $queries['tag'] = request('tag');
        }

        // Get holiday requests
        if (!empty(request('holiday_id'))) {
            // Get root holiday and parent holidays
            foreach (request('holiday_id') as $item) {
                $holidays_parent = Holiday::where(['parent_id' => $item])->get();
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
        if (!empty(request('category_id'))) {
            // Get root category and parent categories
            foreach (request('category_id') as $item) {
                $categories_parent = Category::where(['parent_id' => $item])->get();
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

        // Get city requests
        if (!empty(request('city_id'))) {
            // filter products
            foreach (request('city_id') as $item) {
                $oblasten = City::where(['id' => $item])->first();
                $oblast_cities = City::where('oblast', 'like', $oblasten->city)->get();
                $cities_in[] = $item;
                foreach ($oblast_cities as $oblast_city) {
                    $cities_in[] = $oblast_city->id;
                }
            }
            $products = $products->whereIn('send_from_id', $cities_in);
            // save queries
            $queries['city_id'] = request('city_id');
        }
        // Get search requests
        if (!empty(request('custom_search')) && request('custom_search') != '') {

            // filter products
            $products = $products->where('product_name', 'like', '%' . request('custom_search') . '%');
            // save queries
            $queries['custom_search'] = request('custom_search');
        }

        // Get age requests
        if (!empty(request('age'))) {
            if (request('age') != '0') {
                // Get age request var
                $age = request('age');
                // filter products
                $products = $products->where('age', 'like', $age);
                // save queries
                $queries['age'] = request('age');
            }
        }

        // Get send_id requests
        if (!empty(request('send_id'))) {
            if (request('send_id') != '0') {
                // Get send_id request var
                $send_id = request('send_id');
                // filter products
                $products = $products->where('send_id', $send_id);
                // save queries
                $queries['send_id'] = request('send_id');
            }
        }

        // Get send_free requests
        if (!empty(request('send_free'))) {
            if (request('send_free') != 0) {
                // Get send_free request var
                $send_free = request('send_free');
                // filter products
                $products = $products->where('send_free', $send_free);
                // save queries
                $queries['send_free'] = request('send_free');
            }
        }

        // Get object requests
        if (!empty(request('object'))) {
            if (request('object') != 0) {
                // Get object request var
                $object = request('object');
                // filter products
                $products = $products->where('object', $object);
                // save queries
                $queries['object'] = request('object');
            }
        }

        // Get personalize requests
        if (!empty(request('personalize'))) {
            if (request('personalize') != 0) {
                // Get personalize request var
                $personalize = request('personalize');
                // filter products
                $products = $products->where('personalize', $personalize);
                // save queries
                $queries['personalize'] = request('personalize');
            }
        }

        // Get min_price requests
        if (!empty(request('min_price'))) {
            if (request('min_price') != 0) {
                // Get min_price request var
                $min_price = request('min_price');
                // filter products
                $products = $products->where('price', '>=', $min_price);
                // save queries
                $queries['min_price'] = request('min_price');
            }
        }

        // Get max_price requests
        if (!empty(request('max_price'))) {
            if (request('max_price') != 0) {
                // Get max_price request var
                $max_price = request('max_price');
                // filter products
                $products = $products->where('price', '<=', $max_price);
                // save queries
                $queries['max_price'] = request('max_price');
            }
        }

        // Get user_id requests
        if (!empty(request('user_id'))) {
            if (request('user_id') != 0) {
                // Get user_id request var
                $user_id = request('user_id');
                // filter products
                $products = $products->where('user_id', $user_id);
                // save queries
                $queries['user_id'] = request('user_id');
                // user details
                $turgovets = User::where(['id' => $user_id])->first();
                $turgovetsName = $turgovets->name;
                $turgovetsCityId = $turgovets->city_id;
                if ($turgovetsCityId != null) {
                    $turgovetsCityName = City::where(['id' => $turgovetsCityId])->first()->city;
                }
                $turgovetsDate = $turgovets->created_at->format('d.m.Y');
                $productsByUser = Product::where(['user_id' => $user_id])->get();

                foreach ($productsByUser as $productByUser) {
                    $OrdersOfProduct = Order::where(['product_id' => $productByUser->id])->count();
                    $numberOfOrders = $numberOfOrders + $OrdersOfProduct;
                }
            }
        }

        // Get personalize requests
        if (!empty(request('personalize'))) {
            if (request('personalize') != 0) {
                // Get personalize request var
                $personalize = request('personalize');
                // filter products
                $products = $products->where('personalize', $personalize);
                // save queries
                $queries['personalize'] = request('personalize');
            }
        }

        // Sorting products
        if (request()->has('order_by')) {
            if (request('order_by') == 'product_name_asc') {
                $products = $products->orderBy('product_name', 'asc');
                $queries['order_by'] = request('order_by');
            }
            if (request('order_by') == 'product_name_desc') {
                $products = $products->orderBy('product_name', 'desc');
                $queries['order_by'] = request('order_by');
            }
            if (request('order_by') == 'price_asc') {
                $products = $products->orderBy('price', 'asc');
                $queries['order_by'] = request('order_by');
            }
            if (request('order_by') == 'price_desc') {
                $products = $products->orderBy('price', 'desc');
                $queries['order_by'] = request('order_by');
            }
        }

        // result products paginating
        $all_products_count = $products->count();
        $products = $products->paginate($paginate)->appends($queries);

        // Add holidays
        $holidays = Holiday::where(['parent_id' => 0])->get();
        // Add property
        $property = LandingPage::first();
        // Add category
        $categories = Category::where(['parent_id' => 0])->get();
        // Add speditors
        $speditors = Speditor::all();

        // Add featured products
        $random_count = Product::where(['status' => 'active', 'featured' => 1])->count();
        if ($random_count > 3) {
            $random_count = 3;
        }
        $featureds = Product::where(['status' => 'active', 'featured' => 1])->get()->random($random_count);

        $reklama_count = Reklama::where(['status' => 1])->count();
        if ($reklama_count > 1) {
            $reklama_count = 1;
        }
        $reklami_large = Reklama::where([['status', '=', '1'], ['image_large', '!=', '']])->get();

        if (sizeof($reklami_large) != 0) {
            $reklami_large = $reklami_large->random($reklama_count);
        }

        return view('/front/view_products')->with([
            'holidays' => $holidays,
            'property' => $property,
            'categories' => $categories,
            'products' => $products,
            'all_products_count' => $all_products_count,
            'paginate' => $paginate,
            'speditors' => $speditors,
            'max_price_filter' => $max_price_filter,
            'turgovetsName' => $turgovetsName,
            'turgovetsCityName' => $turgovetsCityName,
            'turgovetsDate' => $turgovetsDate,
            'numberOfOrders' => $numberOfOrders,
            'featureds' => $featureds,
            'reklami' => $reklami_large
        ]);
    }

    public function frontGetProduct(Request $request, $id = null)
    {
        $product = Product::where(['product_code' => $id])->first();
        // Save viewed count
        $count_viewed = intval($product->views) + 1;
        $product->views = $count_viewed;
        $product->save();
        $holidays_count = Holiday::where(['parent_id' => 0])->count();
        if ($holidays_count >= 5) {
            $holidays_count = 5;
        }
        $holidays = Holiday::where(['parent_id' => 0])->take($holidays_count)->get();
        $property = LandingPage::first();

        return view('/front/get_product')->with([
            'product' => $product,
            'holidays' => $holidays,
            'property' => $property
        ]);
    }

    public static function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i:s');
    }

    public static function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i:s');
    }

    public static function frontGetProductByUser($user_id)
    {
        $products_by_user_count = Product::where(['user_id' => $user_id, 'status' => 'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->count();
        if ($products_by_user_count >= 5) {
            $products_by_user_count = 5;
        }
        $products_by_user = Product::where(['user_id' => $user_id, 'status' => 'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->inRandomOrder()->take($products_by_user_count)->get();

        return $products_by_user;
    }

    public function likeProduct(Request $request)
    {
        $likes = 0;
        if ($request->method('post') && $request->input('id') != null) {
            $product = Product::where(['id' => $request->input('id')])->first();
            $product->likes = $product->likes + 1;
            $product->save();
            $likes = $product->likes;
        }
        return response()->json(['likes' => $likes]);
    }

    public function addFavoriteProduct(Request $request)
    {
        if ($request->method('post') && $request->input('product_id') != null) {
            $favorite_count = Favorite::where(['product_id' => $request->input('product_id')])->where(['user_id' => Auth::user()->id])->count();
            if ($favorite_count == 0) {
                $favorite = new Favorite;
                $favorite->user_id =  Auth::user()->id;
                $favorite->product_id =  $request->input('product_id');
                $favorite->save();
            }
        }
        return response()->json(['add_favorite' => 'yes']);
    }
}
