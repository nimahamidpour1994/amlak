<?php

namespace App\Http\Controllers\App;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index($slug)
    {
        $response=[];

        // **** SETTINGS OF SITE ****
        $response['websazandeh_name']='وب سازنده';
        $response['websazandeh_logo']='https://websazandeh.ir/img/logo200.png';

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_short_text']=optional(Setting::firstWhere('key','app_short_text'))->value;
        $response['app_description']=optional(Setting::firstWhere('key','app_description'))->value;
        $response['app_issue']=optional(Setting::firstWhere('key','app_issue'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['app_tell']=optional(Setting::firstWhere('key','app_tell'))->value;
        $response['app_address']=optional(Setting::firstWhere('key','app_address'))->value;
        $response['blog_footer']=optional(Setting::firstWhere('key','blog_footer'))->value;
        $response['socials']=Setting::where('key','social')->get();

        // GET CATEGORY EXIST
        $parent=Page::where('type','blog')->get()->pluck('parent');
        $response['categories']=Category::whereIn('id',$parent)->get();

        // GET MOST VIEW BLOG
        $response['most_visited']=Page::where('type','blog')
            ->orderBy('views','DESC')->limit(3)->get();

        // GET BLOG --> IF SEARCH CATEGORY GET BLOG WITH SELECTED CATEGORY IF NOT GET ALL
        $category=Category::firstWhere('slug',$slug);

        if (isset($category) && $category!='')
        {
            $response['latest_content']=Page::where('type','blog')
                ->whereNotIN('id',$response['most_visited']->pluck('id'))
                ->where('parent',$category->id)
                ->orderBy('id','DESC')->get();
        }
        else
        {
            $response['latest_content']=Page::where('type','blog')
                ->whereNotIN('id',$response['most_visited']->pluck('id'))
                ->orderBy('id','DESC')->get();
        }

        $most_comments=Comment::orderBy('model_id', 'desc')->groupBy('model_id')->limit(4)->pluck('model_id');

        $response['most_comments']=Page::where('type','blog')
            ->whereIN('id',$most_comments)->get();
        return view('blog.page.main',compact('response'));
    }

    public function show($slug)
    {
        $response=[];

        // **** SETTINGS OF SITE ****
        $response['websazandeh_name']='وب سازنده';
        $response['websazandeh_logo']='https://websazandeh.ir/img/logo200.png';

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_short_text']=optional(Setting::firstWhere('key','app_short_text'))->value;
        $response['app_description']=optional(Setting::firstWhere('key','app_description'))->value;
        $response['app_issue']=optional(Setting::firstWhere('key','app_issue'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['app_tell']=optional(Setting::firstWhere('key','app_tell'))->value;
        $response['app_address']=optional(Setting::firstWhere('key','app_address'))->value;
        $response['blog_footer']=optional(Setting::firstWhere('key','blog_footer'))->value;
        $response['socials']=Setting::where('key','social')->get();

        // GET CATEGORY EXIST
        $parent=Page::where('type','blog')->get()->pluck('parent');
        $response['categories']=Category::whereIn('id',$parent)->get();

        // GET BLOG
        $response['blog']=Page::firstWhere([['type','blog'],['slug',$slug]]);
        $response['blog']->views++;
        $response['blog']->save();

        // GET META TAG FOR THIS BLOG
        $response['meta']=$response['blog']->getMeta('meta',true);

        // GET RELATED AND MOST VIEW BLOG
        $response['related_blog']=Page::where([['type','blog'],['parent',$response['blog']->parent]]);
        $response['latest_content']=Page::where('type','blog')
            ->where('id','<>',$response['blog']->id)
            ->orderBy('id','DESC')
            ->limit(3)
            ->get();


        $response['comments']=Comment::where([['model','page'],['model_id',$response['blog']->id]])->orderBy('id','ASC')->get();

        return view('blog.page.article',compact('response'));
    }

    public function search(Request $request)
    {
        $response=[];

        // **** SETTINGS OF SITE ****
        $response['websazandeh_name']='وب سازنده';
        $response['websazandeh_logo']='https://websazandeh.ir/img/logo200.png';

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_short_text']=optional(Setting::firstWhere('key','app_short_text'))->value;
        $response['app_description']=optional(Setting::firstWhere('key','app_description'))->value;
        $response['app_issue']=optional(Setting::firstWhere('key','app_issue'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['app_tell']=optional(Setting::firstWhere('key','app_tell'))->value;
        $response['app_address']=optional(Setting::firstWhere('key','app_address'))->value;
        $response['blog_footer']=optional(Setting::firstWhere('key','blog_footer'))->value;
        $response['socials']=Setting::where('key','social')->get();

        $parent=Page::where('type','blog')->get()->pluck('parent');
        $response['categories']=Category::whereIn('id',$parent)->get();
        $response['most_visited']=Page::where('type','blog')
            ->orderBy('views','DESC')->limit(3)->get();

        $response['search']=$request->search_text_name;

        $response['blogs']=Page::where([['type','blog'],['title','LIKE',$request->search_text_name.'%']])
            ->orderBy('id','DESC')->get();

        return view('blog.page.search',compact('response'));
    }

}
