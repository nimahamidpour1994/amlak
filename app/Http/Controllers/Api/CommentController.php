<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function like(Request $request)
    {
        $response=[];
        $comment=Comment::firstWhere('id',$request->comment);

        $comment->like++;

        if ($comment->save())
        {
            $response['msg']='success';
            $response['count']= $comment->like;
        }
        else
        {
            $response['msg']='faild';
        }

        return json_encode($response);
    }

    public function dislike(Request $request)
    {
        $response=[];
        $comment=Comment::firstWhere('id',$request->comment);

        $comment->dislike++;

        if ($comment->save())
        {
            $response['msg']='success';
            $response['count']= $comment->dislike;
        }
        else
        {
            $response['msg']='faild';
        }

        return json_encode($response);
    }
}
