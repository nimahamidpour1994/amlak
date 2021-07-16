<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function edit()
    {
        $response=[];

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_issue']=optional(Setting::firstWhere('key','app_issue'))->value;
        $response['app_short_text']=optional(Setting::firstWhere('key','app_short_text'))->value;
        $response['app_description']=optional(Setting::firstWhere('key','app_description'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['app_address']=optional(Setting::firstWhere('key','app_address'))->value;
        $response['app_tell']=optional(Setting::firstWhere('key','app_tell'))->value;
        $response['blog_footer']=optional(Setting::firstWhere('key','blog_footer'))->value;
        $response['police_fata']=optional(Setting::firstWhere('key','police_fata'))->value;
        $response['app_warning']=optional(Setting::firstWhere('key','app_warning'))->value;

        $response['page_title']='تـنظیمات';
        return view('back.page.setting.edit',compact('response'));
    }

    public function update(Request $request)
    {

        // UPDATE LOGO TO STORAGE/SETTING
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('storage\setting');
//            $destinationPath = 'storage/setting';
            $img =\Intervention\Image\Facades\Image::make($image->getRealPath());
            $img->fit(200)->save($destinationPath. $input['imagename']);

            /* APP LOGO */
            $app_logo=Setting::firstWhere('key','app_logo');
            if ($app_logo!='')
            {
                $app_logo->value='storage/setting'.$input['imagename'];
            }
            else
            {
                $app_logo=new Setting([
                    'key'=>'app_logo',
                    'value'=>'storage/setting/'.$input['imagename'],
                    'unique'=>'لوگو سایت',
                ]);
            }
            $app_logo->save();

            // UPDATE LOGO TO STORAGE/SETTING
        }


        /* APP NAME */
        $app_name=Setting::firstWhere('key','app_name');
        if ($app_name!='')
        {
            $app_name->value=$request->title;
        }
        else
        {
            $app_name=new Setting([
                'key'=>'app_name',
                'value'=>$request->title,
                'unique'=>'عنوان سایت',
            ]);
        }
        $app_name->save();



        /* APP TIME */
        $app_issue=Setting::firstWhere('key','app_issue');
        if ($app_issue!='')
        {
            $app_issue->value=$request->issue;
        }
        else
        {
            $app_issue=new Setting([
                'key'=>'app_issue',
                'value'=>$request->issue,
                'unique'=>'موضوع سایت',
            ]);
        }
        $app_issue->save();



        /* APP ADDRESS */
        $app_address=Setting::firstWhere('key','app_address');
        if ($app_address!='')
        {
            $app_address->value=$request->address;
        }
        else
        {
            $app_address=new Setting([
                'key'=>'app_address',
                'value'=>$request->address,
                'unique'=>'آدرس',
            ]);
        }
        $app_address->save();



        /* APP TELLS */
        $app_tell=Setting::firstWhere('key','app_tell');
        if ($app_tell!='')
        {
            $app_tell->value=$request->tell;
        }
        else
        {
            $app_tell=new Setting([
                'key'=>'app_tell',
                'value'=>$request->tell,
                'unique'=>'تلفن تماس',
            ]);
        }
        $app_tell->save();



        /* APP DESCRIPTION */
        $app_description=Setting::firstWhere('key','app_description');
        if ($app_description!='')
        {
            $app_description->value=$request->description;
        }
        else
        {
            $app_description=new Setting([
                'key'=>'app_description',
                'value'=>$request->description,
                'unique'=>'درباره ما',
            ]);
        }
        $app_description->save();



        /* APP BLOG FOOTER */
        $app_blog_footer=Setting::firstWhere('key','blog_footer');
        if ($app_blog_footer!='')
        {
            $app_blog_footer->value=$request->blog_footer;
        }
        else
        {
            $app_blog_footer=new Setting([
                'key'=>'blog_footer',
                'value'=>$request->blog_footer,
                'unique'=>'توضیحات پایین بلاگ',
            ]);
        }
        $app_blog_footer->save();



        /* APP POLICE FATA */
        $app_police_fata=Setting::firstWhere('key','police_fata');
        if ($app_police_fata!='')
        {
            $app_police_fata->value=$request->police_fata;
        }
        else
        {
            $app_blog_footer=new Setting([
                'key'=>'police_fata',
                'value'=>$request->police_fata,
                'unique'=>'هشدار پلیس فتا',
            ]);
        }
        $app_police_fata->save();



        /* APP ADVERTISMENT WARNING */
        $app_warning=Setting::firstWhere('key','app_warning');
        if ($app_warning!='')
        {
            $app_warning->value=$request->app_warning;
        }
        else
        {
            $app_warning=new Setting([
                'key'=>'police_fata',
                'value'=>$request->app_warning,
                'unique'=>'هشدار آگهی',
            ]);
        }
        $app_warning->save();

        return redirect()->back()->with('ویرایش با موفقیت انجام شد');
    }
}
