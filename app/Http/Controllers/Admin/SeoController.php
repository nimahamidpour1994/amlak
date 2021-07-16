<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Meta;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class SeoController extends Controller
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
        $response['page_title']='ابزار سئو';

        $response['pages']=Meta::where('key','page')->paginate(15);


        return view('back.page.seo.list',compact('response'));
    }

    public function show(Meta $meta)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['parent']=$meta->id;
        if ($meta->unique === 'service')
        {
            $response['page']=Category::firstWhere('id',$meta->model_id);
            $response['page_title']='مدیریت سئو صفحه : '. $response['page']->title;
        }
        else if($meta->unique === 'blog')
        {
            $response['page']=Page::firstWhere('id',$meta->model_id);
            $response['page_title']='مدیریت سئو صفحه : '. $response['page']->title;
        }
        else
        {
            $response['page']=Setting::firstWhere('id',$meta->model_id);
            $response['page_title']='مدیریت سئو صفحه : صفحه اصلی';
        }

        $response['metas']=Meta::where([['model_id',$response['page']->id],['key','meta']])
            ->orderBy('id','ASC')
            ->get();

        $response['meta_key']=Setting::where('key','meta')
            ->WhereNotIn('unique',optional($response['metas'])->pluck('unique'))
            ->get();
        return view('back.page.seo.details',compact('response'));
    }

    public function store(Request $request,Meta $meta)
    {
        $request->validate([
            'value'=>'required',
        ]);
        if ($meta->unique === 'service')
        {
            $response['page']=Category::firstWhere('id',$meta->model_id);
        }
        elseif($meta->unique === 'blog')
        {
            $response['page']=Page::firstWhere('id',$meta->model_id);
        }
        else
        {
            $response['page']=Setting::firstWhere('id',$meta->model_id);
        }
        $response['page']->setMeta(['meta'=>$request->value],true,$request->type);

        return redirect()->back()->with('success','عملیات با موفقیت انجام شد');

    }

    public function destroy(Meta $meta)
    {
        $meta->delete();
        return redirect()->back()->with('success','عملیات با موفقیت انجام شد');
    }
}
