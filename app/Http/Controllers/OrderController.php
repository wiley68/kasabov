<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Product;
use App\Holiday;
use App\LandingPage;
use App\User;
use Mail;
use Config;

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
            // Send mail to targovec and user
            // Klient
            $user_name = User::where(['id'=>$user_id])->first()->name;
            $user_email = $order->email;
            // Targovec
            $targovec_name = User::where(['id'=>$product->user_id])->first()->name;
            $targovec_email = User::where(['id'=>$product->user_id])->first()->email;
            $data = array(
                'order_id' => $order->id,
                'targovec_name' => $targovec_name,
                'product_name' => $product->product_name,
                'order_message' => $order->message,
                'user_name' => $user_name,
                'order_email' => $order->email,
                'order_phone' => $order->phone,
                'order_created_at' => date("d.m.Y H:i:s", strtotime($order->created_at))
            );

            Mail::send('mail', $data, function ($message) use ($targovec_email, $targovec_name){
                $message->to($targovec_email, $targovec_name)->subject('Изпратена заявка към купувач от PartyBox');
                $message->from(Config::get('settings.mail'), 'PartyBox');
            });
            Mail::send('mail_user', $data, function ($message) use ($user_email, $user_name){
                $message->to($user_email, $user_name)->subject('Изпратена заявка от клиент на PartyBox');
                $message->from(Config::get('settings.mail'), 'PartyBox');
            });

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

    public function viewOrders(){
        $orders = Order::all();
        return view('admin.orders.view_orders')->with(['orders'=>$orders]);
    }

    public function editOrder(Request $request, $id=null){
        $order = Order::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            if(!empty($request->input('email'))){
                $order->email = $request->input('email');
            }else{
                $order->email = '';
            }
            if(!empty($request->input('phone'))){
                $order->phone = $request->input('phone');
            }else{
                $order->phone = '';
            }
            if(!empty($request->input('message'))){
                $order->message = $request->input('message');
            }else{
                $order->message = '';
            }
            $order->save();
            return redirect('/admin/edit-order/'.$id)->with('flash_message_success', 'Успешно редактирахте заявката!');
        }
        return view('admin.orders.edit_order')->with([
            'order'=>$order
            ]);
    }

    public function deleteAdminOrder(Request $request, $id=null){
        if (!empty($id)){
            $order = Order::where(['id'=>$id])->first();
            // Delete order
            $order->delete();
        }
        return redirect('/admin/view-orders');
    }

}
