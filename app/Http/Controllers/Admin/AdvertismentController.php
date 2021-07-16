<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Models\Category;
use App\Models\City;
use App\Models\Meta;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdvertismentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index($status)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        if ($status === 'publish')
        {
            $response['page_title'] = 'آگهی های منتــشر شده';
            $response['advertisments'] = Advertisment::where('show', 'success')->orderBy('created_at','DESC')->paginate(20);
        }
        elseif ($status === 'waiting')
        {
            $response['page_title'] = 'آگهی های در صف انتشار';
            $response['advertisments'] = Advertisment::where('show', 'waiting')->orderBy('created_at','DESC')->paginate(20);
        }
        elseif ($status === 'faild')
        {
            $response['page_title'] = 'آگهی های رد شده';
            $response['advertisments'] = Advertisment::where('show', 'faild')->orderBy('updated_at','ASC')->paginate(20);
        }
        else
        {
            $response['page_title'] = 'آگهی های : '.$status;
            $response['advertisments'] = Advertisment::where('mobile', $status)->orderBy('updated_at','ASC')->paginate(20);
        }

        $response['categories'] =Category::where('parent','1')->get();
        $i = 0;
        foreach ($response['categories'] as $category) {

            $response['cats'][$i++] = [
                'id' => $category->id,
                'name' =>  $category->name,
            ];
        }

        return view('back.page.advertisment.list', compact('response'));
    }

    public function show(Advertisment $advertisment)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']='پیش نمایش آگهی : '.$advertisment->name;
        $response['app_url']=optional(Setting::firstWhere('key','app_url'))->value;
        $response['advertisment_warning']=optional(Setting::firstWhere('key','advertisment_warning'))->value;


        $response['advertisment']=$advertisment;


        // *** FIELD VALUE ***
        $response['metas'] = $advertisment->scopeMetaKey('','field')->get();

        // *** GALLERY IMAGE ***
        $response['images'] =  $advertisment->scopeMetaKey('','img')->get();


        //  VIEWS
        for ($i=0;$i < 7 ;$i++)
        {
            $response['view_count'][$i]=Meta::where([['model','Advertisment'],['key','recent_seen'],['model_id',$response['advertisment']->id]])
                ->whereDate('created_at',Carbon::now()->subDays($i)->toDateString())->get()->count();
            $response['view_date'][$i]=jdate(Carbon::now()->subDays($i)->toDateString())->format('Y/m/d');
        }
        $response['view_all']=Meta::where([['model','Advertisment'],['key','recent_seen'],['model_id',$response['advertisment']->id]])
            ->get()->count();

        $response['max_view_count']=max($response['view_count']);

        return view('back.page.advertisment.preview', compact('response'));

    }

    public function edit(Advertisment $advertisment)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['advertisment']=$advertisment;

        $response['page_title']='ویرایش آگهی : '.$advertisment->name;

        // image options
        $response['images'] = $advertisment->scopeMetaKey('','img')->get();

        $response['status']=Setting::where('key','status')->get();

        session()->put('category', $advertisment->category);
        session()->forget('img');

        if ($advertisment->icon != '') {
            $i = 0;
            $img = [];
            $img[$i++] = ['src' => $advertisment->icon, 'type' => 'old'];

            foreach ($response['images'] as $image) {
                if (isset($image->value)) {
                    $img[$i++] = ['src' => $image->value, 'type' => 'old'];
                }
            }
            session()->put('img', $img);
        }
        return view('back.page.advertisment.edit', compact('response'));

    }

    public function update(Advertisment $advertisment, Request $request)
    {

        $sessionimg = session()->get('img');

        $request->validate([
            'name' => 'required',
            'details' => 'required',
        ]);

        // field advertisment table
        $advertisment->name = $request->name;
        $advertisment->details = $request->details;
        $advertisment->show = $request->status;
        if ($request->messageAdmin!='')
            $advertisment->messageAdmin = $request->messageAdmin;

        // field icon in advertisment
        if (isset($sessionimg[0]['src'])) {
            if ($advertisment->icon != $sessionimg[0]['src']) {
                if ($sessionimg[0]['type'] == 'old') {
                    Meta::where([['value', $sessionimg[0]['src']],['key','img']])->delete();
                }
                $advertisment->icon = $sessionimg[0]['src'];
            }
        } else {
            $advertisment->icon = '';
        }

        try {
            $advertisment->save();
        } catch (Exception $exception) {
            return redirect()->back()->with('warning', $exception->getCode());
        }

        if ($advertisment->show === 'waiting')
        {
            return redirect()->route('admin.advertisment.list','waiting')->with('success', 'آگهی با موفقیت ویرایش گردید ');

        }
        else if($advertisment->show=='success')
        {
            return redirect()->route('admin.advertisment.list','publish')->with('success', 'آگهی با موفقیت ویرایش گردید ');

        }
        else
        {
            return redirect()->route('admin.advertisment.list','faild')->with('success', 'آگهی با موفقیت ویرایش گردید ');

        }


    }

    public function destroy(Advertisment $advertisment){

        $advertisment->deleteMeta('field');
        $advertisment->deleteMeta('img');
        $advertisment->deleteMeta('recent_seen');
        $advertisment->deleteMeta('bookmark');
        $advertisment->delete();

        return redirect()->back()->with('success','آگهی با موفقیت حذف گردید');
    }


    public function search(Request $request)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['categories'] =Category::where('parent','1')->get();
        $i = 0;
        foreach ($response['categories'] as $category) {

            $response['cats'][$i++] = [
                'id' => $category->id,
                'name' =>  $category->name,
            ];
        }
        $response['page_title']='جتسجو آگهی ها';
        $advertisments=Advertisment::where('mobile','<>','');


        if(isset($request->key) && $request->key !== null )
        {
            if (is_numeric($request->key))
            {
                $advertisments->where('id',$request->key)->orWhere('mobile',$request->key);
            }
            else
            {
                $advertisments->where('name','LIKE', '%' . $request->key . '%');
            }
        }
        if (isset($request->category) && $request->category !== null)
        {
            $category=Category::firstWhere('id',$request->category);
            if (count($category->Child()->get()) > 0)
            {
                $array=$category->Child()->get()->pluck('id');
            }
            else
            {
                $array=[$category->id];
            }
            $advertisments->whereIn('category',$array);
        }


        $response['advertisments'] = $advertisments->orderBy('created_at', 'DESC')->paginate(30);

        return view('back.page.advertisment.list', compact('response'));
    }
}
