<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Speditor;

class SpeditorController extends Controller
{
    public function addSpeditor(Request $request){
        if ($request->isMethod('post')){
            $speditor_name = $request->input('speditor_name');
            $speditor_description = $request->input('speditor_description');
            $speditor = new Speditor();
            $speditor->name = $speditor_name;
            $speditor->description = $speditor_description;
            $speditor->save();
            return redirect('/admin/view-speditors')->with('flash_message_success', 'Успешно създадохте нов доставчик!');
        }
        return view('admin.speditors.add_speditor');
    }

    public function editSpeditor(Request $request, $id=null){
        $speditor = Speditor::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            $speditor->name = $request->input('speditor_name');
            $speditor->description = $request->input('speditor_description');
            $speditor->save();
            return redirect('/admin/view-speditors')->with('flash_message_success', 'Успешно редактирахте доставчика!');
        }
        return view('admin.speditors.edit_speditor')->with(['speditor'=>$speditor]);
    }

    public function deleteSpeditor(Request $request, $id=null){
        if (!empty($id)){
            $speditor = Speditor::where(['id'=>$id])->first();
            $speditor->delete();
            return redirect('/admin/view-speditors')->with('flash_message_success', 'Успешно изтрихте доставчика!');
        }
    }

    public function viewSpeditors(){
        $speditors = Speditor::all();
        return view('admin.speditors.view_speditors')->with(['speditors'=>$speditors]);
    }

    public static function getSpeditorById($id=null){
        if (!empty($id)){
            $speditor = Speditor::where(['id'=>$id])->first();
            return $speditor;
        }
    }

}
