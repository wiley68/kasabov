<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function addPost(Request $request){
        if ($request->isMethod('post')){
            $post_title = !empty($request->input('title')) ? $request->input('title') : "";
            $post = new Blog();
            $post->title = $post_title;
            $post->save();
            return redirect('/admin/view-posts')->with('flash_message_success', 'Успешно създадохте нова публикация!');
        }
        return view('admin.blog.add_post');
    }

    public function viewPosts(){
        $posts = Blog::all();
        return view('admin.blog.view_posts')->with(['posts'=>$posts]);
    }

    public function deletePost(Request $request, $id=null){
    }

    public function editPost(Request $request, $id=null){
    }
}
