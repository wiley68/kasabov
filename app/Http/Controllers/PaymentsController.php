<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;

class PaymentsController extends Controller
{
    public function viewPayments(){
        $payments = Payment::all();
        return view('admin.firms.view_payments')->with(['payments'=>$payments]);
    }

    public function deletePayment(Request $request, $id=null){
        if (!empty($id)){
            Payment::where(['id'=>$id])->delete();
            return redirect('/admin/view-payments')->with('flash_message_success', 'Успешно изтрихте плащането!');
        }
    }

    public function editPayment(Request $request, $id=null){
        $payment = Payment::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            $payment->status = $request->input('payment_status');
            $payment->active_at = $request->input('payment_active_at');
            $payment->payment = $request->input('payment_payment');
            $payment->save();
            return redirect('/admin/edit-firm/'.$id)->with('flash_message_success', 'Успешно редактирахте фирмата!');
        }
        return view('admin.firms.edit_payment')->with([
            'payment'=>$payment
            ]);
    }

}
