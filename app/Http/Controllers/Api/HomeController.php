<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Models\Category;
use App\Models\City;
use App\Models\Form;
use App\Models\Meta;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Plan;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{

    public function MoreAdvertisment(Request $request)
    {
        $response=[];
        $response['expire_day']=optional(Plan::firstWhere('key','extension'))->expire;
        if ($response['expire_day'] === null)
            $response['expire_day']=30;

        // SELECT CITY -->WITH COOKIE OR FIRST CITY
        if (Cookie::get('city')!='')
        {
            $state=State::where('parent',Cookie::get('city'))->get()->pluck('id');
        }
        else
        {
            $parent=City::orderBy('name','ASC')->first();
            $state=State::where('parent',$parent->id)->get()->pluck('id');
        }
        // SELECT CITY -->WITH COOKIE OR FIRST CITY

        // SELECT ADVERTISMENT
        $advertisments = Advertisment::where([['show','success'],['created_at','>',Carbon::now()->subDays($response['expire_day'])]]);
        // SELECT ADVERTISMENT

        // CUSTOM FILTERS
        if ($request->conditions != '')
            foreach ($request->conditions as $condition) {
                if (isset($condition['key'])) {

                    // HAS IMAGE
                    if ($condition['key'] == 'img') {
                        if ($condition['value'] == 1)
                            $advertisments->where('icon', '<>', '');
                    }

                    // HAS URGENT
                    if ($condition['key'] == 'urgent') {
                        if ($condition['value'] == 1) {
                            $urgents = OrderDetail::where([['plan', 'urgent'],['pay','paid'],['created_at', '>', Carbon::now()->subDays(optional(\App\Models\Plan::firstWhere('key','urgent'))->expire)]])->get()->pluck('advertisment');
                            $advertisments->whereIn('id', $urgents);
                        }
                    }

                    // WHO --> AGENT OR PERSON
                    if ($condition['key'] == 'who')
                    {
                        $advertisments->where('who', $condition['value']);
                    }

                    // SEARCH BOX
                    if ($condition['key'] == 'search') {
                        if ($condition['value'] != '') {
                            $advertisments->where('name','LIKE','%'.$condition['value'].'%');
                            $advertisments->orWhere('id',$condition['value']);
                        }
                    }

                    // CHANGE STATE OR CITY
                    if ($condition['key']=='state')
                    {
                        $advertisments->where('state', $condition['value']);
                    }

                    // CHANGE CATEGORY
                    if ($condition['key'] == 'category' && $condition['value'] != 0)
                    {
                        $category=Category::firstWhere('id',$condition['value']);

                        // CHECK THIS CATEGORY HAS CHILDS
                        if (count($category->Child)!= 0)
                        {
                            // GET CHILD OF THIS CATEGORY
                            $list=Category::whereIn('parent',$category->Child->pluck('id'))->get()->pluck('id');

                            /* check childs of childs of category */
                            if (count($list)!=0)
                                $advertisments->whereIn('category',$list);
                            else
                                $advertisments->whereIn('category',$category->Child->pluck('id'));
                        }
                        else
                        {
                            $advertisments->where('category', $condition['value']);
                        }
                        // CHECK THIS CATEGORY HAS CHILDS
                    }
                    // CHANGE CATEGORY

                    // FILTERS -----> MIN - MAX - FILTER

                    // ******** MIN ********
                    if (str_replace('min','',$condition['key']) !=$condition['key'])
                    {
                        $id=str_replace('min','',$condition['key']);
                        $advertismentslist=Meta::where([['unique',$id],['value','>=',(int)$condition['value']]])->get();
                        $advertisments->whereIn('id',$advertismentslist->pluck('model_id'));
                    }

                    // ******** MAX ********
                    if (str_replace('max','',$condition['key']) !=$condition['key'])
                    {
                        $id=str_replace('max','',$condition['key']);
                        $advertismentslist=Meta::where([['unique',$id],['value','<=',(int)$condition['value']]])->get();
                        $advertisments->whereIn('id',$advertismentslist->pluck('model_id'));
                    }

                    // ******** FILTER ********
                    if (str_replace('filter','',$condition['key']) !=$condition['key'])
                    {
                        $id=str_replace('filter','',$condition['key']);

                        // CHECK IF VALUE IS NUMBER FILTER DO MORE THAN ( > )
                        if (is_numeric($condition['value']))
                        {
                            $advertismentslist=Meta::where([['unique',$id],['value','>=',(int)$condition['value']]])->get();
                            $advertisments->whereIn('id',$advertismentslist->pluck('model_id'));
                        }
                        // CHECK IF VALUE IS STRING FILTER EQUAL
                        else
                        {
                            $advertismentslist=Meta::where([['unique',$id],['value',$condition['value']]])->get();
                            $advertisments->whereIn('id',$advertismentslist->pluck('model_id'));
                        }
                    }

                }
            }

        // GET ADVERTISMENT ORDER BY UODATED_AT SKIP  X NUMBERS WITH META(FOR MORE INFO AND IMAGE)
        $advertisments = $advertisments->whereIn('state',$state)->orderBy('updated_at','DESC')->
        skip($request->limit * $request->counter)->take($request->limit)
            ->with(['Meta'=>function($list){
                $list->whereIn('unique',Form::where('show_thumbnail',1)->get()->pluck('id'))->get();
            }])
            ->get();


        $response = '';
        foreach ($advertisments as $advertisment) {

            if ($advertisment->icon!='')
            {
                $icon='storage/advertisment/thumbnail/'. $advertisment->icon ;
            }
            else
            {
                $icon='front/img/structure/template.png';
            }
            // LOAD ADVERTISMENT
            $response .= '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <a href="'.route('app.show.advertisment',$advertisment->slug).'" class="text-decoration-none">
                                    <div class="border-none border-bottom-1 mb-3 single-card">
                                    <div class="row no-gutters">

                                        <div class="col-6">
                                              <span class="bg-divar text-white rounded btn-sm position-absolute fa-num font-size-12 m-2 bold">کد :' . $advertisment->id . '</span>
                                              <img src="'.$icon.'" class="img-cadr-main"  alt="' . $advertisment->name . '">
                                        </div>

                                        <div class="col-6 min-100">
                                            <div class="card-body p-0">
                                                <h2 class="d-flex card-title mb-1 align-right card-title-style direction-rtl fa-num text-black" style="min-height: 62px!important;">' . mb_substr(strip_tags($advertisment->name),0,50,'UTF8') . '</h2>
                                                <div class="text-right" style="min-height:55px">';

            foreach($advertisment->Meta as $meta)
            {
                $response.='<h2 class="text-right text-dark font-size-12 bold direction-rtl mt-0 fa-num">
                              '.$meta->Form->name;
                $response.=' :';
                $response.=is_numeric($meta->value) ? number_format($meta->value) : $meta->value;
                $response.='<span class="font-iran text-danger bold pr-1">'.$meta->Form->unit.'</span></h2>';
            }

            $response.='</div>';

            $response .= '<div class="d-flex flex-column bd-highlight mb-1 direction-rtl">';

            /* urgent advertisments */
            if (OrderDetail::firstwhere([['advertisment',$advertisment->id],
                ['plan','urgent'],['created_at','>',Carbon::now()->subDays(Plan::firstWhere('key','urgent')->expire)]]))
            {
                $response.=' <p class="card-text card-text-style">
                                  <span class="border border-danger rounded btn-fory mx-1 px-1 text-danger font-iran font-size-12 bold">فوری</span>
                                  <small class="text-muted fa-num"> در '.$advertisment->State->name.'</small>
                              </p>';
            }
            else
            {
                $response.='<p class="card-text card-text-style text-right">
                                 <small class="text-muted fa-num font-size-12">';
                     if(strlen($advertisment->updated_at->diffForHumans().' در '.$advertisment->State->name) > 25)
                         $response.=mb_substr(strip_tags($advertisment->created_at->diffForHumans().' در '.$advertisment->State->name),0,25,'UTF8');
                     else
                         $response.=$advertisment->updated_at->diffForHumans().' در '.$advertisment->State->name;
                $response.='</small>
                            </p>';
            }
            /* urgent advertisments */

            $response .= '</div></div></div></div></div></a></div>';
        }
        return $response;
    }

    public function SubCategoryName(Request $request)
    {
        $response=[];
        $response['btnHelp']='';
        $category=Category::firstWhere('id',$request->id);
        $response['name']=$category->name;
        return json_encode($response);
    }

}
