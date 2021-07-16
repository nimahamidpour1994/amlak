<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Setting;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        $response=[];

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']='مدیریت شهر ها';

        $response['cities']=City::orderBy('name','ASC')->paginate(10);
        return view('back.page.city.listCity',compact('response'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'lat'=>'required'
        ]);

        $city=new City([
            'name'=>$request->name,
            'latitude'=>$request->lat,
            'longitude'=>$request->lng,
        ]);

        try
        {
            $city->save();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning',$exception->getCode());
        }
        return redirect()->back()->with('success','شهر مورد نظر با موفقیت اضافه گردید ');

    }

    public function edit(City $city)
    {
        $response=[];

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']='ویرایش شهر : '.$city->name;

        $response['city']=$city;
        return view('back.page.city.editCity',compact('response'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name'=>'required',
            'lat'=>'required'
        ]);

        $city->name=$request->name;
        $city->latitude=$request->lat;
        $city->longitude=$request->lng;

        try
        {
            $city->save();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning',$exception->getCode());
        }
        return redirect()->back()->with('success','شهر مورد نظر با موفقیت ویرایش گردید ');

    }


    public function destroy(City $city)
    {
        try
        {
            $city->delete();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning',$exception->getCode());
        }
        return redirect()->back()->with('success','شهر مورد نظر با موفقیت حذف گردید ');
    }
}
