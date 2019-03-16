<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    public function addTag(Request $request){
        if ($request->isMethod('post')){
            $tag_name = $request->input('tag_name');
            $tag = new Tag();
            $tag->name = $tag_name;
            $tag->save();
            return redirect('/admin/view-tags')->with('flash_message_success', 'Успешно създадохте нов етикет!');
        }
        return view('admin.tags.add_tag');
    }

    public function editTag(Request $request, $id=null){
        $tag = Tag::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            $tag->name = $request->input('tag_name');
            $tag->save();
            return redirect('/admin/view-tags')->with('flash_message_success', 'Успешно редактирахте етикета!');
        }
        return view('admin.tags.edit_tag')->with(['tag'=>$tag]);
    }

    public function deleteTag(Request $request, $id=null){
        if (!empty($id)){
            $tag = Tag::where(['id'=>$id])->first();
            $tag->delete();
            return redirect('/admin/view-tags')->with('flash_message_success', 'Успешно изтрихте етикета!');
        }
    }

    public function viewTags(){
        $tags = Tag::all();
        return view('admin.tags.view_tags')->with(['tags'=>$tags]);
    }

    public static function getTagById($id=null){
        if (!empty($id)){
            $tag = Tag::where(['id'=>$id])->first();
            return $tag;
        }
    }

}
