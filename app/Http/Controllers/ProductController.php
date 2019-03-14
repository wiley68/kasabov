<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Product;
use App\User;
use App\Category;

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
            $product_name = $request->input('product_name');
            $product_code = $request->input('product_code');
            $product_color = $request->input('product_color');
            $description = $request->input('description');
            $price = $request->input('price');
            $product = new Product();
            $product->user_id = $user_id;
            $product->category_id = $category_id;
            $product->product_name = $product_name;
            $product->product_code = $product_code;
            $product->product_color = $product_color;
            $product->description = $description;
            $product->price = $price;
            //upload image
            if ($request->hasFile('image')){
                $image_temp = Input::file('image');
                if ($image_temp->isValid()){
                    // Resize images

                }
            }
            $product->save();
            return redirect('/admin/view-products')->with('flash_message_success', 'Успешно създадохте нов продукт!');
        }
        $categories = Category::where(['parent_id'=>0])->get();
        $users = User::where(['admin'=>0])->get();
        return view('admin.products.add_product')->with([
            'categories'=>$categories,
            'users'=>$users
            ]);
    }

    public function editProduct(Request $request, $id=null){
        $product = Product::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            $product->user_id = $request->input('user_id');
            $product->category_id = $request->input('category_id');
            $product->product_name = $request->input('product_name');
            $product->product_code = $request->input('product_code');
            $product->product_color = $request->input('product_color');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->image = $request->input('image');
            $product->save();
            return redirect('/admin/view-products')->with('flash_message_success', 'Успешно редактирахте продукта!');
        }
        $categories = Category::where(['parent_id'=>0])->get();
        $users = User::where(['admin'=>1])->get();
        return view('admin.products.edit_product')->with([
            'product'=>$product,
            'categories'=>$categories,
            'users'=>$users
            ]);
    }

    public function deleteProduct(Request $request, $id=null){
        if (!empty($id)){
            $product = Product::where(['id'=>$id])->first();
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

}
