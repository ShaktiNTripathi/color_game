<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\HttpClientUtil;
use App\Models\Deposit;
use App\Models\User;

class PaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $user = auth()->user();
        $user_id = (string) $user->id;

        // Define your merchant ID and key
        $mch_id = '888100868'; // Replace with your actual merchant ID
        $merchant_key = '5d6af34cd11f453aa837766355d07b25'; // Replace with your actual merchant key

        // Define other request parameters
        $version = '1.0';
        $notify_url = 'https://mohammadfarmanali.com/payment/notification';
        $mch_order_no = '123F' . time();
        $pay_type = '102';
        $trade_amount = $request->get('amount');
        $order_date = now()->toDateTimeString(); // Current date and time
        $goods_name = 'Payment';
        $page_url = 'https://mohammadfarmanali.com/user/profile-setting'; // Add the page_url parameter
        $sign_type = 'MD5';
        $mch_return_msg = $user_id;

        // Construct the parameter array
        $params = [
            'version' => $version,
            'mch_id' => $mch_id,
            'notify_url' => $notify_url,
            'mch_order_no' => $mch_order_no,
            'pay_type' => $pay_type,
            'trade_amount' => $trade_amount,
            'order_date' => $order_date,
            'goods_name' => $goods_name,
            'mch_return_msg' => $mch_return_msg, // Add mch_return_msg parameter
            'page_url' => $page_url, // Add page_url parameter
            'sign_type' => $sign_type
        ];

        // Get sorted data string
        $signInfo = $this->sortData($params, $merchant_key);

        // Generate signature
        $signature = $this->sign($signInfo, $merchant_key);

        // Add signature to parameters
        $params['sign'] = $signature;

        // Make HTTP POST request using HttpClientUtil
        $url = 'https://pay.sunpayonline.xyz/pay/web'; // Update with the actual endpoint
        $response = HttpClientUtil::doPost($url, $params);

        // Parse the response JSON
        $responseData = json_decode($response, true);
       
        // Extract payInfo URL from response
        $payInfoUrl = $responseData['payInfo'];

        // Redirect to payInfo URL with page_url parameter
        return redirect()->away($payInfoUrl);
    }

    // Sort all the fields that need to be signed
    private function sortData($params, $merchant_key)
    {
        ksort($params);
        $queryString = '';
        foreach ($params as $key => $value) {
            if (!empty($value) && $key !== 'sign' && $key !== 'sign_type') {
                $queryString .= "$key=$value&";
            }
        }
        $queryString .= "key=$merchant_key";
        return $queryString;
    }

    // Sign the generated queryString string MD5 to obtain a 32-digit lowercase signature string
    private function sign($signSource, $key)
    {
        return md5($signSource);
    }

    public function handleNotification(Request $request)
    {
        // Retrieve the data directly as an associative array
        $data = $request->all();
        // Process the notification
        // Log::info('Received payment notification', ['data' => $data]);
        
        // Process the payment if it's successful
        if ($data['tradeResult'] == '1') {
            $userId = $data['merRetMsg'];
            $amount = $data['amount'];
            $trx = $data['orderNo'];
            $oriAmount = $data['oriAmount'];

            // Implement your charge calculation logic
            $charge = 0;

            // Find the user by ID
            $user = User::find($userId);

            if ($user) {
                // Add the deposit amount to the user's deposit wallet
                $user->deposit_wallet += $amount;
                $user->save();

                // Create a new deposit record
                $deposit = new Deposit();
                $deposit->user_id = $userId;
                $deposit->method_code = 111;
                $deposit->method_currency = "INR";
                $deposit->amount = $amount;
                $deposit->charge = $charge;
                $deposit->rate = 0;
                $deposit->final_amo = $oriAmount;
                $deposit->trx = $trx; // Implement your trx generation logic
                $deposit->status = 1;
                $deposit->save();

                // Handle successful deposit (e.g., send confirmation email)
            } else {
                return back()->withErrors(['message' => 'User not found!']);
            }
        } else {
            return back()->withErrors(['message' => 'Payment failed!']);
        }

        // Process the notification further...
        return response()->json(['status' => 'success']);
    }
}
