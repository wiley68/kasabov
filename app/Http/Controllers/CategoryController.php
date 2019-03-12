<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function addCategory(Request $request){
        if ($request->isMethod('post')){
            $category_name = $request->input('category_name');
            $category_description = $request->input('category_description');
            $category_url = $request->input('category_url');
            $category = new Category();
            $category->name = $category_name;
            $category->description = $category_description;
            $category->url = $category_url;
            $category->save();
            return redirect('/admin/view-categories')->with('flash_message_success', 'Успешно създадохте нова категория!');
        }

        return view('admin.categories.add_category');
    }

    public function editCategory(Request $request, $id=null){
        $category = Category::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            $category->name = $request->input('category_name');
            $category->description = $request->input('category_description');
            $category->url = $request->input('category_url');
            $category->save();
            return redirect('/admin/view-categories')->with('flash_message_success', 'Успешно редактирахте категорията!');
        }
        return view('admin.categories.edit_category')->with(['category'=>$category]);
    }

    public function deleteCategory(Request $request, $id=null){
        if (!empty($id)){
            $category = Category::where(['id'=>$id])->first();
            $category->delete();
            return redirect('/admin/view-categories')->with('flash_message_success', 'Успешно изтрихте категорията!');
        }
    }

    public function viewCategory(){
        $categories = Category::all();
        return view('admin.categories.view_categories')->with(['categories'=>$categories]);
    }
}
