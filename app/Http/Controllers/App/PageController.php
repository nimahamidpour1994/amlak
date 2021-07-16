<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($slug)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $category=Category::firstWhere('slug',$slug);

        $response['page']=Page::firstWhere([['parent',$category->id],['parent_model','Category']]);

        return view('front.page.page',compact('response'));
    }
}
