<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class LoginController extends Controller
{
    public static function sendCode($mobile)
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

    public function submit_login_ajax(Request $request)
    {
        if (Auth::guard()->attempt(['mobile' => $request->mobile, 'password' => $request->password])) {
            return 'true';
        } else {
            return 'false';
        }
    }
}
