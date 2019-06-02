<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function viewPayments(){
        $firms = User::where(['admin'=>2])->get();
        return view('admin.firms.view_firms')->with(['firms'=>$firms]);
    }
}
