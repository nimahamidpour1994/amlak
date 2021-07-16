<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Models\Category;
use App\Models\City;
use App\Models\Form;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{

    public function index()
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['app_issue']=optional(Setting::firstWhere('key','app_issue'))->value;


        $response['expire_day']=optional(Plan::firstWhere('key','extension'))->expire;
        if ($response['expire_day'] === null)
            $response['expire_day']=30;

        // SELECT CITY --> WITH COOKIE OR FIRST CITY
        if (Cookie::get('city')!='')
        {
            $response['state']=State::where('parent',Cookie::get('city'))->get();
        }
        else
        {
            $parent=City::orderBy('name','ASC')->first();
            $response['state']=State::where('parent',$parent->id)->get();
        }


        // CHECK LOAD FIRST OR BACK FROM SHOW ADVERTISMENT
        if (Cookie::get('category') !== '')
        {
            $response['back_category']=Category::firstWhere('id',Cookie::get('category'));

            $name='category';
            Cookie::queue($name, '',1);
        }

        // CHECK LOAD FIRST OR BACK FROM SHOW ADVERTISMENT DESKTOP
        if (Cookie::get('state_desktop') !== '')
        {
            $response['back_state_desktop']=Cookie::get('state_desktop');

            $name='state_desktop';
            Cookie::queue($name, '',1);
        }

        // CHECK LOAD FIRST OR BACK FROM SHOW ADVERTISMENT MOBILE
        if (Cookie::get('state_mobile') !== '')
        {
            $response['back_state_mobile']=Cookie::get('state_mobile');

            $name='state_mobile';
            Cookie::queue($name, '',1);
        }


        $name='categorybacktemp';
        Cookie::queue($name,'',1);
        

        // SELECT THE LAST  ADVERTISMENT
        $response['advertisments'] = Advertisment::where([['show','success'],['created_at','>',Carbon::now()->subDays($response['expire_day'])]])
            ->whereIn('state',$response['state']->pluck('id'))->orderBy('updated_at', 'DESC')->limit(10)
            ->with(['Meta'=>function($list){
                $list->whereIn('model_id',Form::where('show_thumbnail',1)->get()->pluck('id'))->get();
            }])
            ->get();


        // CATEGORY
        $response['categories'] = Category::where('parent', '1')->orderBy('id','ASC')->get();


        return view('front.page.main', compact('response'));
    }

}
