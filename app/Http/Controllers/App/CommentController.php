<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'comment'=>'required',
        ]);

        $comment=new Comment([
            'name'=>$request->name,
            'email'=>$request->email,
            'content'=>$request->comment,
            'model'=>'Page',
            'model_id'=>$request->blog_id,
            'writer'=>'User',
            'publish'=>'waiting',
        ]);

        try
        {
            $comment->save();
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning',$exception->getCode());
        }

        return redirect()->back();

    }
}
