<?php

namespace App\CustomClass;

use nusoap_client;


class mellatPayment
{
    public $terminalid;
    public $username;
    public $password;
    public $amount;
    public $orderid;
    public $additionaldata;
    public $callbackurl;

    public function __construct($terminalid, $username, $password, $amount='', $orderid='', $additionaldata='', $callbackurl='')
    {
        $this->terminalid = $terminalid;
        $this->username = $username;
        $this->password = $password;
        $this->amount = $amount;
        $this->orderid = $orderid;
        $this->additionaldata = $additionaldata;
        $this->callbackurl = $callbackurl;
    }


    public function payment()
    {
        $terminalId = $this->terminalid; // Terminal ID
        $userName = $this->username; // Username
        $userPassword = $this->password; // Password
        $orderId = $this->orderid; // Order ID
        $amount = $this->amount; // Price / Rial
        $localDate = date('Ymd'); // Date
        $localTime = date('Gis'); // Time
        $additionalData = $this->additionaldata;
        $callBackUrl = $this->callbackurl; // Callback URL
        $payerId = 0;
        
        //-- تبدیل اطلاعات به آرایه برای ارسال به بانک
        $parameters = array(
         'terminalId' => $terminalId,
         'userName' => $userName,
         'userPassword' => $userPassword,
         'orderId' => $orderId,
         'amount' => $amount,
         'localDate' => $localDate,
         'localTime' => $localTime,
         'additionalData' => $additionalData,
         'callBackUrl' => $callBackUrl,
         'payerId' => $payerId);
         
        $client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
        $namespace='http://interfaces.core.sw.bps.com/';
        $result = $client->call('bpPayRequest', $parameters, $namespace);
        if ($client->fault) {
            echo "اتصال به درگاه بانکی دارای اشکال است لطفا مجدد تلاش نمایید";
            exit;
        } else {
            $err = $client->getError();
            if ($err) {
                echo "خطایی ایجاد شد : ". $err;
                exit;
            } else {
                $res = explode(',', $result);
                $ResCode = $res[0] ;
                if ($ResCode == "0") {
                    $wsaddr = 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat';   
                    ?>

                <form name="paymentform" id="paymentform" method="post" action="<?php echo $wsaddr; ?>">
                <input type="hidden" name="TerminalId" value="<?php echo $terminalId; ?>">
                <input type="hidden" name="UserName" value="<?php echo $userName; ?>">
                <input type="hidden" name="UserPassword" value="<?php echo $userPassword; ?>">
                <input type="hidden" name="PayDate" id="PayDate" value="<?php echo $localDate; ?>">
                <input type="hidden" name="PayTime" id="PayTime" value="<?php echo $localTime; ?>">
                <input type="hidden" name="PayAmount" id="PayAmount" value="<?php echo $amount; ?>">
                <input type="hidden" name="PayOrderId" id="PayOrderId" value="<?php echo $orderId; ?>">
                <input type="hidden" name="PayAdditionalData" id="PayAdditionalData" value="<?php echo $additionalData; ?>">
                <input type="hidden" name="PayCallBackUrl" id="PayCallBackUrl" value="<?php echo $callBackUrl; ?>">
                <input type="hidden" name="PayPayerId" id="PayPayerId" value="<?php echo $payerId; ?>">
                <input type="hidden" name="RefId" id="RefId" value="<?php echo $res[1]; ?>">

                </form>        

                <br>
                <script type="text/javascript">document.getElementById('paymentform').submit();</script>

                    <?php
                } else {
                    echo "خطا : ".$this->CheckStatus($result);
                    exit;
                }
            }
        }
    }

    public function verify()
    {
        if ($_POST['ResCode'] == '0') {
            //--پرداخت در بانک باموفقیت بوده
            include_once('lib/nusoap.php');
            $client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
            $namespace='http://interfaces.core.sw.bps.com/';
            
            $terminalId = $this->terminalid; // Terminal ID
            $userName = $this->username; // Username
            $userPassword = $this->password; // Password
            $orderId = $_POST['SaleOrderId']; // Order ID
            
            $verifySaleOrderId = $_POST['SaleOrderId'];
            $verifySaleReferenceId = $_POST['SaleReferenceId'];
            
            $parameters = array(
            'terminalId' => $terminalId,
            'userName' => $userName,
            'userPassword' => $userPassword,
            'orderId' => $orderId,
            'saleOrderId' => $verifySaleOrderId,
            'saleReferenceId' => $verifySaleReferenceId);
            // Call the SOAP method
            $result = $client->call('bpVerifyRequest', $parameters, $namespace);
            if ($result == '0') {
                //-- وریفای به درستی انجام شد٬ درخواست واریز وجه
                // Call the SOAP method
                $result = $client->call('bpSettleRequest', $parameters, $namespace);
                if ($result == '0') {
                    //-- تمام مراحل پرداخت به درستی انجام شد.
                    //-- آماده کردن خروجی
                    // تمام تغییرات مورد نیاز در جدول دیتابیس خود را در این قسمت انجام دهید
                    echo 'پرداخت شما با موفقیت انجام شد . رسید پرداخت شما:'.$verifySaleReferenceId.'شماره فاکتور شما جهت پیگیری های بعدی:'.$orderId;
                  return true;
                } else {
                    //-- در درخواست واریز وجه مشکل به وجود آمد. درخواست بازگشت وجه داده شود.
                    $client->call('bpReversalRequest', $parameters, $namespace);
                    echo 'Error : '. $this->CheckStatus($result);
                }
            } else {
                //-- وریفای به مشکل خورد٬ نمایش پیغام خطا و بازگشت زدن مبلغ
                $client->call('bpReversalRequest', $parameters, $namespace);
                echo 'Error : '. $this->CheckStatus($result);
            }
        } else {
            //-- پرداخت با خطا همراه بوده
            echo 'خطایی رخ داده است : '.$this->CheckStatus($_POST['ResCode']) ;
        }
    }




    public function CheckStatus($ecode)
    {
                       $tmess="شرح خطا:";
                       switch ($ecode) 
                         {
                          case 0:
                            $tmess="تراکنش با موفقيت انجام شد";
                            break;
                          case 11:
                            $tmess="شماره کارت معتبر نيست";
                            break;
                          case 12:
                            $tmess= "موجودي کافي نيست";
                            break;
                          case 13:
                            $tmess= "رمز دوم شما صحيح نيست";
                            break;
                          case 14:
                            $tmess= "دفعات مجاز ورود رمز بيش از حد است";
                            break;
                          case 15:
                            $tmess= "کارت معتبر نيست";
                            break;
                          case 16:
                            $tmess= "دفعات برداشت وجه بيش از حد مجاز است";
                            break;
                          case 17:
                            $tmess= "کاربر از انجام تراکنش منصرف شده است";
                            break;
                          case 18:
                            $tmess= "تاريخ انقضاي کارت گذشته است";
                            break;
                          case 19:
                            $tmess= "مبلغ برداشت وجه بيش از حد مجاز است";
                            break;
                          case 111:
                            $tmess= "صادر کننده کارت نامعتبر است";
                            break;
                          case 112:
                            $tmess= "خطاي سوييچ صادر کننده کارت";
                            break;
                          case 113:
                            $tmess= "پاسخي از صادر کننده کارت دريافت نشد";
                            break;
                          case 114:
                            $tmess= "دارنده کارت مجاز به انجام اين تراکنش نمي باشد";
                            break;
                          case 21:
                            $tmess= "پذيرنده معتبر نيست";
                            break;
                          case 23:
                            $tmess= "خطاي امنيتي رخ داده است";
                            break;
                          case 24:
                            $tmess= "اطلاعات کاربري پذيرنده معتبر نيست";
                            break;
                          case 25:
                            $tmess= "مبلغ نامعتبر است";
                            break;
                          case 31:
                            $tmess= "پاسخ نامعتبر است";
                            break;
                          case 32:
                            $tmess= "فرمت اطلاعات وارد شده صحيح نيست";
                            break;
                          case 33:
                            $tmess="حساب نامعتبر است";
                            break;
                          case 34:
                            $tmess= "خطاي سيستمي";
                            break;
                          case 35:
                            $tmess= "تاريخ نامعتبر است";
                            break;
                          case 41:
                            $tmess= "شماره درخواست تکراري است";
                            break;
                          case 42:
                            $tmess= "تراکنش Sale يافت نشد";
                            break;
                          case 43:
                            $tmess= "قبلا درخواست Verify داده شده است";
                            break;
                          case 44:
                            $tmess= "درخواست Verify يافت نشد";
                            break;
                          case 45:
                            $tmess= "تراکنش Settle شده است";
                            break;
                          case 46:
                            $tmess= "تراکنش Settle نشده است";
                            break;
                          case 47:
                            $tmess= "تراکنش Settle يافت نشد";
                            break;
                          case 48:
                            $tmess= "تراکنش Reverse شده است";
                            break;
                          case 49:
                            $tmess= "تراکنش Refund يافت نشد";
                            break;
                          case 412:
                            $tmess= "شناسه قبض نادرست است";
                            break;
                          case 413:
                            $tmess= "شناسه پرداخت نادرست است";
                            break;
                          case 414:
                            $tmess= "سازمان صادر کننده قبض معتبر نيست";
                            break;
                          case 415:
                            $tmess= "زمان جلسه کاري به پايان رسيده است";
                            break;
                          case 416:
                            $tmess= "خطا در ثبت اطلاعات";
                            break;
                          case 417:
                            $tmess= "شناسه پرداخت کننده نامعتبر است";
                            break;
                          case 418:
                            $tmess= "اشکال در تعريف اطلاعات مشتري";
                            break;
                          case 419:
                            $tmess= "تعداد دفعات ورود اطلاعات بيش از حد مجاز است";
                            break;
                          case 421:
                            $tmess= "IP معتبر نيست";
                            break;
                          case 51:
                            $tmess= "تراکنش تکراري است";
                            break;
                          case 54:
                            $tmess= "تراکنش مرجع موجود نيست";
                            break;
                          case 55:
                            $tmess= "تراکنش نامعتبر است";
                            break;
                          case 61:
                            $tmess= "خطا در واريز";
                            break;
                         }    
    
                            return $tmess;
    }




}
