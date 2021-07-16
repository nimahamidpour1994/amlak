<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Form;
use App\Models\Meta;
use App\Models\Setting;
use Illuminate\Http\Request;

class FormController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function create(Category $category)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']='مدیریت فرم دسته : '.$category->name;

        $response['category']=$category;

        // *** for create Form
        $response['fields'] = Setting::where('key','field_format')->orderBy('id', 'ASC')->get();
        $response['forms'] = Form::where('parent', $category->id)->orderBy('id', 'ASC')->paginate(10);

        return view('back.page.form.list', compact('response'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        $form = new Form();
        try
        {
            $form->create($request->all());
        }
        catch (Exception $exception) {
            return redirect()->back()->with('warning', $exception->getCode());
        }
        return redirect()->back()->with('success', 'فیلد مورد نظر با موفقیت ایجاد گردید ');
    }

    public function edit(Form $form)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']='ویرایش فرم : '.$form->name;

        $response['form']=$form;

        $response['fields'] = Setting::where('key','field_format')->orderBy('id', 'ASC')->get();

        return view('back.page.form.edit', compact('response'));
    }

    public function update(Request $request, Form $form)
    {
        $this->middleware('auth:admin');
        $request->validate(['name' => 'required']);

        try
        {
            $form->update($request->all());
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning', $exception->getCode());
        }
        return redirect()->route('admin.form.list',$form->parent)->with('success', 'فیلد مورد نظر با موفقیت ویرایش گردید ');
    }


    public function destroy(Form $form)
    {
        optional(Meta::where([['unique',"$form->id"],['model','Advertisment']]))->delete();
        optional(Meta::where([['model_id',$form->id],['model','Form']]))->delete();
        $form->delete();
        return redirect()->back()->with('success', 'فیلد مورد نظر با موفقیت حذف گردید ');

    }
}
