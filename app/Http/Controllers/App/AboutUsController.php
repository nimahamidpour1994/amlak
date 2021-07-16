<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['app_description']=optional(Setting::firstWhere('key','app_description'))->value;

        return view('front.page.aboutus',compact('response'));
    }

    public function contactus()
    {
        $response=[];

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['app_tell']=optional(Setting::firstWhere('key','app_tell'))->value;
        $response['app_address']=optional(Setting::firstWhere('key','app_address'))->value;
        $response['app_description']=optional(Setting::firstWhere('key','app_description'))->value;
        $response['socials']=Setting::where('key','social')->get();

        return view('front.page.contactus',compact('response'));
    }
}
