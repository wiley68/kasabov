<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;

class HolidayController extends Controller
{
    public function addHoliday(Request $request){
        if ($request->isMethod('post')){
            $holiday_name = $request->input('holiday_name');
            $holiday_description = $request->input('holiday_description');
            $holiday_url = $request->input('holiday_url');
            $holiday = new Holiday();
            $holiday->name = $holiday_name;
            $holiday->description = $holiday_description;
            $holiday->url = $holiday_url;
            $holiday->save();
            return redirect('/admin/view-holidays')->with('flash_message_success', 'Успешно създадохте нов празник!');
        }
        return view('admin.holidays.add_holiday');
    }

    public function editHoliday(Request $request, $id=null){
        $holiday = Holiday::where(['id'=>$id])->first();
        if ($request->isMethod('post')){
            $holiday->name = $request->input('holiday_name');
            $holiday->description = $request->input('holiday_description');
            $holiday->url = $request->input('holiday_url');
            $holiday->save();
            return redirect('/admin/view-holidays')->with('flash_message_success', 'Успешно редактирахте празника!');
        }
        return view('admin.holidays.edit_holiday')->with(['holiday'=>$holiday]);
    }

    public function deleteHoliday(Request $request, $id=null){
        if (!empty($id)){
            $holiday = Holiday::where(['id'=>$id])->first();
            $holiday->delete();
            return redirect('/admin/view-holidays')->with('flash_message_success', 'Успешно изтрихте празника!');
        }
    }

    public function viewHolidays(){
        $holidays = Holiday::all();
        return view('admin.holidays.view_holidays')->with(['holidays'=>$holidays]);
    }

    public static function getHolidayById($id=null){
        if (!empty($id)){
            $holiday = Holiday::where(['id'=>$id])->first();
            return $holiday;
        }
    }

}
