<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advertisment;
use App\Models\Setting;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $response=[];
        $response['waitingaddvertisments']=Advertisment::where('show','waiting')->get()->count();
        $response['faildaddvertisments']=Advertisment::where('show','faild')->get()->count();;
        $response['successaddvertisments']=Advertisment::where('show','success')->get()->count();;
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;

        $response['page_title']='داشـبورد';
        return view('back.page.dashboard',compact('response'));
    }


}
