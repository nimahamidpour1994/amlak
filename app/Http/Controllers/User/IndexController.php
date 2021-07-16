<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['sendCode', 'verify', 'verifyUser']);
    }

    public function verify(Request $request)
    {
        // **** validate phone number *****
        $request->validate(['mobile' => 'required|regex:/(09)[0-9]{9}/']);
        // **** validate phone number *****
        $mobile = $request->mobile;
        $this->sendCode($mobile);
        $app_name=optional(Setting::firstWhere('key','app_name'))->value;

        return view('auth.verifylogin', compact('mobile','app_name'));


    }

    public function sendCode($mobile)
    {

        // **** search user *****
        if (isset($mobile) && is_numeric($mobile)) {
            $user = User::firstWhere('mobile', '=', $mobile);
            $rand = rand(1000, 9999);
            if (isset($user->id)) {
                // **** edit password user *****
                $user->password = Hash::make($rand);
                $user->save();
                // **** edit password user *****
            } else {
                // **** new user *****
                $user = new User([
                    'mobile' => $mobile,
                    'password' => Hash::make($rand),
                ]);
                $user->save();
                // **** new user *****
            }
            // **** search user *****
            Smsirlaravel::send($rand, $mobile);
            return 'true';
        } else {
            return false;
        }

    }

    public function verifyUser(Request $request)
    {
        if (Auth::guard()->attempt(['mobile' => $request->mobile, 'password' => $request->password])) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function search(Request $request)
    {
        $SearchWord='';
        if (isset($request->text) && $request->text!='')
        {
            $SearchWord=$request->text;
            // CONVERT FA NUMBER TO EN
            $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $num = range(0, 9);
            $SearchWord = str_replace($persian, $num, $SearchWord);

        }

        $advertisments = Advertisment::where('mobile', Auth()->user()->mobile);

        if (isset($request->category) && $request->category!='')
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

        $output='';

        foreach ($advertisments as $advertisment)
        {
            $output.='<div class="row no-gutters border-bottom my-3">
                             <!-- SHOW ICON -->
                               <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-xl-center justify-content-lg-center justify-content-md-right justify-content-sm-right justify-content-xs-right mb-3">
                                  <img src="'.url('front/img/'. ($advertisment->icon!='' ? 'advertisment/'.$advertisment->icon : 'structure/template.png' )).'"
                                        class="img-cadr-main " alt="'.$advertisment->name.'">
                                  </div>';

            //SHOW TITLE AND FILED(SHOW THUMBNAIL)
            $output.= '<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                <div class="card-body p-0">

                                         <h3 class="bold text-black font-size-17 fa-num text-right mb-3">
                                                   '.$advertisment->name.'
                                         </h3>';
            foreach($advertisment->scopeMetaKey('','field')->get() as $meta)
            {
                if($meta->Form->show_thumbnail==1)
                {
                    $output.='<h2 class="text-right text-dark font-size-12 bold direction-rtl mt-0 fa-num">';
                    $output.=$meta->Form->name.':';

                    $output.=is_numeric($meta->value) ? number_format($meta->value) : $meta->value;
                    $output.='<span class="font-iran text-danger bold p-0">'.$meta->Form->unit.'</span></h2>';
                }

            }

            $output.= '<div class="d-flex flex-column">
                                         <p class="text-right">
                                                  <small class="text-muted">'.$advertisment->created_at->diffForHumans() .' در '.$advertisment->states->name.'</small>
                                          </p>
                                    </div></div></div>';


            // SHOW CUSTOMER INFO IF EXIST
            $output.='<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 text-right">';

            if($advertisment->owner_name!='')
            {
                $output.='<div class="d-flex flex-row mb-2">
                                                  <span class="font-iran font-size-1rem"> نام مالـک : </span>&nbsp;
                                                   <span class="fa-num bold text-danger font-size-1rem">'.$advertisment->owner_name.'</span>
                                                 </div>';
            }

            if($advertisment->owner_mobile!='')
            {
                $output.='<div class="d-flex flex-row mb-2">
                                                   <span class="font-iran font-size-1rem"> موبایل مالـک : </span>&nbsp;
                                                   <span class="fa-num bold text-danger font-size-1rem">'.$advertisment->owner_mobile.'</span>
                                                 </div>';
            }

            if($advertisment->owner_price!='')
            {
                $output.='<div class="d-flex flex-row mb-2">
                                                            <span class="font-iran font-size-1rem"> قیمت ملــک : </span>&nbsp;
                                                            <span class="fa-num bold text-danger font-size-1rem">'.$advertisment->owner_price.'</span>
                                                        </div>';
            }

            if($advertisment->owner_address!='')
            {
                $output.='<div class="d-flex flex-row mb-2">
                                                            <span class="font-iran font-size-1rem"> آدرس ملــک : </span>&nbsp;
                                                            <span class="fa-num bold text-danger font-size-1rem">'.$advertisment->owner_address.'</span>
                                                        </div>';
            }

            //SHOW STATE,EXPIRE,ADVERTISMENT ID , MANAGE ADVERTISMENT
            $output .='</div><div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card-body p-0">
                                                <div class="d-flex flex-row mb-2">
                                                    <span class="font-iran font-size-1rem">وضعیت آگهی : </span>&nbsp;';

            if($advertisment->show=='waiting')
                $output.='<span class="font-iran bold text-orange font-size-1rem">
                                           '.$advertisment->status->unique.'
                                       </span> &nbsp;';

            elseif($advertisment->show=='success')
                $output.='<span class="font-iran bold text-success font-size-1rem">
                                             '.$advertisment->status->unique.'
                                       </span> &nbsp;';

            else
                $output.='<span class="font-iran bold text-danger font-size-1rem">
                                               '.$advertisment->status->unique.'
                                        </span>&nbsp;';

            $output.='</div><div class="d-flex flex-row mb-2">
                                            <span class="font-iran font-size-1rem"> تاریخ انقضا : </span>&nbsp;
                                             <span class="fa-num bold text-danger font-size-1rem">'.jdate($advertisment->created_at->addDays(Plan::firstWhere('id',3)->last))->format('Y.m.d').'</span>
                                        </div>';

            $output.='<div class="d-flex flex-row mb-2">
                                            <span class="font-iran font-size-1rem"> کـد ملک : </span>&nbsp;
                                             <span class="fa-num bold text-secondary font-size-1rem">'.$advertisment->id.'</span>
                                         </div>
                                              <div class="d-flex flex-row mb-2">
                                                   <div class="d-flex flex-column">
                                                      <a href="'.route('panel.show.advertisment',$advertisment->slug).'"
                                                         class="btn btn-outline-danger btn-sm btn-fory ml-1  font-iran  bold">
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
