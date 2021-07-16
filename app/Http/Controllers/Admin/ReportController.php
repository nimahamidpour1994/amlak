<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Setting;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // show user reports
    public function index()
    {
        $response=[];

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']='لیست آگهی های گزارش شده';

        $response['reports']=Report::orderBy('read','ASC')->paginate(15);


        return view('back.page.report.list',compact('response'));
    }

    public function edit(Report $report)
    {
        $response=[];

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']='گزارش مشکل آگهی : '.$report->Advertisment->name .' - '. $report->Advertisment->mobile;

        $response['report']=$report;


        $report->read='read';
        $report->save();
        return view('back.page.report.edit',compact('response'));
    }

    public function update(Request $request,Report $report)
    {
        $request->validate([
           'result'=>'required',
        ]);

        $report->result=$request->result;

        try {
            $report->save();
        }
        catch (Exception $exception) {
            return redirect()->back()->with('warning',$exception->getCode());
        }
        return redirect()->back()->with('success','ویرایش با موفقیت انجام شد');
    }

    // for create,store and destroy category of reports
    public function create()
    {
        $response=[];

        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']='لیست دسته های گزارش مشکل آگهی';

        $response['reports']=Setting::where('key','report')->orderBy('id','ASC')->get();

        return view('back.page.report.add',compact('response'));
    }

    public function store(Request $request)
    {
        $report=new Setting([
            'key'=>'report',
            'value'=>$request->name,
            'unique'=>$request->name,
        ]);

        try {
            $report->save();
        }
        catch (Exception $exception) {
            return redirect()->back()->with('warning',$exception->getCode());
        }

        return redirect()->back()->with('success','دسته جدید با موفقیت اضافه گردید');
    }

    public function destroy($id)
    {
        $report=Setting::firstWhere('id',$id);
        try {
            $report->delete();
        }
        catch (Exception $exception) {
            return redirect()->back()->with('warning',$exception->getCode());
        }

        return redirect()->back();
    }

}
