<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use http\Exception;
use Illuminate\Http\Request;

class SocialController extends Controller
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
        $response['socials']=Setting::where('key','social')->orderBy('id','ASC')->paginate(10);

        $response['page_title']='شبکه های اجتماعی';
        return view('back.page.setting.social',compact('response'));
    }


    public function store(Request $request)
    {
        $social=new Setting([
            'key'=>'social',
            'value'=>$request->link,
            'unique'=>$request->type
        ]);
        try {
            $social->save();
        } catch (Exception $exception) {
            return redirect()->back()->with('warning', $exception->getCode());
        }
        return redirect()->back()->with('success', 'شبکه اجتماعی جدید با موفقیت اضافه گردید ');
    }


    public function destroy(Setting $setting)
    {
        try {
            $setting->delete();
        } catch (Exception $exception) {
            return redirect()->back()->with('warning', $exception->getCode());
        }
        return redirect()->back()->with('success', 'شبکه اجتماعی مورد نظر با موفقیت حذف گردید ');

    }
}
