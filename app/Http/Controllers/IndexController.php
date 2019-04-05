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
        $latest_count = Product::where(['featured'=>1])->count();
        if ($latest_count >= 6){
            $latest_count = 6;
        }
        $latest = Product::where(['featured'=>1])->get()->take($latest_count);
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
            'latest'=>$latest,
            'property'=>$property,
            'featured_products'=>$featured_products
        ]);
    }

    public function editLandingPage(Request $request){
        $property = LandingPage::first();
        if ($request->isMethod('post')){
            $property->category_title = $request->input('category_title');
            $property->best_title = $request->input('best_title');
            $property->best_subtitle = $request->input('best_subtitle');
            $property->featured_title = $request->input('featured_title');
            $property->featured_subtitle = $request->input('featured_subtitle');
            $property->works_title = $request->input('works_title');
            $property->works_subtitle = $request->input('works_subtitle');
            $property->create_account = $request->input('create_account');
            $property->post_add = $request->input('post_add');
            $property->deal_done = $request->input('deal_done');
            $property->key_title = $request->input('key_title');
            $property->key_subtitle = $request->input('key_subtitle');
            $property->key_title1 = $request->input('key_title1');
            $property->key_description1 = $request->input('key_description1');
            $property->key_icon1 = $request->input('key_icon1');
            $property->key_title2 = $request->input('key_title2');
            $property->key_description2 = $request->input('key_description2');
            $property->key_icon2 = $request->input('key_icon2');
            $property->key_title3 = $request->input('key_title3');
            $property->key_description3 = $request->input('key_description3');
            $property->key_icon3 = $request->input('key_icon3');
            $property->key_title4 = $request->input('key_title4');
            $property->key_description4 = $request->input('key_description4');
            $property->key_icon4 = $request->input('key_icon4');
            $property->key_title5 = $request->input('key_title5');
            $property->key_description5 = $request->input('key_description5');
            $property->key_icon5 = $request->input('key_icon5');
            $property->key_title6 = $request->input('key_title6');
            $property->key_description6 = $request->input('key_description6');
            $property->key_icon6 = $request->input('key_icon6');
            $property->testimonials_description1 = $request->input('testimonials_description1');
            $property->testimonials_name1 = $request->input('testimonials_name1');
            $property->testimonials_title1 = $request->input('testimonials_title1');
            $property->testimonials_description2 = $request->input('testimonials_description2');
            $property->testimonials_name2 = $request->input('testimonials_name2');
            $property->testimonials_title2 = $request->input('testimonials_title2');
            $property->testimonials_description3 = $request->input('testimonials_description3');
            $property->testimonials_name3 = $request->input('testimonials_name3');
            $property->testimonials_title3 = $request->input('testimonials_title3');
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
