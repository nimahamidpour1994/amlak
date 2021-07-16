<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $report=new Report([
            'advertisment'=>$request->advertisment,
            'mobile'=>$request->mobile,
            'message'=>$request->message,
            'category'=>$request->category,
        ]);

        try {
            $report->save();
        } catch (Exception $exception) {
            return $exception->getCode();
        }
        return 'success';
    }
}
