<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Page;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function search(Request $request)
    {
        $blogs=Page::where('title','LIKE','%'.$request->search.'%')->orderBy('id','DESC')->limit(4)->get();

        $output='';

        foreach ($blogs as $blog)
        {
            $output.='<div class="card border-bottom mt-2">
                                <a class="w-100 d-content text-decoration-none cursor-pointer blog-hover"
                                 href="'.route('app.blog.show',$blog->slug).'">
                                    <div class="row no-gutters">
                                        <!-- IMG -->
                                        <div class="col-4">
                                            <img src="'.url($blog->thumbnail).'" style="height: 70px!important;margin-top:10px" class="card-img height-100" alt="'.$blog->title.'">
                                        </div>

                                        <!-- TEXT -->
                                        <div class="col-8">
                                            <div class="card-body" style="padding: 0.75rem!important;">
                                                <h2 class="card-title text-right font-size-14 font-yekan text-black">'.$blog->title.'</h2>
                                                <div class="col-12 text-right my-2 mx-0 px-0">
                                                    <a class="blog-category-link font-yekan" href="'.route('app.blog',$blog->Category->slug).'">
                                                       '.$blog->Category->name.'
                                                    </a>
                                                    <span class="card-title text-right font-size-11 text-secondary fa-num mr-1">
                                                            '.jdate($blog->created_at)->format('Y.m.d').'
                                                     </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>';
        }

        echo $output;
    }


}
