<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{

    public function recent_seen(){

        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['advertisments']=Meta::where([['model','Advertisment'],['unique',\Request::ip()],['key','recent_seen']])
                                  ->orderBy('id','DESC')->limit(30)->get();

        return view('user.other.recent-seen',compact('response'));
    }

    public function bookmark(){
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;


        $response['advertisments']=Meta::where([['model','Advertisment'],
                            ['unique',isset(Auth()->user()->mobile)  ? Auth()->user()->mobile : \Request::ip()],['key','bookmark']])
            ->orderBy('id','DESC')->get();

        return view('user.other.bookmarks',compact('response'));
    }

    public function bookmark_destroy(Meta $meta)
    {
        $this->middleware('auth');

        $meta->delete();
        return redirect()->back();
    }
}
