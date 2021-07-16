<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Models\Category;
use App\Models\City;
use App\Models\Form;
use App\Models\ListenBell;
use App\Models\Meta;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pay;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Payment\Invoice;


class AdvertismentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
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
        $response['advertisments'] = Advertisment::where('mobile', Auth()->user()->mobile)
            ->orderBy('updated_at', 'DESC')
            ->limit(5)
            ->get();

        $response['expire_day']=optional(Plan::firstWhere('key','extension'))->expire;
        if ($response['expire_day'] === null)
            $response['expire_day']=30;

        return view('user.advertisment.list', compact('response'));
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
                return view('user.advertisment.add.choose-category', compact('response'));
            }
            else
            {
                // save selected category
                $response['parent']=$parent;

                // get title
                $response['title']=$response['parent']->name;

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
                $response['fields'] = Form::whereIn('parent', $field_parent)->orderBy('id', 'ASC')->get();

                // get city list
                $response['cities'] = City::orderBy('name', 'ASC')->get();

                $response['states']=State::where('parent',\Illuminate\Support\Facades\Cookie::get('city'))->orderBy('name')->get();

                // set and destroy session
                session()->put('category', $response['parent']->id);
                session()->forget('img');

                return view('user.advertisment.add.create', compact('response'));

            }
        }
        else
        {
            $response['categories']=Category::where('parent','1')->orderBy('name', 'ASC')->get();
            $response['title']='ثـبت رایـگان آگـهی';

            return view('user.advertisment.add.choose-category', compact('response'));

        }


    }

    public function store(Request $request)
    {

        // CRAETE VALIDATION FOR FORM
        $rules=[
            'name'    =>  'required',
            'details' =>  'required',
            'mobile'  =>  'required',
            'state'   =>  'required',
            'lat'   =>  'required',
        ];

        // ADD DYNAMIC VALIDATION
        foreach ($request->toArray() as $key => $value)
        {
            if (str_replace('field', '', $key) != $key)
            {
                $key = str_replace('field', '', $key);
                $field=Form::firstWhere('id',$key);
                if ($field->force === 1)
                {
                    $rules+=['field'.$key=>'required'];
                }
            }
        }
        $this->validate($request, $rules);

        //----------------------------------------------------------------------------------------------

        // CREATE RANDOM SLUG FOR ADVERTISMENT
        $randomString = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        for ($i = 0; $i < 10; $i++)
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        //-----------------------------------------------------------------------------------------------

        // IMAGE
        $img = '';
        $imgs = session()->get('img');

        // CHECK ICON IMAGE
        if (isset($imgs[0]))
        {
            $img = $imgs[0]['src'];
        }

        //-----------------------------------------------------------------------------------------------

        // SAVE BASIC INFO
        $advertisment = new Advertisment([
            'name' => $request->name,
            'category' => session()->get('category'),
            'state' => $request->state,
            'mobile' => $request->mobile,
            'details' =>  $request->details,
            'slug' => $randomString,
            'icon' => $img,
            'latitude' => $request->lat,
            'longitude' => $request->lng,
            'who' => $request->who,
            'owner_name' => $request->owner_name,
            'owner_mobile' => $request->owner_mobile,
            'owner_address' => $request->owner_address,
            'owner_price' => $request->owner_price,
            'owner_details' => $request->owner_details,
        ]);
        try
        {
            $advertisment->save();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning', $exception->getCode());
        }

        //-------------------------------------------------------------------------------------------------

        $id = $advertisment->id;

        if ($id)
        {

            // SAVE MORE INFO
            foreach ($request->toArray() as $key => $value)
            {
                if (str_replace('field', '', $key) != $key)
                {
                    // for single value
                    if (!is_array($value))
                    {
                        $key = str_replace('field', '', $key);
                        $advertisment->setMeta(['field'=>$value],false,$key);
                    }
                    // for more than one value ----> checkbox
                    else
                    {
                        $key = str_replace('field', '', $key);
                        for ($i=0;$i<count($value);$i++)
                        {
                            $meta=New Meta([
                                'key'=>'field',
                                'unique'=>$key,
                                'value'=>$value[$i],
                                'model'=>'Advertisment',
                                'model_id'=>$id,
                            ]);
                            $meta->save();
                        }
                    }

                }
            }

            // SAVE IMAGE
            $items = session()->get('img');
            for ($i = 1; $i < 6; $i++)
            {
                if (isset($items[$i]['src']))
                {
                    $advertisment->setMeta(['img'=>$items[$i]['src']],true);
                }
            }

            // LISTEN BELL
            if ($request->listenbell === 'yes')
            {
                // CRAETE ARRAY TO SAVE CATEGORY AND SUBCATEGORY FOR GET FIELD
                $parent=Category::firstWhere('id',$advertisment->category);
                $i=0;
                $field_parent=array();
                $field_parent[$i++]= $parent->id;

                // GET SUBCATEGORY
                $parent=$parent->Parent;
                while ($parent!='')
                {
                    $field_parent[$i++]=$parent->id;
                    $parent=$parent->Parent;
                }

                // GET FIELD FOR ADD THIS ADVERTISMENT
                $response['fields'] = Form::whereIn('parent', $field_parent)->where('field','number')->orderBy('id', 'ASC')->get();


                // SEARCH WITH META VALUE
                foreach ($request->toArray() as $key => $value)
                {
                    if (str_replace('field', '', $key) != $key)
                    {
                        $key = str_replace('field', '', $key);
                        if (in_array($key,$response['fields']->pluck('id')->toArray()))
                        {
                            if (isset($listenbellmetaid) && count($listenbellmetaid) > 0)
                                $meta=Meta::where([['key','minfieldlisten'],['unique',$key],
                                    ['value','<',$value]])->whereIn('model_id',$listenbellmetaid)->get();
                            else
                                $meta=Meta::where([['key','minfieldlisten'],['unique',$key],['value','<',$value]])->get();

                            $listenbellmetaid=$meta->pluck('model_id')->toArray();

                        }
                    }
                }

                // SEARCH WITH BASIC VALUE
                $listenbells=ListenBell::where([['category',$advertisment->category],['state',$advertisment->state]])
                    ->whereIn('id',$listenbellmetaid)->whereIn('who',['both',$advertisment->who])->get();

                // IF COUNT > 0 SAVE IN ORDER
                if ($listenbells->count() > 0)
                {

                    $sms_pay=optional(Setting::firstWhere('key','sms_pay'))->value;
                    if ($sms_pay !== null)
                        $sms_pay=20;

                    if ($listenbells->count() < 10)
                        $price=200;
                    else
                        $price=$listenbells->count() * $sms_pay;

                    $order=new Order([
                        'advertisment'=>$id,
                        'price'=>$price,
                        'discount'=>0,
                        'pay'=>'unpaid',
                    ]);
                    $order->save();

                    $order_detail=new OrderDetail([
                        'advertisment'=>$id,
                        'order'=>$order->id,
                        'plan'=>'listen_bell',
                        'price'=>$price,
                        'pay'=>'unpaid',
                    ]);

                    $order_detail->save();


                    // ZARINPAL PAYMENT
                    $invoice = new Invoice;
                    $invoice->amount($price);
                    $invoice->detail('order',$order->id);
                    $invoice->detail('price',$price);
                    Payment::purchase($invoice,function($driver, $transactionId) {});

                    // SAVE PAYMENT DETAIL IN MYSQL
                    $pay=new Pay([
                        "order"=>$order->id,
                        "price"=>$price,
                        "authority"=>$invoice->getTransactionId(),
                    ]);
                    $pay->save();

                    // SET SESSION
                    session()->put('listenbellsid', $listenbells->pluck('id'));

                    return Payment::pay();


                }


            }
        }



        return redirect()->route('user.dashboard');

    }

    public function show($slug)
    {

        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['app_url']=optional(Setting::firstWhere('key','app_url'))->value;
        $response['advertisment_warning']=optional(Setting::firstWhere('key','advertisment_warning'))->value;

        // ADVERTISMENT INFO
        $response['advertisment']=Advertisment::firstWhere('slug',$slug);

        // FIELD VALUE
        $response['metas'] = $response['advertisment']->scopeMetaKey('','field')->get();

        //  GALLERY IMAGE
        $response['images'] =  $response['advertisment']->scopeMetaKey('','img')->get();

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

        $response['expire_day']=optional(Plan::firstWhere('key','extension'))->expire;
        if ($response['expire_day'] === null)
            $response['expire_day']=30;

        return view('user.advertisment.show', compact('response'));

    }

    public function edit($slug)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['app_description']=optional(Setting::firstWhere('key','app_description'))->value;

        $response['advertisment']=Advertisment::firstWhere('slug',$slug);
        // create array to save category and subcategory for get field
        $i=0;
        $field_parent=array();
        $field_parent[$i++]=$response['advertisment']->category;
        $parent=Category::firstWhere('id',$response['advertisment']->Category->parent);
        $response['title']=$response['advertisment']->Category->name;
        while ($parent!='')
        {
            $field_parent[$i++]=$parent->id;
            $parent=$parent->Parent;
        }

        // GET FIELD FOR THIS ADVERTISMENT
        $response['fields'] = Form::whereIn('parent', $field_parent)->orderBy('id', 'ASC')->get();

        //  KEY VALUE OPTION
        $response['metas'] = $response['advertisment']->scopeMetaKey('','field')->get();

        //  IMAGE OPTION
        $response['images'] = $response['advertisment']->scopeMetaKey('','img')->get();

        // GET CITIES LIST
        $response['cities'] = City::orderBy('name', 'ASC')->get();

        // GET STATES LIST
        $response['states'] = State::where('parent', $response['advertisment']->State->parent)->orderBy('name', 'ASC')->get();

        session()->put('category', $response['advertisment']->category);
        session()->forget('img');

        if ($response['advertisment']->icon != '') {
            $i = 0;
            $img = [];
            $img[$i++] = ['src' => $response['advertisment']->icon, 'type' => 'old'];

            foreach ($response['images'] as $image) {
                if (isset($image->value)) {
                    $img[$i++] = ['src' => $image->value, 'type' => 'old'];
                }
            }
            session()->put('img', $img);
        }

        $response['expire_day']=optional(Plan::firstWhere('key','extension'))->expire;
        if ($response['expire_day'] === null)
            $response['expire_day']=30;

        return view('user.advertisment.edit', compact('response'));

    }

    public function update(Request $request, Advertisment $advertisment)
    {
        $rules=[
            'name'    =>  'required',
            'details' =>  'required',
            'mobile'  =>  'required',
            'state'   =>  'required',
        ];
        foreach ($request->toArray() as $key => $value)
        {
            if (str_replace('field', '', $key) != $key)
            {
                $key = str_replace('field', '', $key);
                $field=Form::firstWhere('id',$key);
                if ($field->force == 1)
                {
                    $rules+=['field'.$key=>'required'];
                }
            }
        }
        $this->validate($request, $rules);

        $sessionimg = session()->get('img');

        // field advertisment table
        $advertisment->name = $request->name;
        $advertisment->details = $request->details;
        $advertisment->state = $request->state;
        $advertisment->who = $request->who;
        $advertisment->latitude = $request->lat;
        $advertisment->longitude = $request->lng;
        $advertisment->timestamps = false;
        if ($advertisment->who=='agent')
        {
            $advertisment->owner_name = $request->owner_name;
            $advertisment->owner_mobile = $request->owner_mobile;
            $advertisment->owner_address = $request->owner_address;
            $advertisment->owner_price = $request->owner_price;
            $advertisment->owner_details = $request->owner_details;
        }
        else
        {
            $advertisment->owner_name = '';
            $advertisment->owner_mobile = '';
            $advertisment->owner_address ='';
            $advertisment->owner_price = '';
            $advertisment->owner_details = '';
        }


        // field icon in advertisment
        if (isset($sessionimg[0]['src']))
        {
            if ($advertisment->icon != $sessionimg[0]['src']) {
                if ($sessionimg[0]['type'] == 'old') {
                    Meta::where([['value',$sessionimg[0]['src'],['key','img']]])->delete();

                }
                $advertisment->icon = $sessionimg[0]['src'];
            }
        }
        else {
            $advertisment->icon = '';
        }
        // field icon in advertisment

        // field advertisment table
        if ($advertisment->save()) {
            // meta fields
            foreach ($request->toArray() as $key => $value) {
                if (str_replace('field', '', $key) != $key)
                {
                    $key = str_replace('field', '', $key);
                    $getMeta = Meta::firstWhere([['key','field'],['unique',$key],['model_id',$advertisment->id]]);
                    if (isset($getMeta))
                    {
                        $getMeta->value = $value;
                        $getMeta->save();
                    }
                    else
                    {
                        $meta=New Meta([
                            'key'=>'field',
                            'unique'=>$key,
                            'value'=>$value,
                            'model'=>'Advertisment',
                            'model_id'=>$advertisment->id,
                        ]);
                        $meta->save();
                    }


                }
            }
            // meta fields

            // images fields
            for ($i = 1; $i < 6; $i++)
                if (isset($sessionimg[$i]))
                    if ($sessionimg[$i]['src'] != '' && $sessionimg[$i]['type'] == 'new')
                    {
                        $advertisment->setMeta(['img'=>$sessionimg[$i]['src']],true);
                    }
            // images fields

            return redirect()->route('user.dashboard');
        }
        return redirect()->back()->with('warning', 'عملیات با خطا همراه بود.لطفا دوباره تلاش کنید');

    }

    public function destroy(Advertisment $advertisment)
    {
        $advertisment->deleteMeta('field');
        $advertisment->deleteMeta('img');
        $advertisment->deleteMeta('recent_seen');
        $advertisment->deleteMeta('bookmark');

        $orders= Order::where('advertisment',$advertisment->id)->get();
        Pay::whereIn('order',$orders->pluck('id')->toArray())->delete();
        foreach ($orders as $order)
            $order->delete();
        OrderDetail::where('advertisment',$advertisment->id)->delete();

        $advertisment->delete();

        return redirect()->route('user.dashboard');
    }

    public function search(Request $request)
    {
        $SearchWord='';

        if (isset($request->text) && $request->text !== '')
        {
            $SearchWord=$request->text;
            // CONVERT FA NUMBER TO EN
            $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $num = range(0, 9);
            $SearchWord = str_replace($persian, $num, $SearchWord);
        }

        $advertisments = Advertisment::where('mobile', Auth()->user()->mobile);

        // SEARCH ADVERTISMENT
        if (isset($request->category) && $request->category != '')
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

            if ($SearchWord!='')
            {
                $advertisments->where('id',$SearchWord)->whereIn('category',$array);
                $advertisments->orWhere('name','LIKE', '%' . $SearchWord . '%')->whereIn('category',$array);
                $advertisments->orWhere('owner_mobile',$SearchWord)->whereIn('category',$array);
                $advertisments->orWhere('owner_name','LIKE', '%' . $SearchWord . '%')->whereIn('category',$array);
            }
            else
            {
                $advertisments->whereIn('category',$array);
            }
        }
        else
        {
            if ($SearchWord!='')
            {

                $advertisments->where('id',$SearchWord);
                $advertisments->orWhere('name','LIKE', '%' . $SearchWord . '%');
                $advertisments->orWhere('owner_mobile',$SearchWord);
                $advertisments->orWhere('owner_name','LIKE', '%' . $SearchWord . '%');

            }
        }

        $advertisments = $advertisments->orderBy('created_at', 'DESC')
            ->skip($request->limit * $request->counter)->take($request->limit)->get();

        // LOAD ADVERTISMENT

        $response=[];
        $response['expire_day']=optional(Plan::firstWhere('key','extension'))->expire;
        if ($response['expire_day'] === null)
            $response['expire_day']=30;


        $output='';
        foreach ($advertisments as $advertisment)
        {
            $output.='<div class="row no-gutters border-bottom my-2">
                             <!-- SHOW ICON -->
                               <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-xl-center justify-content-lg-center justify-content-md-right justify-content-sm-right justify-content-xs-right mb-3">
                                  <img src="'.url(($advertisment->icon !== '' ? 'storage/advertisment/thumbnail/'.$advertisment->icon : 'front/img/structure/template.png' )).'"
                                        class="img-cadr-main " alt="'.$advertisment->name.'">
                                  </div>';

            //SHOW TITLE AND FILED(SHOW THUMBNAIL)
            $output.= '<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 pt-1">
                                <div class="card-body p-0">

                                         <h3 class="bold text-black font-size-15 fa-num text-right mb-3">
                                                   '.$advertisment->name.'
                                         </h3>';
            foreach($advertisment->scopeMetaKey('','field')->get() as $meta)
            {
                if($meta->Form->show_thumbnail==1)
                {
                    $output.='<h2 class="text-right text-dark font-size-12 bold direction-rtl mt-0 fa-num">';
                    $output.=$meta->Form->name.' : ';

                    $output.=is_numeric($meta->value) ? number_format($meta->value) : $meta->value;
                    $output.='<span class="font-iran text-danger bold p-0"> '.$meta->Form->unit.'</span></h2>';
                }

            }

            $output.= '<div class="d-flex flex-column">
                                         <p class="text-right mb-0">
                                                  <small class="text-info bold font-size-12 fa-num">'.$advertisment->created_at->diffForHumans() .' در '.$advertisment->State->name.'</small>
                                          </p>
                                    </div></div></div>';


            // SHOW CUSTOMER INFO IF EXIST
            $output.='<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 text-right pt-1">';

            if($advertisment->owner_name!='')
            {
                $output.='<div class="d-flex flex-row mb-2">
                                                  <span class="font-iran font-size-12 bold"> نام مالـک : </span>&nbsp;
                                                   <span class="fa-num bold text-muted font-size-12 bold">'.$advertisment->owner_name.'</span>
                                                 </div>';
            }

            if($advertisment->owner_mobile!='')
            {
                $output.='<div class="d-flex flex-row mb-2">
                                                   <span class="font-iran font-size-12 bold"> موبایل مالـک : </span>&nbsp;
                                                   <span class="fa-num bold text-muted font-size-12 bold">'.$advertisment->owner_mobile.'</span>
                                                 </div>';
            }

            if($advertisment->owner_price!='')
            {
                $output.='<div class="d-flex flex-row mb-2">
                                                            <span class="font-iran font-size-12 bold"> قیمت ملــک : </span>&nbsp;
                                                            <span class="fa-num bold text-muted font-size-12 bold">'.$advertisment->owner_price.'</span>
                                                        </div>';
            }

            if($advertisment->owner_address!='')
            {
                $output.='<div class="d-flex flex-row mb-2">
                                                            <span class="font-iran font-size-12 bold"> آدرس ملــک : </span>&nbsp;
                                                            <span class="fa-num bold text-muted font-size-12 bold">'.$advertisment->owner_address.'</span>
                                                        </div>';
            }


            //SHOW STATE,EXPIRE,ADVERTISMENT ID , MANAGE ADVERTISMENT
            $output .='</div><div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 pt-1">
                                            <div class="card-body p-0">
                                                <div class="d-flex flex-row mb-2">
                                                    <span class="font-iran font-size-12 bold">وضعیت آگهی : </span>&nbsp;';

            if($advertisment->created_at > \Carbon\Carbon::now()->subDays($response['expire_day']))
            {
                if($advertisment->show=='waiting')
                    $output.='<span class="font-iran bold text-orange font-size-12 bold">
                                           '.$advertisment->Status->unique.'
                                       </span> &nbsp;';

                elseif($advertisment->show=='success')
                    $output.='<span class="font-iran bold text-success font-size-12 bold">
                                             '.$advertisment->Status->unique.'
                                       </span> &nbsp;';

                else
                    $output.='<span class="font-iran bold text-danger font-size-12 bold">
                                               '.$advertisment->Status->unique.'
                                        </span>&nbsp;';
            }
            else
            {
                $output.='<span class="font-iran bold text-danger font-size-12 bold">
                                               منقضی شده
                                        </span>&nbsp;';
            }


            $output.='</div><div class="d-flex flex-row mb-2">
                                            <span class="font-iran font-size-12 bold"> تاریخ انقضا : </span>&nbsp;
                                             <span class="fa-num bold text-danger font-size-12 bold">'.jdate($advertisment->created_at->addDays(Plan::firstWhere('id',3)->last))->format('Y.m.d').'</span>
                                        </div>';

            $output.='<div class="d-flex flex-row mb-2">
                                            <span class="font-iran font-size-12 bold"> کـد ملک : </span>&nbsp;
                                             <span class="fa-num bold text-primary font-size-12 bold">'.$advertisment->id.'</span>
                                         </div>
                                              <div class="d-flex flex-row mb-2">
                                                   <div class="d-flex flex-column">
                                                      <a href="'.route('user.advertisment.preview',$advertisment->slug).'"
                                                         class="btn btn-outline-danger btn-sm mx-1 font-iran font-size-12 bold">
                                                                مدیریت آگهی
                                                       </a>
                                                   </div>
                                                 </div>
                                              </div>
                                            </div>
                                        </div>';
        }

        return $output;

    }



}
