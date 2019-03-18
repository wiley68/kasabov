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
            $object = $request->input('object');
            $object_name = $request->input('object_name');
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
            $product->object = $request->input('object');
            $product->object_name = $request->input('object_name');
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
            // Delete oll tags
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

}
