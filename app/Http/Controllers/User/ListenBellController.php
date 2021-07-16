<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Form;
use App\Models\ListenBell;
use App\Models\Meta;
use App\Models\Order;
use App\Models\Setting;
use App\Models\State;
use Illuminate\Http\Request;

class ListenBellController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['sendCode', 'verify', 'verifyUser']);
    }

    public function create($slug)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['app_description']=optional(Setting::firstWhere('key','app_description'))->value;

        if (isset($slug) && $slug !== 'choose-category')
        {
            $parent=Category::firstWhere('slug',$slug);
            $response['categories']= Category::where('parent', $parent->id)->orderBy('id', 'ASC')->get();
            $response['title']=$parent->name;
            if (count($response['categories']) > 0)
            {
                return view('user.advertisment.listenbell.choose-category', compact('response'));
            }
            else
            {
                // save selected category
                $response['parent']=$parent;

                // get title
                $response['title']=$response['parent']->name;

                // get city list
                $response['cities'] = City::orderBy('name', 'ASC')->get();

                $response['states']=State::where('parent',\Illuminate\Support\Facades\Cookie::get('city'))->orderBy('name')->get();


                // create array to save category and subcategory for get field
                $i=0;
                $field_parent=array();
                $field_parent[$i++]= $response['parent']->id;

                // get subcategory
                $parent=$response['parent']->Parent;
                while ($parent!='')
                {
                    $field_parent[$i++]=$parent->id;
                    $parent=$parent->Parent;
                }

                // get field for add this advertisment
                $response['fields'] = Form::whereIn('parent', $field_parent)->where('field','number')->orderBy('id', 'ASC')->get();

                $response['fields_counter']=1;
                // set and destroy session
                session()->put('categorylistenbell', $response['parent']->id);


                return view('user.advertisment.listenbell.create', compact('response'));

            }
        }
        else
        {
            $response['categories']=Category::where('parent','1')->orderBy('name', 'ASC')->get();
            $response['title']='گوش به زنگ';

            return view('user.advertisment.listenbell.choose-category', compact('response'));

        }


    }

    public function store(Request $request)
    {
        // create validation for form
        $rules=[
            'mobile'  =>  'required',
            'state'   =>  'required',
        ];
        // add dynamic validation
        foreach ($request->toArray() as $key => $value)
        {
            if (str_replace('minfield', '', $key) != $key)
            {
                $key = str_replace('minfield', '', $key);
                $rules+=['minfield'.$key=>'required'];
            }
            else if (str_replace('maxfield', '', $key) != $key)
            {
                $key = str_replace('maxfield', '', $key);
                $rules+=['maxfield'.$key=>'required'];
            }
        }
        $this->validate($request, $rules);

        $listenbell=new ListenBell([
            'category' => session()->get('categorylistenbell'),
            'state' => $request->state,
            'mobile' => $request->mobile,
            'who' => $request->who,
        ]);

        try {
            $listenbell->save();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning',$exception->getCode());
        }

        foreach ($request->toArray() as $key => $value)
        {
            if (str_replace('minfield', '', $key) != $key)
            {
                $key = str_replace('minfield', '', $key);
                $listenbell->setMeta(['minfieldlisten'=>$value],true,$key);
            }
            else if (str_replace('maxfield', '', $key) != $key)
            {
                $key = str_replace('maxfield', '', $key);
                $listenbell->setMeta(['maxfieldlisten'=>$value],true,$key);
            }
        }
        return redirect()->back()->with('success','اطلاعات مورد نظر با موفقیت ثبت شد');

    }

    public function index()
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['bells']=ListenBell::where('mobile',auth()->user()->mobile)->paginate(10);


        return view('user.other.bell',compact('response'));
    }

    public function destroy(ListenBell $bell)
    {
        $bell->delete();
        return redirect()->back()->with('success','عملیات با موفقیت انجام شد');
    }
}
