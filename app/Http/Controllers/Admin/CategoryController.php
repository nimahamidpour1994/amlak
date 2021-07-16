<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Models\Category;
use App\Models\Form;
use App\Models\Meta;
use App\Models\Setting;
use Illuminate\Http\Request;

class CategoryController extends Controller
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

        $response['page_title']='لیست دسته ها';

        $response['parent']=Category::firstWhere('id',1);
        $response['categories']=Category::where([['parent',1],['type','advertisment']])->orderBy('id','ASC')->paginate(10);

        return view('back.page.category.list',compact('response'));

    }

    public function show(Category $category)
    {

        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']='زیر دسته:  '.$category->name;

        $response['categories']=Category::where('parent',$category->id)->orderBy('id','ASC')->paginate(10);

        $response['parent']=$category;

        return view('back.page.category.list',compact('response'));


    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
        ]);

        if ($request->type === 'advertisment')
        {
            if ($request->parent === 1)
            {
                $slug=str_replace(' ','-',$request->name);
            }
            else
            {
                $parent=Category::firstWhere('id',$request->parent);
                $slug=str_replace(' ','-',$parent->name.' '.$request->name);
            }
        }

        $category=new Category([
            'name'=>$request->name,
            'slug'=>isset($slug) ? $slug : '',
            'parent'=>$request->parent,
            'type'=>$request->type,
        ]);
        try
        {
            $category->save();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning',$exception->getCode());
        }
        return redirect()->back()->with('success','دسته جدید با موفقیت ایجاد گردید ');

    }

    public function edit(Category $category)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']='ویرایش دسته : '.$category->name;

        $response['category']=$category;
        $response['categories']=Category::where([['id','<>',$category->id],['type','advertisment']])->orderBy('id','ASC')->get();
        return view('back.page.category.edit',compact('response'));
    }


    public function update(Request $request, Category $category)
    {
        $request->validate(['name'=>'required']);

        if ($request->type === 'advertisment')
        {
            if ($request->parent === 1)
            {
                $slug=str_replace(' ','-',$request->name);
            }
            else
            {
                $parent=Category::firstWhere('id',$request->parent);
                $slug=str_replace(' ','-',$parent->name.' '.$request->name);
            }
        }

        $category->name=$request->name;
        $category->slug=$slug;
        $category->parent=$request->parent;

        try
        {
            $category->save();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning',$exception->getCode());
        }
        return redirect()->back()->with('success','دسته مورد نظر با موفقیت ویرایش گردید ');

    }

    public function destroy(Category $category)
    {
        try
        {
            if ($category->Child())
            {
                foreach ($category->Child()->get() as $sub_category)
                {
                    // DELETE RELATED CATEGORY,ADVERTISMENT,META,FIELD
                    $this->completed_delete_category($sub_category->id);
                }
            }

            // GET RELATED ADVERTISMENT
            $advertisments=Advertisment::where('category',$category->id)->get();

            foreach ($advertisments as $advertisment)
            {
                // GET RELATED META
                $metas=Meta::where('model_id',$advertisment->id)->get();
                foreach ($metas as $meta)
                {
                    // CHECK IF META IS IMG DELETE IMG
                    if ($metas->key=='img')
                    {
                        unlink('front/img/advertisment/thumbnail/' . $metas->value);
                        unlink('front/img/advertisment/' . $metas->value);
                    }
                    // DELETE META
                    $meta->delete();
                }
                dd($metas);

                if ($advertisment->icon!='')
                {
                    unlink('front/img/advertisment/thumbnail/' .$advertisment->icon);
                    unlink('front/img/advertisment/' . $advertisment->icon);
                }
                $advertisment->delete();
            }

            // DELETE RELATED FIELD FORM
            Form::where('parent',$category->id)->delete();
            $category->delete();

        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning',$exception->getCode());
        }
        return redirect()->back()->with('success','دسته مورد نظر با موفقیت حذف گردید ');
    }

    public function completed_delete_category($id)
    {

        $category=Category::firstWhere('id',$id);
        if ($category->Child())
        {
            foreach ($category->Child()->get() as $sub_category)
            {
                $this->completed_delete_category($sub_category->id);
            }
        }

        // GET RELATED ADVERTISMENT
        $advertisments=Advertisment::where('category',$id)->get();

        foreach ($advertisments as $advertisment)
        {
            // GET RELATED META
            $metas=Meta::where('model_id',$advertisment->id)->get();
            foreach ($metas as $meta)
            {
                // CHECK IF META IS IMG DELETE IMG
                if ($meta->key=='img')
                {
                    unlink('front/img/advertisment/thumbnail/' . $meta->value);
                    unlink('front/img/advertisment/' . $meta->value);
                }
                // DELETE META
                $meta->delete();
            }


            if ($advertisment->icon!='')
            {
                unlink('front/img/advertisment/thumbnail/' .$advertisment->icon);
                unlink('front/img/advertisment/' . $advertisment->icon);
            }
            $advertisment->delete();
        }

        // DELETE RELATED FIELD FORM
        Form::where('parent',$id)->delete();
        $category->delete();


    }
}
