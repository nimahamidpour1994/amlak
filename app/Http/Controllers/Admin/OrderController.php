<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Setting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($pay)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        if ($pay === 'paid')
        {
            $response['page_title']='سفارشات پرداخت شده';
            $response['orders']=Order::where('pay','paid')->orderBy('id','DESC')->paginate(20);
        }
        else
        {
            $response['page_title']='سفارشات پرداخت نشده';
            $response['orders']=Order::where('pay','unpaid')->orderBy('id','DESC')->paginate(20);
        }

        return view('back.page.order.list',compact('response'));
    }

    public function show(Order $order)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;

        $response['page_title']= 'جزئیات سفارش آگهی : '.optional($order->Advertisment)->name .' - '.$order->advertisment;

        $response['order_detail']=OrderDetail::where('order',$order->id)->get();

        return view('back.page.order.detail',compact('response'));
    }
}
