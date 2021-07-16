<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Meta;
use App\Models\Setting;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function show(Form $form)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']='مدیریت فیلتر فرم : '.$form->name;

        $response['form']=$form;

        $response['filters']=Meta::where([['model_id',$form->id],['key','filter']])->get();
        $response['filters']=$response['filters']->sortBy('value', SORT_REGULAR, false);

        return view('back.page.form.filter',compact('response'));
    }

    public function store(Request $request,Form $form)
    {

        $value=$request->value;
        $unique='';
        if ($request->name===null)
        {
            while($value>1000000)
            {
                if ($value>=1000000000)
                {
                    $temp=floor($value/(1000000000));
                    $value=$value%(1000000000);
                    $unique=$temp;
                    $unique.=' میلیارد ';

                }
                elseif ($value<=1000000000)
                {
                    $temp=floor($value/(1000000));
                    $value=$value%(1000000);
                    $value=$value/(1000);

                    if ($unique=='')
                    {
                        $unique=$temp;
                        $unique.=' میلیون ';
                        if ($value>0)
                        {
                            $unique.=' و ';
                            $unique.=$value.' هزار ';
                        }

                    }
                    else
                    {
                        $unique.=' و ';
                        $unique.=$temp;
                        $unique.=' میلیون ';
                        if ($value>0)
                        {
                            $unique.=' و ';
                            $unique.=$value.' هزار ';
                        }

                    }
                }

            }

            if ($unique==='')
            {
                $unique=$value;
            }
        }
        else
        {
            $unique=$request->name;
        }
        $form->setMeta(['filter'=>$request->value],false,$unique);

        return redirect()->back()->with('فیلتر با موفقیت اضافه گردید');

    }

    public function destroy($id)
    {
        $meta=Meta::firstWhere('id',$id);
        $meta->delete();
        return redirect()->back()->with('فیلتر با موفقیت حذف گردید');
    }
}
