<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use App\City;
use App\Category;
use App\Page;
use App\Blog;

class PagesController extends Controller
{
    public function editObshtiUslovia(Request $request){
        $page = Page::first();
        if ($request->isMethod('post')){
            $page->value_ou = $request->input('value_ou');
            $page->save();
        }
        return view('admin.pages.edit_obshti_uslovia')->with([
            'page'=>$page
        ]);
    }

    public function obshtiUslovia(){
        $holidays_count = Holiday::where(['parent_id'=>0])->count();
        if ($holidays_count >= 5){
            $holidays_count = 5;
        }
        $holidays = Holiday::where(['parent_id'=>0])->take($holidays_count)->get();
        $cities = City::whereColumn('city', 'oblast')->get();
        $categories_top_count = Category::where(['parent_id'=>0])->count();
        if ($categories_top_count >= 12){
            $categories_top_count = 12;
        }
        $categories_top = Category::where(['parent_id'=>0])->take($categories_top_count)->get();
        $page = Page::first();
        return view('obshti_uslovia')->with([
            'holidays'=>$holidays,
            'cities'=>$cities,
            'categories_top'=>$categories_top,
            'page'=>$page
        ]);
    }

    public function editPolitika(Request $request){
        $page = Page::first();
        if ($request->isMethod('post')){
            $page->value_pl = $request->input('value_pl');
            $page->save();
        }
        return view('admin.pages.edit_politika')->with([
            'page'=>$page
        ]);
    }

    public function politika(){
        $holidays_count = Holiday::where(['parent_id'=>0])->count();
        if ($holidays_count >= 5){
            $holidays_count = 5;
        }
        $holidays = Holiday::where(['parent_id'=>0])->take($holidays_count)->get();
        $cities = City::whereColumn('city', 'oblast')->get();
        $categories_top_count = Category::where(['parent_id'=>0])->count();
        if ($categories_top_count >= 12){
            $categories_top_count = 12;
        }
        $categories_top = Category::where(['parent_id'=>0])->take($categories_top_count)->get();
        $page = Page::first();
        return view('politika')->with([
            'holidays'=>$holidays,
            'cities'=>$cities,
            'categories_top'=>$categories_top,
            'page'=>$page
        ]);
    }

    public function editHelp(Request $request){
        $page = Page::first();
        if ($request->isMethod('post')){
            $page->value_hp = $request->input('value_hp');
            $page->save();
        }
        return view('admin.pages.edit_help')->with([
            'page'=>$page
        ]);
    }

    public function help(){
        $holidays_count = Holiday::where(['parent_id'=>0])->count();
        if ($holidays_count >= 5){
            $holidays_count = 5;
        }
        $holidays = Holiday::where(['parent_id'=>0])->take($holidays_count)->get();
        $cities = City::whereColumn('city', 'oblast')->get();
        $categories_top_count = Category::where(['parent_id'=>0])->count();
        if ($categories_top_count >= 12){
            $categories_top_count = 12;
        }
        $categories_top = Category::where(['parent_id'=>0])->take($categories_top_count)->get();
        $page = Page::first();
        return view('help')->with([
            'holidays'=>$holidays,
            'cities'=>$cities,
            'categories_top'=>$categories_top,
            'page'=>$page
        ]);
    }

    public function blog(){
        $holidays_count = Holiday::where(['parent_id'=>0])->count();
        if ($holidays_count >= 5){
            $holidays_count = 5;
        }
        $holidays = Holiday::where(['parent_id'=>0])->take($holidays_count)->get();
        $cities = City::whereColumn('city', 'oblast')->get();
        $categories_top_count = Category::where(['parent_id'=>0])->count();
        if ($categories_top_count >= 12){
            $categories_top_count = 12;
        }
        $categories_top = Category::where(['parent_id'=>0])->take($categories_top_count)->get();
        $paginate = 4;
        $blog = Blog::paginate($paginate);
        $all_posts_count = $blog->count();
        return view('blog')->with([
            'holidays'=>$holidays,
            'cities'=>$cities,
            'categories_top'=>$categories_top,
            'paginate'=>$paginate,
            'all_posts_count'=>$all_posts_count,
            'blog'=>$blog
        ]);
    }

    public function post($id=null){
        $holidays_count = Holiday::where(['parent_id'=>0])->count();
        if ($holidays_count >= 5){
            $holidays_count = 5;
        }
        $holidays = Holiday::where(['parent_id'=>0])->take($holidays_count)->get();
        $cities = City::whereColumn('city', 'oblast')->get();
        $categories_top_count = Category::where(['parent_id'=>0])->count();
        if ($categories_top_count >= 12){
            $categories_top_count = 12;
        }
        $categories_top = Category::where(['parent_id'=>0])->take($categories_top_count)->get();
        $post = Blog::where(['id' => $id])->first();

        return view('post')->with([
            'holidays'=>$holidays,
            'cities'=>$cities,
            'categories_top'=>$categories_top,
            'post'=>$post
        ]);
    }

}
