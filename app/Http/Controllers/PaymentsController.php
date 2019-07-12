<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\User;
use Auth;
use App\Holiday;
use App\LandingPage;
use Mail;
use Config;

class PaymentsController extends Controller
{
    public function viewPayments(){
        Payment::where(['status'=>'active', 'forthe'=>'standart'])->where('active_at', '<=', date("Y-m-d", strtotime("-2 months")))->update(array('status' => 'expired'));
        Payment::where(['status'=>'active', 'forthe'=>'reklama1'])->where('active_at', '<=', date("Y-m-d", strtotime("-5 days")))->update(array('status' => 'expired'));
        Payment::where(['status'=>'active', 'forthe'=>'reklama3'])->where('active_at', '<=', date("Y-m-d", strtotime("-10 days")))->update(array('status' => 'expired'));
        $payments = Payment::all();
        $property = LandingPage::first();
        return view('admin.firms.view_payments')->with([
            'payments'=>$payments,
            'property' => $property
            ]);
    }

    public function deletePayment(Request $request, $id=null){
        if (!empty($id)){
            Payment::where(['id'=>$id])->delete();
            return redirect('/admin/view-payments')->with('flash_message_success', 'Успешно изтрихте плащането!');
        }
    }

    public function deleteFrontPayment(Request $request, $id=null){
        if (!empty($id)){
            Payment::where(['id'=>$id])->delete();
            return redirect('/home-firm-payments')->with('flash_message_success', 'Успешно изтрихте плащането!');
        }
    }

    public function editPayment(Request $request, $id=null){
        $payment = Payment::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            $payment->payment = $request->input('payment_type');
            $payment->forthe = $request->input('payment_forthe');
            // check statuses
            $old_status = $payment->status;
            $new_status = $request->input('payment_status');
            if ($new_status == 'active'){
                if ($old_status != 'active'){
                    $payment->status = $request->input('payment_status');
                    $payment->active_at = date('Y-m-d H:i:s');
                }
            }else{
                $payment->status = $request->input('payment_status');
            }
            $payment->save();
            return redirect('/admin/edit-payment/'.$id)->with('flash_message_success', 'Успешно редактирахте плащането!');
        }
        return view('admin.firms.edit_payment')->with([
            'payment'=>$payment
            ]);
    }

    public function addPayment(Request $request){
        $payment = new Payment();
        $users = User::where(['admin'=>2])->get();
        if ($request->isMethod('post')){
            if ($request->input('payment_user') != 0){
                $payment->user_id = $request->input('payment_user');
                $payment->status = $request->input('payment_status');
                $payment->active_at = date('Y-m-d H:i:s');
                $payment->payment = $request->input('payment_type');
                $payment->forthe = $request->input('payment_forthe');
                $payment->save();
                return redirect('/admin/edit-payment/'.$payment->id)->with('flash_message_success', 'Успешно съаздадохте плащането!');
            }else{
                return redirect('/admin/add-payment')->with('flash_message_error', 'Трябва да изберете Търговец!');
            }
        }
        return view('admin.firms.add_payment')->with([
            'users'=>$users
            ]);
    }

    public function addFirmPayment(Request $request){
        $holidays = Holiday::where(['parent_id' => 0])->get();
        $property = LandingPage::first();
        $payment = new Payment();
        $user = User::where(['id'=>Auth::user()->id])->first();
        if ($request->isMethod('post')){
            if ($request->input('payment_user') != 0){
                $payment->user_id = $request->input('payment_user');
                $payment->status = 'pending';
                $payment->active_at = date('Y-m-d H:i:s');
                $payment->payment = $request->input('payment_type');
                $payment->forthe = $request->input('payment_forthe');
                $payment->save();
                switch ($request->input('payment_forthe')) {
                    case 'standart':
                        $payment_type = 'Стандартно (цена: ' . $property->paket_standart . 'лв. 20 продукта , действа ' . $property->paket_standart_time . ' дни)';
                        break;
                    case 'reklama1':
                        $payment_type = 'Пакет 1 промо продукт (цена: ' . $property->paket_reklama_1 . ' лв. действа ' . $property->paket_reklama_1_time . ' дни)';
                        break;
                    case 'reklama3':
                        $payment_type = 'Пакет 3 промо продукта (цена: ' . $property->paket_reklama_2 . ' лв. действа ' . $property->paket_reklama_2_time . '}} дни)';
                        break;                    
                    default:
                        $payment_type = 'Стандартно (цена: ' . $property->paket_standart . 'лв. 20 продукта , действа ' . $property->paket_standart_time . ' дни)';
                        break;                    
                }
                if ($payment->payment == 'kurier'){
                    $targovec_email = User::where(['id'=>Auth::user()->id])->first()->email;
                    $targovec_name = User::where(['id'=>Auth::user()->id])->first()->name;
                    $admin_email = Config::get('settings.mail');
                    $admin_name = $property->firm_name;

                    $txt_targovetc = '<p>' . $payment_type . '</p>';
                    $txt_targovetc .= '<p>Моля изберете си удобен за Вас куриер и използвайте следните данни за да изпратите посочената по-горе сума от Вашата заявка:</p>';
                    $txt_targovetc .= '<p>Получател фирма: ' . $property->firm_name . '</p>';
                    $txt_targovetc .= '<p>Получател: ' . $property->mol . '</p>';
                    $txt_targovetc .= '<p>Адрес: ' . $property->address . '</p>';
                    $txt_targovetc .= '<p>Телефон: ' . $property->phone . '</p>';
                    $txt_targovetc .= '<p>След получаване на средствата, пакетът който сте избрали ще бъде активиран за определения от Вас период.</p>';
                    $txt_targovetc .= '<p>Ще бъдете уведомени за това. След което ще можете да публикувате своите продукти.</p>';

                    $txt_admin = '<p>Получено е следното плащане по заявка за плащане с куриер:</p>';
                    $txt_admin .= '<p>' . $payment_type . '</p>';
                    $txt_admin .= '<p>Търговец: ' . $targovec_name . '</p>';
                    $txt_admin .= '<p>E-Mail: ' . $targovec_email . '</p>';

                    $data = array(
                        'txt_targovetc' => $txt_targovetc,
                        'txt_admin' => $txt_admin,
                        'targovec_email' => $targovec_email,
                        'targovec_name' => $targovec_name,
                        'admin_name' => $admin_name
                    );
                    // send to targovetc
                    Mail::send('mail_payment_targovetc', $data, function ($message) use ($targovec_email, $targovec_name){
                        $message->to($targovec_email, $targovec_name)->subject('Направена поръчка на пакет от PartyBox');
                        $message->from(Config::get('settings.mail'), 'PartyBox');
                    });
                    // send to admin
                    Mail::send('mail_payment_admin', $data, function ($message) use ($admin_email, $admin_name){
                        $message->to($admin_email, $admin_name)->subject('Направена поръчка на пакет от PartyBox');
                        $message->from($admin_email, 'PartyBox');
                    });
                    return redirect('/home-firm-payments')->with('flash_message_success', $txt_targovetc);
                }else{
                    if ($payment->payment == 'bank'){
                        $targovec_email = User::where(['id'=>Auth::user()->id])->first()->email;
                        $targovec_name = User::where(['id'=>Auth::user()->id])->first()->name;
                        $admin_email = Config::get('settings.mail');
                        $admin_name = $property->firm_name;

                        $txt_targovetc = '<p>' . $payment_type . '</p>';
                        $txt_targovetc .= '<p>Моля използвайте посочените по-долу данни за да платите чрез банков превод сумата от Вашата заявка:</p>';
                        $txt_targovetc .= '<p>Получател фирма: ' . $property->firm_name . '</p>';
                        $txt_targovetc .= '<p>Получател: ' . $property->mol . '</p>';
                        $txt_targovetc .= '<p>Банка: ' . $property->bank_name . '</p>';
                        $txt_targovetc .= '<p>IBAN: ' . $property->iban . '</p>';
                        $txt_targovetc .= '<p>BIC: ' . $property->bic . '</p>';
                        $txt_targovetc .= '<p>След получаване на средствата, пакетът който сте избрали ще бъде активиран за определения от Вас период.</p>';
                        $txt_targovetc .= '<p>Ще бъдете уведомени за това. След което ще можете да публикувате своите продукти.</p>';
    
                        $txt_admin = '<p>Получено е следното плащане по заявка за плащане по Банка:</p>';
                        $txt_admin .= '<p>' . $payment_type . '</p>';
                        $txt_admin .= '<p>Търговец: ' . $targovec_name . '</p>';
                        $txt_admin .= '<p>E-Mail: ' . $targovec_email . '</p>';
    
                        $data = array(
                            'txt_targovetc' => $txt_targovetc,
                            'txt_admin' => $txt_admin,
                            'targovec_email' => $targovec_email,
                            'targovec_name' => $targovec_name,
                            'admin_name' => $admin_name
                        );
                        // send to targovetc
                        Mail::send('mail_payment_targovetc', $data, function ($message) use ($targovec_email, $targovec_name){
                            $message->to($targovec_email, $targovec_name)->subject('Направена поръчка на пакет от PartyBox');
                            $message->from(Config::get('settings.mail'), 'PartyBox');
                        });
                        // send to admin
                        Mail::send('mail_payment_admin', $data, function ($message) use ($admin_email, $admin_name){
                            $message->to($admin_email, $admin_name)->subject('Направена поръчка на пакет от PartyBox');
                            $message->from($admin_email, 'PartyBox');
                        });
                        return redirect('/home-firm-payments')->with('flash_message_success', $txt_targovetc);
                    }else{
                        $targovec_email = User::where(['id'=>Auth::user()->id])->first()->email;
                        $targovec_name = User::where(['id'=>Auth::user()->id])->first()->name;
                        $admin_email = Config::get('settings.mail');
                        $admin_name = $property->firm_name;
                        
                        $data = array(
                            'txt_targovetc' => 'Направена поръчка на пакет от PartyBox платена с SMS',
                            'txt_admin' => 'Направена поръчка на пакет от PartyBox платена с SMS',
                            'targovec_email' => $targovec_email,
                            'targovec_name' => $targovec_name,
                            'admin_name' => $admin_name
                        );
                        // send to targovetc
                        //Mail::send('mail_payment_targovetc', $data, function ($message) use ($targovec_email, $targovec_name){
                        //    $message->to($targovec_email, $targovec_name)->subject('Направена поръчка на пакет от PartyBox');
                        //    $message->from(Config::get('settings.mail'), 'PartyBox');
                        //});
                        // send to admin
                        //Mail::send('mail_payment_admin', $data, function ($message) use ($admin_email, $admin_name){
                        //    $message->to($admin_email, $admin_name)->subject('Направена поръчка на пакет от PartyBox');
                        //    $message->from($admin_email, 'PartyBox');
                        //});                        
                        return redirect('/home-firm-payments')->with('flash_message_success', 'Вашето плащане е получено. Можете да публикувате Вашите продукти според това какъв пакет сте закупили.');
                    }
                }            
            }else{
                return redirect('/home-firm-payment-new')->with('flash_message_error', 'Трябва да изберете Търговец!');
            }
        }
        return view('firms.add_payment')->with([
            'user'=>$user,
            'holidays' => $holidays,
            'property' => $property
            ]);
    }

    public function firmPayments(){
        $holidays = Holiday::where(['parent_id' => 0])->get();
        $property = LandingPage::first();
        Payment::where(['status'=>'active', 'forthe'=>'standart'])->where('active_at', '<=', date("Y-m-d", strtotime("-2 months")))->update(array('status' => 'expired'));
        Payment::where(['status'=>'active', 'forthe'=>'reklama1'])->where('active_at', '<=', date("Y-m-d", strtotime("-5 days")))->update(array('status' => 'expired'));
        Payment::where(['status'=>'active', 'forthe'=>'reklama3'])->where('active_at', '<=', date("Y-m-d", strtotime("-10 days")))->update(array('status' => 'expired'));
        $user = User::where(['id' => Auth::user()->id])->first();
        $payments = Payment::where(['user_id' => $user->id])->orderBy('id', 'desc');
        $paginate = 5;
        $payments = $payments->paginate($paginate);
        return view('firms.payments')->with([
            'payments'=>$payments,
            'holidays' => $holidays,
            'property' => $property,
            'user'=>$user
            ]);
    }

}
