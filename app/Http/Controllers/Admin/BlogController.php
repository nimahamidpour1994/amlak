<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Setting;
use http\Exception;
use Illuminate\Http\Request;

class BlogController extends Controller
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

        $parents=Category::where('type','advertisment')->get()->pluck('id');
        $response['blogs']=Page::where('parent_model','Category')->whereIn('parent',$parents)->paginate(10);
        $response['page_title']='لیست مطالب منتشر شده';
        return view('back.page.blog.list',compact('response'));
    }

    public function create()
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['parent']=Category::where([['type','advertisment'],['parent',1]])->orWhere('type','blog')->get();
        $response['page_title']='اضافه کردن مطلب جدید';
        return view('back.page.blog.add',compact('response'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title'=>'required|unique:pages',
            'description' => 'required',
            'thumbnail' => 'required|image|max:2024',
            'category' => 'required',
        ]);

        $page=new Page([
            'title'=>$request->title,
            'parent'=>$request->category,
            'parent_model'=>'Category',
            'content'=>$request->description
        ]);


        try
        {
            $page->save();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning',$exception->getCode());
        }
        $page->setMeta(['page'=>$page->id],false,'blog');
        return redirect()->back()->with('success','مطلب جدید با موفقیت اضافه گردید.');
    }

    public function edit($id)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['page_title']='ویرایش مطلب';

        $response['blog']=Page::firstWhere('id',$id);
        $response['parent']=Category::where([['type','advertisment'],['parent',1]])->get();
        return view('back.page.blog.edit',compact('response'));
    }

    public function update(Request $request,$id)
    {
        $page=Page::firstWhere('id',$id);

        $request->validate([
            'title'=>'required',
            'description' => 'required',
            'category' => 'required',
        ]);

        $page->title=$request->title;
        $page->parent=$request->category;
        $page->content=$request->description;

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

    public function destroy($id)
    {
        try
        {
            Page::firstWhere('id',$id)->delete();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning', $exception->getCode());
        }

        return redirect()->back()->with('success','مطلب با موفقیت حذف شد.');

    }
}
