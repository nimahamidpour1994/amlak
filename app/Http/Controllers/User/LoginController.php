<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class LoginController extends Controller
{
    public function submit_login(Request $request)
    {
        // **** validate phone number *****
        $request->validate(['mobile' => 'required|regex:/(09)[0-9]{9}/']);
        // **** validate phone number *****

        $response=[];

        $response['mobile'] = $request->mobile;

        \App\Http\Controllers\Api\LoginController::sendCode($response['mobile']);

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        return view('auth.user.checkCode', compact('response'));


    }
}
