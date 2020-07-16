<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    public function addPost(Request $request){
        if ($request->isMethod('post')){    
            $post_title = !empty($request->input('title')) ? $request->input('title') : "";
            $description = !empty($request->input('description')) ? $request->input('description') : "";
            $meta_title = !empty($request->input('meta_title')) ? $request->input('meta_title') : "";
            $meta_description = !empty($request->input('meta_description')) ? $request->input('meta_description') : "";
            $meta_keywords = !empty($request->input('meta_keywords')) ? $request->input('meta_keywords') : "";
            $post = new Blog();
            $post->title = $post_title;
            $post->description = $description;
            $post->meta_title = $meta_title;
            $post->meta_description = $meta_description;
            $post->meta_keywords = $meta_keywords;
            $post->image = '';
            $post->save();
            return redirect('/admin/edit-post/'.$post->id)->with('flash_message_success', 'Успешно създадохте публикацията!');
        }
        return view('admin.blog.add_post');
    }

    public function viewPosts(){
        $posts = Blog::all();
        return view('admin.blog.view_posts')->with([
            'posts'=>$posts
        ]);
    }

    public function deletePost(Request $request, $id=null){
        if (!empty($id)){
            $post = Blog::where(['id'=>$id])->first();
            $post->delete();
            return redirect('/admin/view-posts')->with('flash_message_success', 'Успешно изтрихте публикацията!');
        }
    }

    public function editPost(Request $request, $id=null){
        
        $post = Blog::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            $post->title = $request->input('title');
            $post->description = $request->input('description');
            $post->meta_title = $request->input('meta_title');
            $post->meta_description = $request->input('meta_description');
            $post->meta_keywords = $request->input('meta_keywords');
            //upload image
            if ($request->hasFile('image')) {
                // Delete old image
                $post_image = $post->image;
                if (File::exists('images/backend_images/blog/small/'.$post_image)){
                    File::delete('images/backend_images/blog/small/'.$post_image);
                }
                if (File::exists('images/backend_images/blog/large/'.$post_image)){
                    File::delete('images/backend_images/blog/large/'.$post_image);
                }
                $image_temp = Input::file('image');
                if ($image_temp->isValid()) {
                    $extension = $image_temp->getClientOriginalExtension();
                    $filename = $post->id . rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/blog/large/'.$filename;
                    $small_image_path = 'images/backend_images/blog/small/'.$filename;
                    // Resize images
                    Image::make($image_temp)->resize(null, 600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($large_image_path);
                    Image::make($image_temp)->resize(null, 300, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($small_image_path);
            }
            } else {
                $filename = $request->input('current_image');
                if (empty($request->input('current_image'))) {
                    $filename = '';
                }
            }
            $post->image = $filename;
            $post->save();
            return redirect('/admin/edit-post/'.$id)->with('flash_message_success', 'Успешно редактирахте публикацията!');
        }
        return view('admin.blog.edit_post')->with(['post'=>$post]);
    }

    public function deletePostImage(Request $request, $id=null){
        if (!empty($id)){
            $post_image = Blog::where(['id'=>$id])->first()->image;
            if (File::exists('images/backend_images/blog/small/'.$post_image)){
                File::delete('images/backend_images/blog/small/'.$post_image);
            }
            if (File::exists('images/backend_images/blog/large/'.$post_image)){
                File::delete('images/backend_images/blog/large/'.$post_image);
            }
            Blog::where(['id'=>$id])->update(['image'=>'']);
            return redirect('/admin/edit-post/'.$id)->with('flash_message_success', 'Успешно изтрихте снимката!');
        }
    }
}
