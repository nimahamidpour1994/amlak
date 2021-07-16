<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Setting;
use Illuminate\Http\Request;

class PlanController extends Controller
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

        $response['page_title']='مدیریت طراح ها';
        $response['plans']=Plan::orderBy('id','ASC')->get();
        return view('back.page.plan.list',compact('response'));
    }

    public function edit(Plan $plan)
    {
        $response=[];

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['plan']=$plan;

        $response['page_title']='ویرایش طرح : '.$plan->title;
        return view('back.page.plan.edit',compact('response'));

    }

    public function update(Request $request,Plan $plan)
    {
        if ($request->title !='')
            $plan->title=$request->title;
        if ($request->expire !='')
            $plan->expire=$request->expire;
        if ($request->price !='')
            $plan->price=$request->price;
        if ($request->description !='')
            $plan->description=$request->description;

        try {
            $plan->save();
        }catch (Exception $exception)
        {
            return redirect()->back()->with('warning',$exception->getCode());
        }

        return redirect()->back()->with('success','ویرایش با موفقیت انجام شد');
    }

}
