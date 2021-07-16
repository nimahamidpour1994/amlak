<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showLoginForm()
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        return view('auth.admin.login',compact('response'));
    }

    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'mobile'   => 'required|min:11|max:11',
            'password' => 'required|min:6'
        ]);

        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['mobile' => $request->mobile, 'password' => $request->password])) {

            // if successful, then redirect to their intended location
            return redirect()->route('admin.dashboard');
        }

        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('mobile', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
