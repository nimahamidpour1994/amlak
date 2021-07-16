<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Models\Category;
use App\Models\Form;
use App\Models\Meta;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class MobileHomeController extends Controller
{

    public function changeCategory(Request $request)
    {
        $filters=array();

        // SET FILTERS AND NODE LIST
        $response=[];
        $response['filter']='';

        $category=Category::firstWhere('id',$request->id);
        $response['name']=$category->name;


        $name='categorybacktemp';
        Cookie::queue($name, $category->id,100);
        
        
        // GET FILTERS
        $i=0;
        while($category!='')
        {
            // GET FIELDS
            $fields=Form::where('parent',$category->id)->get();

            // CHECK FILED COUNT > 0
            if (count($fields)>0)
            {
                foreach ($fields as $field)
                {
                    // CHECK FILTERS COUNT > 0
                    if (count(Meta::where([['model_id',$field->id],['key','filter']])->get())>0)
                    {
                        // GET FILTERS AND TYPE FOR MIN,MAX,EQUAL
                        $filters[$i++]= [$field->id => Meta::where([['model_id',$field->id],['key','filter']])->get()];
                    }
                }
            }
            // GET UP PARENT
            $category=$category->Parent;
        }
        // GET FILTERS



        // SORT ARRAY
        asort($filters);

        foreach ($filters as $filter)
        {
            foreach ($filter as $key => $value)
            {
                $options='';
                $filterparent = Form::firstWhere('id', $key);

                // SET TWO FILTERS -> MIN,MAX FILTERS
                if ($filterparent->field=='number')
                {
                    // PARENT FILTER
                    $response['filter'] .= ' <ul class="mx-auto mb-3 m-0 p-0 border-bottom">
                                                <li style="list-style: none" class="my-3">
                                                    <a class="text-decoration-none" data-toggle="collapse"
                                                       href="#custom' . $filterparent->id . '" role="button" aria-expanded="false"
                                                       aria-controls="custom' . $filterparent->id . '">
                                                         <span class="text-dark font-size-14 bold text-right" id="filter' . $filterparent->id . '">' . $filterparent->name . '</span>
                                                        <i class="fas fa-angle-down filter-open mt-1 text-dark"></i>
                                                    </a>
                                                </li>';
                    // START FILTER
                    $response['filter'] .= '<li class="collapse multi-collapse p-0 my-3" style="list-style: none" id="custom' . $filterparent->id . '">
                                        <ul class="mx-auto mb-3 m-0 p-0">';

                    $value=$value->sortBy('value', SORT_REGULAR, false);

                    $countermin=0;
                    foreach ($value as $item)
                    {
                        if ($countermin++ === 0)
                        {
                            $minhover='مثلا '.$item->unique. ' ' . $filterparent->unit;
                        }
                        $maxhover='مثلا '.$item->unique. ' ' .$filterparent->unit;

                        $options.='<option class="fa-num"  value="'.$item->value.'">'.$item->unique.'</option>';
                    }

                    // MIN FILTER
                    $response['filter'] .= '<li class="range-field my-3">
                                             <div class="int-field__label font-size-14">حداقل</div>
                                             <select class="int-field__select-wrapper  form-control fa-num" id="min'.$filterparent->id.'" style="color:#c2c2c2" onclick=' . "changeColor('min$filterparent->id')" . '
                                             onchange=' . "changeConditionMobile('filter$filterparent->id','min$filterparent->id',this)" . '>
                                              <option value="" hidden>  '. $minhover .'</option>
                                                   ' . $options . '
                                              </select>
                                          </li>';

                    // MAX FILTER
                    $response['filter'] .= '<li class="range-field my-3">
                                                <div class="int-field__label font-size-14">حداکثر </div>
                                                <select class="int-field__select-wrapper form-control fa-num" id="max'.$filterparent->id.'" style="color:#c2c2c2" onclick=' . "changeColor('min$filterparent->id')" . '
                                              onchange=' . "changeConditionMobile('filter$filterparent->id','max$filterparent->id',this)" . '>
                                                  <option value="" hidden>'. $maxhover .'</option>
                                                       ' . $options . '
                                            </select>
                                            </li>';

                    // END FILTER
                    $response['filter'] .= '</ul></li></ul>';
                }


                else if($filterparent->field=='checkbox')
                {
                    $response['filter'].=' <ul class="mx-auto mb-3 m-0 p-0 border-bottom">
                                    <li class="my-3 list-none">
                                        <span class="text-dark font-size-14 bold text-right" id="filter'.$filterparent->id.'">'.$filterparent->name.'</span>
                                        <div class="custom-control custom-switch d-inline-block filter-open">
                                            <input type="checkbox" class="custom-control-input" id="custom'.$filterparent->id.'" value="'.$filterparent->value.'" onchange="' . "changeConditionMobile('filter$filterparent->id','filter$filterparent->id',this)" . '">
                                            <label class="custom-control-label checkbox-open" for="custom'.$filterparent->id.'"></label>
                                        </div>
                                    </li>
                                </ul>';
                }

                // SET JUST ONE FILTER -> EQUAL OR MIN
                else
                {
                    // PARENT FILTER
                    $response['filter'] .= ' <ul class="mx-auto mb-3 m-0 p-0 border-bottom">
                                                <li style="list-style: none" class="my-3">
                                                    <a class="text-decoration-none" data-toggle="collapse"
                                                       href="#custom' . $filterparent->id . '" role="button" aria-expanded="false"
                                                       aria-controls="custom' . $filterparent->id . '">
                                                         <span class="text-dark font-size-14 bold text-right" id="filter' . $filterparent->id . '">' . $filterparent->name . '</span>
                                                        <i class="fas fa-angle-down filter-open mt-1 text-dark"></i>
                                                    </a>
                                                </li>';
                    // START FILTER
                    $response['filter'] .= '<li class="collapse multi-collapse p-0 my-3" style="list-style: none" id="custom' . $filterparent->id . '">
                                        <ul class="mx-auto mb-3 m-0 p-0">';
                    $value=$value->sortBy('value', SORT_REGULAR, true);
                    foreach ($value as $item)
                    {
                        $options.='<option class="fa-num"  value="'.$item->value.'">'.$item->unique.'</option>';
                    }

                    $response['filter'].= '<li style="list-style: none" class="my-3">
                                         <select class="form-control fa-num" id="filter'.$filterparent->id.'"
                                            onchange='."changeConditionMobile('filter$filterparent->id','filter$filterparent->id',this)".'>
                                             <option value="" hidden>انتخاب کنید </option>
                                                 ' . $options . '
                                             </select>
                                      </li> ';
                    // END FILTER
                    $response['filter'] .= '</ul></li></ul>';
                }


            }
        }
        // SET FILTERS

        return json_encode($response);


    }

    public  function nodeList(Request $request)
    {
        $response=[];
        $response['category']='';
        $category=Category::firstWhere('id',$request->id);
        $id=$category->id;
        $response['id']=$category->parent;
        $response['name']=$category->name;
        $childs=$category->Child;


        $blog=Page::orderBy('id','ASC')->firstWhere('parent',$category->id);

        if (isset($blog))
        {
            $response['blog']='<a class="border rounded text-dark font-size-12 text-right fa-num text-decoration-none float-right p-2 mb-2"
                               href="'.route('app.blog.show',$blog->slug).'">در بلاگ بخوانید: '.$blog->title.'</a>';
        }
        else
        {
            $response['blog']='';
        }

        if ($childs!='')
        {
            foreach ($childs as $child)
            {
                if (count($child->Child)>0)
                {
                    $response['category'].='<li class="nav-item cursor-pointer list-none py-3 px-0 m-0 border-bottom"
                                    onclick="openSubCategoryMobile('.$child->id.','."'parent'".')">
                                    '.$child->name.'
                                        <i class="fas fa-chevron-left filter-open text-secondary"></i>
                                    </li>';
                }
                else
                {
                    $response['category'].='<li class="nav-item cursor-pointer list-none py-3 px-0 m-0 border-bottom"
                                    onclick="openSubCategoryMobile('.$child->id.',this)" data-dismiss="modal" aria-label="Close">
                                    '.$child->name.'
                                    </li>';
                }

            }
            if ($id!==1)
                $response['category'].='<li class="nav-item cursor-pointer list-none py-3 px-0 m-0 border-bottom"
                                    onclick="openSubCategoryMobile('.$id.',this)" data-dismiss="modal" aria-label="Close">
                                     همه آگهی های  '.$category->name.'
                                    </li>';
        }


        return json_encode($response);
    }

    public function searchWord(Request $request)
    {
        $suggests=[];
        if ($request->search != '')
        {
            $advertisments=Advertisment::where('name','LIKE','%'.$request->search.'%')->get();

            foreach ($advertisments as $advertisment)
            {
                $category=Category::firstWhere('id',$advertisment->category);
                if (count($category->Child) < 1)
                {
                    if (isset($suggests[$advertisment->category]))
                    {
                        $suggests[$advertisment->category]['count']+=1;
                    }
                    else
                    {
                        $suggests[$advertisment->category]['name']=$advertisment->Category->name;
                        $suggests[$advertisment->category]['count']=1;
                        $suggests[$advertisment->category]['id']=$advertisment->Category->id;
                    }
                }


            }
            $output = '<ul class="list-group">';
            $output.='<li class="list-group-item list-group-item-secondary  cursor-pointer border-top
                                direction-rtl font-size-14" onclick="searchWord()">
                        <i class="fa fa-search text-secondary"></i>&nbsp;&nbsp;
                      جستجوی خودکار بر اساس نام یا کد ملک
                        </li>';
            foreach ($suggests as $suggest)
            {
                if ($suggest['count']<10)
                    $count='کمتر از 10 ';
                elseif ($suggest['count']>10 && $suggest['count']<20)
                    $count='+10 ';
                elseif ($suggest['count']>20 && $suggest['count']<50)
                    $count='کمتر از 50 ';
                elseif ($suggest['count']>50 && $suggest['count']<100)
                    $count='+50 ';
                elseif ($suggest['count']>100 && $suggest['count']<200)
                    $count='+100 ';
                elseif ($suggest['count']>200 && $suggest['count']<400)
                    $count='+200 ';
                elseif ($suggest['count']>400 && $suggest['count']<600)
                    $count='+400 ';
                elseif ($suggest['count']>600 && $suggest['count']<800)
                    $count='+600 ';
                elseif ($suggest['count']>800 && $suggest['count']<1000)
                    $count='+800 ';
                else
                    $count='+1000';

                $output.='<li class="list-group-item list-group-item-light text-black cursor-pointer border-top py-2" onclick="suggestCategoryMobile('.$suggest['id'].')">
                            <div class="float-right">
                            <span class="d-block font-size-15 fa-num">'.$request->search.'</span>
                            <span class="font-size-12 text-secondary"> در '.$suggest['name'].' </span>
                            </div>

                            <span class="float-left fa-num font-size-12 text-secondary"> '.$count.' آگهی</span>
                         </li>';
            }
            $output.='</ul>';

            return $output;
        }
    }

    public  function nodeListSuggest(Request $request)
    {
        $category=Category::firstWhere('id',$request->id);
        return $category->name;
    }
}
