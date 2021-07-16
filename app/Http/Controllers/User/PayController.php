<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Models\ListenBell;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;

class PayController extends Controller
{

    public function callBackBank(Request $request){
        
        
              if (isset($request->RefId))
        {

            try
            {
                // UPDATE PAYMENT INFO IN MYSQL
                $pay=Pay::firstWhere('authority',$request->RefId);
                $receipt = Payment::amount($pay->price)->transactionId($pay->authority)->verify();
                $pay->refid=$receipt->getReferenceId();
                if ($pay->save())
                {
                    // UPDATE ORDER INFO IN MYSQL
                    $order=Order::firstWhere('id',$pay->order);
                    $order->pay='paid';

                    if ($order->save())
                    {
                        $order_details=OrderDetail::where('order',$pay->order)->get();

                        foreach ($order_details as $order_detail)
                        {

                            // nardeban agahi
                            if ($order_detail->plan === 'ladder')
                            {
                                $advertisment=Advertisment::firstWhere('id',$order_detail->advertisment);
                                $advertisment->updated_at=Carbon::now();
                                $advertisment->save();
                            }

                            // tamdid agahi
                            if ($order_detail->plan === 'extension')
                            {
                                $advertisment=Advertisment::firstWhere('id',$order_detail->advertisment);
                                $advertisment->created_at=Carbon::now();
                                $advertisment->updated_at=Carbon::now();
                                $advertisment->save();
                            }

                            // goosh be zang
                            if($order_detail->plan === 'listen_bell')
                            {
                               $listenbells=session()->get('listenbellsid');

                               if ($listenbells !== '' && count($listenbells) > 0)
                               {
                                   foreach ($listenbells as $listenbell)
                                   {
                                        $mobile=optional(ListenBell::firstWhere('id',$listenbell))->mobile;
                                        Smsirlaravel::send('اگهی جدیدی برای گوش به زنگ شما ثبت گردید',$mobile);

                                   }
                               }
                            }

                            $order_detail->pay='paid';
                            $order_detail->save();
                        }
                    }

                    return redirect()->route('user.dashboard');
                }


            }
            catch (InvalidPaymentException $exception)
            {
                echo $exception->getMessage();
            }
        }
    }
}
