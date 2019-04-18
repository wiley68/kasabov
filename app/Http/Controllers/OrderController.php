<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Product;
use App\Holiday;
use App\LandingPage;
use App\User;

class OrderController extends Controller
{
    public function addOrder(Request $request){
        if ($request->isMethod('post')){
            $user_id = $request->input('user_id');
            $product_id = $request->input('product_id');
            $message = $request->input('message');
            $email = $request->input('user_email');
            $phone = $request->input('user_phone');
            // Create order column
            $order = new Order();
            $order->user_id = $user_id;
            $order->product_id = $product_id;
            $order->message = $message;
            if (empty($message)){
                $order->message = '';
            }
            $order->email = $email;
            if (empty($email)){
                $order->email = User::where(['id'=>$user_id])->first()->email;
            }
            $order->phone = $phone;
            if (empty($phone)){
                $order->phone = '';
            }
            $order->save();
            $product = Product::where(['id'=>$product_id])->first();
            $holidays_count = Holiday::where(['parent_id'=>0])->count();
            if ($holidays_count >= 5){
                $holidays_count = 5;
            }
            $holidays = Holiday::where(['parent_id'=>0])->take($holidays_count)->get();
            $property = LandingPage::first();
            return redirect('/product/'.$product->product_code)->with([
                'product'=>$product,
                'holidays'=>$holidays,
                'property'=>$property,
                'flash_message_success'=>'Успешно изпратихте заявка към собственика на продукта!'
            ]);
        }
    }

    public function deleteOrder(Request $request, $id=null){
        if (!empty($id)){
            $order = Order::where(['id'=>$id])->first();
            // Delete order
            $order->delete();
        }
        return redirect('/home-adds');
    }

    public function deleteFirmOrder(Request $request, $id=null){
        if (!empty($id)){
            $order = Order::where(['id'=>$id])->first();
            // Delete order
            $order->delete();
        }
        return redirect('/home-firm-orders');
    }

}
