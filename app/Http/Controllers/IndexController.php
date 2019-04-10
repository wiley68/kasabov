<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use App\City;
use App\Category;
use App\Product;
use App\LandingPage;

class IndexController extends Controller
{
    public function index(){
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
        $tops_count = Product::where(['top'=>1])->count();
        if ($tops_count >= 6){
            $tops_count = 6;
        }
        $tops = Product::where(['top'=>1])->get()->take($tops_count);
        $featured_products_count = Product::where(['featured'=>1])->count();
        if ($featured_products_count >= 6){
            $featured_products_count = 6;
        }
        $featured_products = Product::where(['featured'=>1])->get()->take($featured_products_count);
        $property = LandingPage::first();
        return view('index')->with([
            'holidays'=>$holidays,
            'cities'=>$cities,
            'categories_top'=>$categories_top,
            'tops'=>$tops,
            'property'=>$property,
            'featured_products'=>$featured_products
        ]);
    }

    public function editLandingPage(Request $request){
        $property = LandingPage::first();
        if ($request->isMethod('post')){
            $property->footer_text = $request->input('footer_text');
            $property->footer_phone1 = $request->input('footer_phone1');
            $property->footer_phone2 = $request->input('footer_phone2');
            $property->footer_mail1 = $request->input('footer_mail1');
            $property->footer_mail2 = $request->input('footer_mail2');
            $property->footer_address = $request->input('footer_address');
            $property->footer_rites = $request->input('footer_rites');
            $property->save();
        }
        return view('admin.properties.edit_landing_page')->with([
            'property'=>$property
        ]);
    }

}
