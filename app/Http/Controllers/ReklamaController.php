<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reklama;

class ReklamaController extends Controller
{
    public function viewReklami(){
        $reklami = Reklama::all();
        return view('admin.reklami.view_reklami')->with(['reklami'=>$reklami]);
    }

    public function addReklama(Request $request){
        if ($request->isMethod('post')){
            $reklama_title = !empty($request->input('title')) ? $request->input('title') : "";
            $reklama_description = !empty($request->input('description')) ? $request->input('description') : "";
            $reklama_url = !empty($request->input('url')) ? $request->input('url') : "";
            $reklama_status = !empty($request->input('status')) ? $request->input('status') : 1;
            $reklama = new Reklama();
            $reklama->title = $reklama_title;
            $reklama->description = $reklama_description;
            $reklama->url = $reklama_url;
            $reklama->status = $reklama_status;
            $reklama->save();
            return redirect('/admin/view-reklami')->with('flash_message_success', 'Успешно създадохте нова реклама!');
        }
        return view('admin.reklami.add_reklama');
    }

    public function deleteReklama(Request $request, $id=null){
        if (!empty($id)){
            $reklama = Reklama::where(['id'=>$id])->first();
            $reklama->delete();
            return redirect('/admin/view-reklami')->with('flash_message_success', 'Успешно изтрихте рекламата!');
        }
    }

    public function editReklama(Request $request, $id=null){
        $reklama = Reklama::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            $reklama->title = !empty($request->input('title')) ? $request->input('title') : "";
            $reklama->description = !empty($request->input('description')) ? $request->input('description') : "";
            $reklama->url = !empty($request->input('url')) ? $request->input('url') : "";
            $reklama->status = intval($request->input('status'));
            $reklama->save();
            return redirect('/admin/view-reklami')->with('flash_message_success', 'Успешно редактирахте рекламата!');
        }
        return view('admin.reklami.edit_reklama')->with(['reklama'=>$reklama]);
    }

}
