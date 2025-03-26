<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayhereController extends Controller
{
    public function payhere()
    {
        $merchant_id = '1229854';
        $return_url = route('payhere.success');
        $cancel_url = route('payhere.cancel');
        $notify_url = route('payhere.notify');
        $order_id = uniqid();
        $amount = 1000;
        $currency = 'LKR';
        $merchant_secret = 'MTc0MTYyODQ1NzYyMDIyNTA3NTM1MTIxNDIyMTAzNTE1MTQ0MTA1';
        $hash = strtoupper(
            md5(
                $merchant_id .
                    $order_id .
                    number_format($amount, 2, '.', '') .
                    $currency .
                    strtoupper(md5($merchant_secret)),
            ),
        );
        $data = [
            'merchant_id' => $merchant_id,
            'return_url' => $return_url,
            'cancel_url' => $cancel_url,
            'notify_url' => $notify_url,
            'order_id' => $order_id,
            'items' => 'Test Item',
            'amount' => number_format($amount, 2, '.', ''),
            'currency' => $currency,
            'hash' => $hash,
        ];
        return view('payhere', [
            'data' => $data,
        ]);
    }

    public function success(Request $request)
    {
        return $request->all();
    }

    public function cancel(Request $request)
    {
        return $request->all();
    }

    public function notify(Request $request)
    {
        return $request->all();
    }
}
