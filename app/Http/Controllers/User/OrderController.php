<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pay;
use App\Models\Plan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Invoice;

use App\CustomClass\mellatPayment;


class OrderController extends Controller
{
    public function create($slug)
    {
        $response=[];
        $response['app_name']=optional(Setting::firstWhere('key','app_name'))->value;
        $response['app_logo']=optional(Setting::firstWhere('key','app_logo'))->value;
        $response['app_description']=optional(Setting::firstWhere('key','app_description'))->value;

        $response['advertisment']=Advertisment::firstWhere('slug',$slug);

        $response['expire_day']=optional(Plan::firstWhere('key','extension'))->expire;
        if ($response['expire_day'] === null)
            $response['expire_day']=30;


        $response['plans']=Plan::orderBy('id','ASC')->get();
        return view('user.advertisment.plan',compact('response'));

    }

    public function store(Request $request,$slug)
    {
        $response=[];
        $response['price_all']=0;
        $i=0;
        $response['advertisment']=Advertisment::firstWhere('slug',$slug);

        // GET DATA WHICH PLAN ORDER
        if (isset($request->ladder) && $request->ladder !=='')
        {
            $response['price_all']+=optional(Plan::firstWhere('key','ladder'))->price;
            $response['orders'][$i++]='ladder';
        }
        if (isset($request->urgent) && $request->urgent !=='')
        {
            $response['price_all']+=optional(Plan::firstWhere('key','urgent'))->price;
            $response['orders'][$i++]='urgent';
        }
        if (isset($request->extension) && $request->extension !=='')
        {
            $response['price_all']+=optional(Plan::firstWhere('key','extension'))->price;
            $response['orders'][$i++]='extension';
        }

        // STORE ORDER INFO
        $order=new Order([
            'advertisment'=>$response['advertisment']->id,
            'price'=> $response['price_all'],
            'discount'=>0,
            'pay'=>'unpaid',
        ]);

        try {
            $order->save();
            $order_id=$order->id;
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('warning'.$exception->getCode());
        }

        // STORE ORDER DETAIL
        foreach ($response['orders'] as $order)
        {
            $price=optional(Plan::firstWhere('key',$order))->price;

            if ($price !== null)
            {
                $order_detail=new OrderDetail([
                    'advertisment'=>$response['advertisment']->id,
                    'order'=>$order_id,
                    'plan'=>$order,
                    'price'=>$price,
                    'pay'=>'unpaid',
                ]);
                $order_detail->save();
            }
        }

        // ZARINPAL PAYMENT
        $invoice = new Invoice;
        $invoice->amount($response['price_all']);
        $invoice->detail('order',$order_id);
        $invoice->detail('price',$response['price_all']);
        Payment::purchase($invoice,function($driver, $transactionId) {});

        // SAVE PAYMENT DETAIL IN MYSQL
        $pay=new Pay([
            "order"=>$order_id,
            "price"=>$response['price_all'],
            "authority"=>$invoice->getTransactionId(),
        ]);
        $pay->save();
        return Payment::pay()->render();
        
        
        
        //  $terminalid='5396677';
        //  $username='amlakesfahan1399';
        //  $password='87152217';
        //  $amount=2000;
        //  $orderid=$order_id;
        //  $additionaldata='پرداخت برای خرید کیبرد';
        //  $callbackurl='http://amlakesfahan.com/user/advertisment/pay';
        //  $mellatPayment = new mellatPayment( $terminalid,$username,$password, $amount, $orderid, $additionaldata,$callbackurl);
        //  $mellatPayment->payment();


    }
}
