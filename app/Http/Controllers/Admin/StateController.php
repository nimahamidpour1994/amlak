<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Setting;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function show(City $city)
    {
        $response=[];

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']='مدیریت محل های شهر : ' .$city->name;
        $response['states']=State::where('parent',$city->id)->orderBy('name','ASC')->paginate(15);

        $response['city']=$city;
        return view('back.page.city.listState',compact('response'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'lat'=>'required'
        ]);

        $state=new State([
            'name'=>$request->name,
            'latitude'=>$request->lat,
            'longitude'=>$request->lng,
            'parent'=>$request->parent,
        ]);

        try
        {
            $state->save();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning',$exception->getCode());
        }
        return redirect()->back()->with('success','محله مورد نظر با موفقیت اضافه گردید ');

    }

    public function edit(State $state)
    {
        $response=[];

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']='ویرایش محل :' .$state->name;
        $response['state']=$state;

        return view('back.page.city.editState',compact('response'));

    }

    public function update(Request $request, State $state)
    {
        $request->validate([
            'name'=>'required',
            'lat'=>'required'
        ]);


        $state->name=$request->name;
        $state->latitude=$request->lat;
        $state->longitude=$request->lng;
        $state->parent=$request->parent;

        try
        {
            $state->save();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning',$exception->getCode());
        }
        return redirect()->route('admin.city.state.list',$state->parent)->with('success','محله مورد نظر با موفقیت ویرایش گردید ');
    }

    public function destroy(State $state)
    {
        try
        {
            $state->delete();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning',$exception->getCode());
        }
        return redirect()->back()->with('success','محله مورد نظر با موفقیت حذف گردید ');
    }
}
