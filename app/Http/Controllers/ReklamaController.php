<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reklama;
use File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

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
            if (File::exists('images/backend_images/reklama_small/'.$reklama->image_small)){
                File::delete('images/backend_images/reklama_small/'.$reklama->image_small);
            }
            if (File::exists('images/backend_images/reklama_large/'.$reklama->image_large)){
                File::delete('images/backend_images/reklama_large/'.$reklama->image_large);
            }
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
            //upload image small
            if ($request->hasFile('image_small')) {
                // Delete old image
                $reklama_image_small = $reklama->image_small;
                if (File::exists('images/backend_images/reklama_small/' . $reklama_image_small)) {
                    File::delete('images/backend_images/reklama_small/' . $reklama_image_small);
                }
                $image_small_temp = Input::file('image_small');
                if ($image_small_temp->isValid()) {
                    $extension_small = $image_small_temp->getClientOriginalExtension();
                    $filename_small = $reklama->id . rand(111, 99999) . '.' . $extension_small;
                    $image_small_path = 'images/backend_images/reklama_small/' . $filename_small;
                    // Resize images
                    Image::make($image_small_temp)->resize(null, 200, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($image_small_path);
                }
            } else {
                $filename_small = $request->input('current_image_small');
                if (empty($request->input('current_image_small'))) {
                    $filename_small = '';
                }
            }
            //upload image large
            if ($request->hasFile('image_large')) {
                // Delete old image
                $reklama_image_large = $reklama->image_large;
                if (File::exists('images/backend_images/reklama_large/' . $reklama_image_large)) {
                    File::delete('images/backend_images/reklama_large/' . $reklama_image_large);
                }
                $image_large_temp = Input::file('image_large');
                if ($image_large_temp->isValid()) {
                    $extension_large = $image_large_temp->getClientOriginalExtension();
                    $filename_large = $reklama->id . rand(111, 99999) . '.' . $extension_large;
                    $image_large_path = 'images/backend_images/reklama_large/' . $filename_large;
                    // Resize images
                    Image::make($image_large_temp)->resize(null, 600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($image_large_path);
                }
            } else {
                $filename_large = $request->input('current_image_large');
                if (empty($request->input('current_image_large'))) {
                    $filename_large = '';
                }
            }
            $reklama->image_small = $filename_small;
            $reklama->image_large = $filename_large;
            $reklama->save();
            return redirect('/admin/edit-reklama/'.$id)->with('flash_message_success', 'Успешно редактирахте рекламата!');
        }
        return view('admin.reklami.edit_reklama')->with(['reklama'=>$reklama]);
    }

    public function deleteReklamaImageSmall(Request $request, $id=null){
        if (!empty($id)){
            $reklama_image_small = Reklama::where(['id'=>$id])->first()->image_small;
            if (File::exists('images/backend_images/reklama_small/'.$reklama_image_small)){
                File::delete('images/backend_images/reklama_small/'.$reklama_image_small);
            }
            Reklama::where(['id'=>$id])->update(['image_small'=>'']);
            return redirect('/admin/edit-reklama/'.$id)->with('flash_message_success', 'Успешно изтрихте снимката на рекламата!');
        }
    }

    public function deleteReklamaImageLarge(Request $request, $id=null){
        if (!empty($id)){
            $reklama_image_large = Reklama::where(['id'=>$id])->first()->image_large;
            if (File::exists('images/backend_images/reklama_large/'.$reklama_image_large)){
                File::delete('images/backend_images/reklama_large/'.$reklama_image_large);
            }
            Reklama::where(['id'=>$id])->update(['image_large'=>'']);
            return redirect('/admin/edit-reklama/'.$id)->with('flash_message_success', 'Успешно изтрихте снимката на рекламата!');
        }
    }

}
