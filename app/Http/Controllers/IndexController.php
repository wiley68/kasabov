<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use App\City;
use App\Category;
use App\Product;

class IndexController extends Controller
{
    public function index(){
        $holidays_count = Holiday::where(['parent_id'=>0])->count();
        if ($holidays_count >= 5){
            $holidays_count = 5;
        }
        $holidays = Holiday::where(['parent_id'=>0])->take($holidays_count)->get();
        $cities = City::all();
        $categories = Category::all();
        $categories_top = Category::where(['parent_id'=>0])->count();
        if ($categories_top >= 12){
            $categories_top = 12;
        }
        $categories_top = Category::where(['parent_id'=>0])->take($categories_top)->get();
        $latest_count = Product::count();
        if ($latest_count >= 6){
            $latest_count = 6;
        }
        $latest = Product::all()->take($latest_count);
        return view('index')->with([
            'holidays'=>$holidays,
            'cities'=>$cities,
            'categories'=>$categories,
            'categories_top'=>$categories_top,
            'latest'=>$latest
        ]);
    }
}
