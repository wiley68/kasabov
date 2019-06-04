<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\User;
use Auth;
use App\Holiday;
use App\LandingPage;

class PaymentsController extends Controller
{
    public function viewPayments(){
        Payment::where(['status'=>'active', 'forthe'=>'standart'])->where('active_at', '<=', date("Y-m-d", strtotime("-2 months")))->update(array('status' => 'expired'));
        Payment::where(['status'=>'active', 'forthe'=>'reklama1'])->where('active_at', '<=', date("Y-m-d", strtotime("-5 days")))->update(array('status' => 'expired'));
        Payment::where(['status'=>'active', 'forthe'=>'reklama3'])->where('active_at', '<=', date("Y-m-d", strtotime("-10 days")))->update(array('status' => 'expired'));
        $payments = Payment::all();
        return view('admin.firms.view_payments')->with(['payments'=>$payments]);
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
        $payment = new Payment();
        $user = User::where(['id'=>Auth::user()->id])->first();
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
            'user'=>$user
            ]);
    }

    public function firmPayments(){
        $holidays = Holiday::where(['parent_id' => 0])->get();
        $property = LandingPage::first();
        Payment::where(['status'=>'active', 'forthe'=>'standart'])->where('active_at', '<=', date("Y-m-d", strtotime("-2 months")))->update(array('status' => 'expired'));
        Payment::where(['status'=>'active', 'forthe'=>'reklama1'])->where('active_at', '<=', date("Y-m-d", strtotime("-5 days")))->update(array('status' => 'expired'));
        Payment::where(['status'=>'active', 'forthe'=>'reklama3'])->where('active_at', '<=', date("Y-m-d", strtotime("-10 days")))->update(array('status' => 'expired'));
        $user = User::where(['id' => Auth::user()->id])->first();
        $payments = Payment::where(['user_id' => $user->id]);
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
