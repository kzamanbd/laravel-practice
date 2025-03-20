@php
    $merchant_id = '1229854';
    $return_url = url('payhere/return');
    $cancel_url = url('payhere/cancel');
    $notify_url = url('payhere/notify');
    $order_id = 'ItemNo12345';
    $amount = 1000;
    $currency = 'LKR';
    $merchant_secret = 'MTcyNTkxNzM4NDM5MjM3OTM0NjEzODU4MjMyMDk1NTg4MDkxMw';
    $hash = strtoupper(
        md5(
            $merchant_id .
                $order_id .
                number_format($amount, 2, '.', '') .
                $currency .
                strtoupper(md5($merchant_secret)),
        ),
    );
@endphp

<html>

<body>
    <form method="post" action="https://sandbox.payhere.lk/pay/checkout">
        <input type="hidden" name="merchant_id" value="{{ $merchant_id }}"> <!-- Replace your Merchant ID -->
        <input type="hidden" name="return_url" value="{{ $return_url }}">
        <input type="hidden" name="cancel_url" value="{{ $cancel_url }}">
        <input type="hidden" name="notify_url" value="{{ $notify_url }}">
        </br></br>Item Details</br>
        <input type="text" name="order_id" value="{{ $order_id }}">
        <input type="text" name="items" value="Door bell wireless">
        <input type="text" name="currency" value="{{ $currency }}">
        <input type="text" name="amount" value="{{ $amount }}">
        </br></br>Customer Details</br>
        <input type="text" name="first_name" value="Saman">
        <input type="text" name="last_name" value="Perera">
        <input type="text" name="email" value="samanp@gmail.com">
        <input type="text" name="phone" value="0771234567">
        <input type="text" name="address" value="No.1, Galle Road">
        <input type="text" name="city" value="Colombo">
        <input type="hidden" name="country" value="Sri Lanka">
        <input type="hidden" name="hash" value="{{ $hash }}">
        <!-- Replace with generated hash -->
        <input type="submit" value="Buy Now">
    </form>
</body>

</html>
