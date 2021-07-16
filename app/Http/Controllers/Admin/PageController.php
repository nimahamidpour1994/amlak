<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Setting;
use http\Exception;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['pages']=Category::where('type','Page')->get();
        $response['page_title']='لیست دیگر صفحات سایت';
        return view('back.page.page.list',compact('response'));

    }

    public function edit(Category $category)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;


        $response['parent']=$category;
        $response['page']=Page::firstWhere([['parent',$category->id],['parent_model','Category']]);
        $response['page_title']='ویرایش مطلب : '.$category->name;

        return view('back.page.page.edit',compact('response'));
    }

    public function update(Request $request,$category)
    {
        $category=Category::firstWhere('id',$category);

        $page=Page::firstWhere([['parent',$category->id],['parent_model','Category']]);
        if ($page !== null)
        {
            $request->validate([
                'title'=>'required',
                'description' => 'required',
                'category' => 'required',
            ]);

            $page->title=$request->title;
            $page->parent=$request->category;
            $page->content=$request->description;
        }
        else
        {
            $page=new Page([
                'title'=>$request->title,
                'parent' => $request->category,
                'parent_model'=>'Category',
                'content' => $request->description,
                'type' =>'page',
            ]);
        }


        try
        {
            $page->save();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning', $exception->getCode());
        }

        return redirect()->back()->with('success','مطلب با موفقیت ویرایش گردید.');
    }
}
