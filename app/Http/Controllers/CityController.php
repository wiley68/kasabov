<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;

class CityController extends Controller
{
    public function addCity(Request $request){
        if ($request->isMethod('post')){
            $city_city = $request->input('city_city');
            $city_oblast = $request->input('city_oblast');
            $city = new City();
            $city->city = $city_city;
            $city->oblast = $city_oblast;
            $city->save();
            return redirect('/admin/view-cities')->with('flash_message_success', 'Успешно създадохте ново населено място!');
        }
        return view('admin.cities.add_city');
    }

    public function editCity(Request $request, $id=null){
        $city = City::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            $city->city = $request->input('city_city');
            $city->oblast = $request->input('city_oblast');
            $city->save();
            return redirect('/admin/view-cities')->with('flash_message_success', 'Успешно редактирахте населеното място!');
        }
        return view('admin.cities.edit_city')->with(['city'=>$city]);
    }

    public function deleteCity(Request $request, $id=null){
        if (!empty($id)){
            $city = City::where(['id'=>$id])->first();
            $city->delete();
            return redirect('/admin/view-cities')->with('flash_message_success', 'Успешно изтрихте населеното място!');
        }
    }

    public function viewCities(){
        $cities = City::all();
        return view('admin.cities.view_cities')->with(['cities'=>$cities]);
    }

    public static function getCityById($id=null){
        if (!empty($id)){
            $city = City::where(['id'=>$id])->first();
            return $city;
        }
    }

}
