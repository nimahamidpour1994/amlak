<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Models\Category;
use App\Models\Meta;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Plan;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class AdvertismentController extends Controller
{
    // IN ADVERTISMENT SHOW WHEN BACK
   public function backUrl()
    {
        if (Cookie::get('categorybacktemp') !== '')
        {
            $name='category';
            Cookie::queue($name, Cookie::get('categorybacktemp'),15);
        }

        return redirect()->route('app.home');
    }


    public function categoryBack($id)
    {
        $name='category';
        Cookie::queue($name, $id,15);

        return redirect()->route('app.home');
    }

    public function categoryStateBackDesktop(Advertisment $advertisment)
    {
        $name='state_desktop';
        Cookie::queue($name, $advertisment->state,60);

        $name='category';
        Cookie::queue($name, $advertisment->category,60);

        return redirect()->route('app.home');
    }


    public function categoryStateBackMobile(Advertisment $advertisment)
    {
        $name='state_mobile';
        Cookie::queue($name, $advertisment->state,60);

        $name='category';
        Cookie::queue($name, $advertisment->category,60);

        return redirect()->route('app.home');
    }

    public function show($slug)
    {
        $response=[];

        //  GET APP_NAME
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['police_fata']=optional(Setting::firstWhere('key','police_fata'))->value;
        $response['app_warning']=optional(Setting::firstWhere('key','app_warning'))->value;



        // ADVERTISMENT INFO
        $response['advertisment']=Advertisment::firstWhere('slug',$slug);

        if ($response['advertisment'] !== null )
        {
            //  FIELD VALUE
            $response['more_info'] = $response['advertisment']->scopeMetaKey('','field')->get();

            //  GALLERY IMAGE
            $response['images'] =  $response['advertisment']->scopeMetaKey('','img')->get();

            //  CHECK BOOKMARK STATUS
            $response['bookmark']=Meta::firstWhere([['model_id',$response['advertisment']->id],['model','Advertisment'],
                ['unique',isset(Auth()->user()->mobile)  ? Auth()->user()->mobile : \Request::ip()]]);

            $response['urgent']=OrderDetail::firstwhere([['advertisment',$response['advertisment']->id],['pay','paid'],
                ['plan','urgent'],['created_at','>',Carbon::now()->subDays(optional(Plan::where('key','urgent')->first())->expire)]]);

            $response['ladder']=OrderDetail::firstwhere([['advertisment',$response['advertisment']->id],['pay','paid'],
                ['plan','ladder'],['created_at','>',Carbon::now()->subDays(optional(Plan::where('key','ladder')->first())->expire)]]);


            //  GET REPORT CATEGORY
            $response['report_category']=Setting::where('key','report')->orderBy('id','ASC')->get();




            $i=0;
            $parent=Category::firstWhere('id',$response['advertisment']->category);
            while ($parent->parent !== null)
            {
                $response['parent'][$i++]=$parent;
                $parent=Category::firstWhere('id',$parent->parent);
            }

            // INFO FOR VIEW
            $view=new Meta([
                'model'=>'Advertisment',
                'model_id'=>$response['advertisment']->id,
                'unique'=>\Request::ip(),
                'value'=>\Request::ip(),
                'key'=>'recent_seen'
            ]);

            try
            {
                $view->save();
            }
            catch (Exception $exception)
            {
                return redirect()->back()->with('warning',$exception->getCode());
            }
            return view('front.page.advertisment.show', compact('response'));

        }
        else
        {
            return redirect()->route('app.notfound');

        }

    }
}
