<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;

class FavoriteController extends Controller
{
    public function deleteFavorite(Request $request, $product_id=null, $user_id=null){
        if (!empty($product_id) && !empty($user_id)){
            $favorite = Favorite::where(['product_id'=>$product_id, 'user_id'=>$user_id])->first();
            // Delete favorite
            $favorite->delete();
            return redirect('/home-favorites');
        }else{
            return redirect('/home-favorites');
        }
    }
}
