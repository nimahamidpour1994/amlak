<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Models\Chat;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
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

        $response['chats']=Chat::where('receiver',Auth::user()->mobile)->orWhere('sender',Auth::user()->mobile)
                            ->orderBy('id','DESC')->get()
                            ->groupBy('tracking_code');

        return view('user.chat.list',compact('response'));
    }

    public function create(Advertisment $advertisment)
    {

        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['advertisment_id']=$advertisment->id;
        $response['other_side']=$advertisment->mobile;
        $response['advertisment_name']=$advertisment->name;

        $response['chats']=Chat::where([['receiver',Auth::user()->mobile],['advertisment',$advertisment->id],
                            ['sender', $response['other_side']]])->orWhere([['receiver', $response['other_side']],
                            ['advertisment',$advertisment->id],['sender',Auth::user()->mobile]])
                            ->orderBy('id','ASC')->get();

        foreach ($response['chats'] as $chat)
        {
            if ($chat->receiver === Auth::user()->mobile)
            {
                $chat->read = 'read';
                $chat->save();
            }
        }
        return view('user.chat.reply',compact('response'));

    }

    public function show($id)
    {
        $chat=Chat::firstWhere('id',$id);

        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        if ($chat->sender === Auth::user()->mobile)
            $response['other_side']=$chat->receiver;
        else
            $response['other_side']=$chat->sender;

        $response['advertisment_name']=$chat->Advertisment->name;
        $response['advertisment_id']=$chat->advertisment;

        $response['chats']=Chat::where([['receiver',Auth::user()->mobile],['advertisment',$chat->advertisment],['sender', $response['other_side']]])
                            ->orWhere([['receiver', $response['other_side']],['advertisment',$chat->advertisment],['sender',Auth::user()->mobile]])
            ->orderBy('id','ASC')->get();


        foreach ($response['chats'] as $chat)
        {
            if ($chat->receiver === Auth::user()->mobile)
            {
                $chat->read = 'read';
                $chat->save();
            }
        }
        return view('user.chat.reply',compact('response'));
    }

    public function reply(Request $request)
    {
            $request->validate([
               'message'=>'required|min:10'
            ]);

            if ($request->other_side !='' && $request->parent !='') {
                $tracking_code = optional(Chat::where([['advertisment', $request->parent], ['sender', Auth::user()->mobile],['receiver',$request->other_side], ['is_start', 'true']])
                                    ->orwhere([['advertisment', $request->parent], ['receiver', Auth::user()->mobile],['sender',$request->other_side], ['is_start', 'true']])->first())->tracking_code;

                if ($tracking_code !== null)
                {
                    $is_start='false';
                }
                else
                {
                    $is_start='true';
                    $tracking_code=time();
                }

                $reply=new Chat([
                   'sender'=>Auth::user()->mobile,
                   'receiver'=>$request->other_side,
                   'message'=>$request->message,
                   'read'=>'unread',
                   'is_start'=>$is_start,
                   'tracking_code'=>$tracking_code,
                   'advertisment'=>$request->parent,
                ]);

                try {
                    $reply->save();
                }
                catch (Exception $exception)
                {
                    return redirect()->back()->with('warning',$exception->getCode());
                }
                return redirect()->back()->with('success','پیام با موفقیت ارسال شد');
            }
            return redirect()->back();

    }
}
