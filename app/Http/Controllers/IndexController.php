<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use App\City;
use App\Category;
use App\Product;
use App\LandingPage;
use Mail;
use Config;

class IndexController extends Controller
{
    public static function getUserIP()
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip;
    }

    public function maintenance()
    {
        return view('maintenance');
    }

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
        $tops_count = Product::where(['top'=>1, 'status'=>'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->count();
        if ($tops_count >= 6){
            $tops_count = 6;
        }
        $tops = Product::where(['top'=>1, 'status'=>'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->get()->take($tops_count);
        $featured_products_count = Product::where(['featured'=>1, 'status'=>'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->count();
        if ($featured_products_count >= 6){
            $featured_products_count = 6;
        }
        $featured_products = Product::where(['featured'=>1, 'status'=>'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->get()->take($featured_products_count);
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

    public function editPricePage(Request $request){
        $property = LandingPage::first();
        if ($request->isMethod('post')){
            $property->paket_standart = $request->input('paket_standart');
            $property->paket_reklama_1 = $request->input('paket_reklama_1');
            $property->paket_reklama_2 = $request->input('paket_reklama_2');
            $property->paket_standart = $request->input('paket_standart');
            $property->paket_reklama_1 = $request->input('paket_reklama_1');
            $property->paket_reklama_2 = $request->input('paket_reklama_2');
            $property->save();
        }
        return view('admin.properties.edit_price_page')->with([
            'property'=>$property
        ]);
    }

    public function editPaymentPackages(Request $request){
        $property = LandingPage::first();
        if ($request->isMethod('post')){
            $property->firm_name = $request->input('firm_name');
            $property->mol = $request->input('mol');
            $property->address = $request->input('address');
            $property->phone = $request->input('phone');
            $property->bank_name = $request->input('bank_name');
            $property->iban = $request->input('iban');
            $property->bic = $request->input('bic');
            $property->save();
        }
        return view('admin.properties.edit_payment_packages')->with([
            'property'=>$property
        ]);
    }

    public function editMaintenancePage(Request $request){
        $property = LandingPage::first();
        if ($request->isMethod('post')){
            $property->maintenance_status = $request->input('maintenance_status');
            $property->maintenance_ip = $request->input('maintenance_ip');
            $property->save();
        }
        return view('admin.properties.edit_maintenance_page')->with([
            'property'=>$property
        ]);
    }

    public function sms(){
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
        $property = LandingPage::first();

        return view('sms')->with([
            'holidays'=>$holidays,
            'cities'=>$cities,
            'categories_top'=>$categories_top,
            'property'=>$property
        ]);
    }

    public function sms1(){
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
        $property = LandingPage::first();

        return view('sms1')->with([
            'holidays'=>$holidays,
            'cities'=>$cities,
            'categories_top'=>$categories_top,
            'property'=>$property
        ]);
    }

    public function sms2(){
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
        $property = LandingPage::first();

        return view('sms2')->with([
            'holidays'=>$holidays,
            'cities'=>$cities,
            'categories_top'=>$categories_top,
            'property'=>$property
        ]);
    }

    public function abonament(Request $request){
        $this->validate($request, [
            'abonament_email' => 'required',
            'g-recaptcha-response' => 'required|recaptcha'
        ],
        [
            'abonament_email.required' => 'Задължително е въвеждането на вашия e-mail адрес!',
            'g-recaptcha-response.required' => 'Задължително е да преминете проверката за бот!',
            'g-recaptcha-response.recaptcha' => 'Неуспешна проверка за бот!'
        ]);

        if ($request->isMethod('post')){
            $abonament_email = $request->input('abonament_email');

            $admin_name = env("APP_NAME", "PartyBox");
            $admin_email = env("MAIL_USERNAME", "kasabov.sot@gmail.com");
            $data = array(
                'abonament_email' => $abonament_email
            );

            Mail::send('mail_abonament', $data, function ($message) use ($admin_email, $admin_name){
                $message->to($admin_email, $admin_name)->subject('Изпратена заявка за Абонамент за бюлетин');
                $message->from(Config::get('settings.mail'), 'PartyBox');
            });

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
            $tops_count = Product::where(['top'=>1, 'status'=>'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->count();
            if ($tops_count >= 6){
                $tops_count = 6;
            }
            $tops = Product::where(['top'=>1, 'status'=>'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->get()->take($tops_count);
            $featured_products_count = Product::where(['featured'=>1, 'status'=>'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->count();
            if ($featured_products_count >= 6){
                $featured_products_count = 6;
            }
            $featured_products = Product::where(['featured'=>1, 'status'=>'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->get()->take($featured_products_count);
            $property = LandingPage::first();

            return redirect('/')->with([
                'holidays'=>$holidays,
                'cities'=>$cities,
                'categories_top'=>$categories_top,
                'tops'=>$tops,
                'property'=>$property,
                'featured_products'=>$featured_products,
                'flash_message_success'=>'Успешно изпратихте абонамента си за бюлетин!'
            ]);
        }
    }

    public function contact(Request $request){
        $this->validate($request, [
            'contact_name' => 'required',
            'contact_email' => 'required',
            'contact_message' => 'required',
            'g-recaptcha-response' => 'required|recaptcha'
        ],
        [
            'contact_name.required' => 'Задължително е въвеждането на Вашето име!',
            'contact_email.required' => 'Задължително е въвеждането на вашия e-mail адрес!',
            'contact_message.required' => 'Задължително е да попълните съобщението си!',
            'g-recaptcha-response.required' => 'Задължително е да преминете проверката за бот!',
            'g-recaptcha-response.recaptcha' => 'Неуспешна проверка за бот!'
        ]);

        if ($request->isMethod('post')){
            $contact_name = $request->input('contact_name');
            $contact_email = $request->input('contact_email');
            $contact_message = $request->input('contact_message');

            $admin_name = env("APP_NAME", "PartyBox");
            $admin_email = env("MAIL_USERNAME", "kasabov.sot@gmail.com");
            $data = array(
                'contact_name' => $contact_name,
                'contact_email' => $contact_email,
                'contact_message' => $contact_message
            );

            Mail::send('mail_contact', $data, function ($message) use ($admin_email, $admin_name){
                $message->to($admin_email, $admin_name)->subject('Изпратена съобщение от клиент');
                $message->from(Config::get('settings.mail'), 'PartyBox');
            });

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
            $tops_count = Product::where(['top'=>1, 'status'=>'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->count();
            if ($tops_count >= 6){
                $tops_count = 6;
            }
            $tops = Product::where(['top'=>1, 'status'=>'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->get()->take($tops_count);
            $featured_products_count = Product::where(['featured'=>1, 'status'=>'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->count();
            if ($featured_products_count >= 6){
                $featured_products_count = 6;
            }
            $featured_products = Product::where(['featured'=>1, 'status'=>'active'])->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")))->get()->take($featured_products_count);
            $property = LandingPage::first();

            return redirect('/')->with([
                'holidays'=>$holidays,
                'cities'=>$cities,
                'categories_top'=>$categories_top,
                'tops'=>$tops,
                'property'=>$property,
                'featured_products'=>$featured_products,
                'flash_message_success'=>'Успешно изпратихте съобщението си към екипа на PartyBox!'
            ]);
        }
    }

}
