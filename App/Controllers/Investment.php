<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Investment as ModelsInvestment;
use App\Models\Package;
use App\Models\User;
use App\Models\Wallet;
use App\Controllers\Mail;
use App\Models\Profile;
use App\Controllers\CoinPaymentsAPI;
use App\Core\Response;
use App\Models\Payment;
use App\Models\PaymentMethod;

class Investment extends Controller
{
    public $coinpayment;
    public $coinpaymentusername;

    public function __construct()
    {
        $this->coinpayment = new CoinPaymentsAPI();
        $this->coinpayment->Setup("6152d408BAEC3dd949748514F9D3A9378C25f25AED0Abb96fa8105345aE49523", "7bc7e4ed54f7bfbc49abffd4814b3cb0fbc812b4827090de136c5cdcbe23219f");
        $basicinfo = $this->coinpayment->GetBasicProfile();

        $this->coinpaymentusername = $basicinfo['result']['public_name'];
    }

    public function active()
    {
        $investment = ModelsInvestment::findMultiple(ModelsInvestment::$table, "is_paid = 1 AND is_active = 1");
        return $this->view('active_investments', ['admin' => $investment]);
    }

    public function pending()
    {
        $investment = ModelsInvestment::findMultiple(ModelsInvestment::$table, "is_paid = 0 AND is_active = 0");
        return $this->view('pending_investments', ['admin' => $investment]);
    }

    public function completed()
    {
        $investment = ModelsInvestment::findMultiple(ModelsInvestment::$table, "is_paid = 1 AND is_active = 0 AND is_completed = 1");
        return $this->view('completed_investments', ['admin' => $investment]);
    }

    public function addInvestment()
    {
        $userid = User::userid($_SESSION['email']);
        $package = $_POST['package'];
        $amount = $_POST['amount'];
        $coin = $_POST['coin'];

        $interest = Package::package($package)[0]['interest'];
        $period = Package::package($package)[0]['period'];

        $expected = $amount + ($amount * $interest * $period);

        $expire = time() + (60 * 60 * 24 * $period);

        $values = [
        'user_id' => $userid,
        'package_id' => $package,
        'amount' => $amount,
        'payment_method_id' => $coin,
        'period' => $expire,
        'accumulated_amount' => 0,
        'expected_amount' => $expected,
        'is_active' => 0,
        'is_paid' => 0,
        'is_completed' => 0,
        'is_withdrawn_to_wallet' => 0,
        'date_updated' => date('Y-m-d')
        ];

        $name = Profile::find(Profile::$table, 'user_id', $userid)[0]['firstname'];
        $packagename = Package::package($package)[0]['package_name'];
        $mailamount = '$'.number_format($amount);

        $mail = new Mail;
        $mail->receiver = $_SESSION['email'];
        $mail->subject = "Pending Investment";
        $template = $mail->template();
        $mail->body = $mail->inject($template, APP_NAME, "You Requested An Investment", $name, "You requested an invesment of <b>$mailamount</b> under our $packagename plan <br>, Please Make the deposit to start earning");
        $mail->sendemail();

        return ModelsInvestment::insert(ModelsInvestment::$table, $values);
    }

    public function pay()
    {
        $id = $_POST['inv_id'];

        return ModelsInvestment::update(ModelsInvestment::$table, "is_paid = 1", 'id', $id);
    }

    public function paid()
    {
        //
    }

    public function activate()
    {
        $inv_id = $_POST['inv_id'];
        $txn_id = $_POST['txn_id'];

        $investment = ModelsInvestment::find(ModelsInvestment::$table, 'id', $inv_id);
        $time = Package::package($investment[0]['package_id'])[0]['period'];
        $period = time() + (60 * 60 * 24 * $time);

        $email = User::find(User::$table, 'id', $investment[0]['user_id'])[0]['email'];
        $amount = '$'.number_format($investment[0]['amount']);
        $name = Profile::find(Profile::$table, 'user_id', $investment[0]['user_id'])[0]['firstname'];

        $mail = new Mail;
        $mail->receiver = $email;
        $mail->subject = "Payment Confirmed";
        $template = $mail->template();
        $mail->body = $mail->inject($template, APP_NAME, 'PAYMENT CONFIRMATION', $name, "your payment of <b>$amount</b> worth of coin has been confirmed");
        $mail->sendemail();
        
        Payment::update(Payment::$table, "status = 'success' ", 'gateway_id', $txn_id);
        return ModelsInvestment::update(ModelsInvestment::$table, "is_paid = 1, is_active = 1, period = '$period' ", 'id', $inv_id);
    }

    public function currentIV()
    {
        $current = ModelsInvestment::current()[0];
        // return json_encode($current);
        return $current;
    }

    public function withdrawtowallet()
    {
        $invid = $_POST['inv_id'];
        ModelsInvestment::update(ModelsInvestment::$table, "is_withdrawn_to_wallet = 1", 'id', $invid);
        $investment = ModelsInvestment::findSingle(ModelsInvestment::$table, 'id', $invid);
        
        $userid = User::userid($_SESSION['email']);
        $wallet = Wallet::exists(Wallet::$table, 'user_id', $userid);
        
        if ($wallet) {
            $new_balance = $wallet[0]['balance'] + $investment[0]['expected_amount'];
            return Wallet::update(Wallet::$table, "balance = $new_balance", 'user_id', $userid);
        }

        return Wallet::insert(Wallet::$table, [
            'user_id' => $userid,
            'balance' => $investment[0]['expected_amount'],
            'withdrawable' => 0
        ]);
    }

    public function accu()
    {
        var_dump($_POST['accu']);
    }

    public function deposit($params)
    {
        $inv_id = $params[0];

        $is_initialized = Payment::exists(Payment::$table, 'inv_id', $inv_id);
        $error_status = Payment::findSingle(Payment::$table, 'inv_id', $inv_id)[0]['status'];

        if (!$is_initialized || $error_status === 'error') {
            $scurrency = "USD";
            $investment = ModelsInvestment::find(ModelsInvestment::$table, 'id', $inv_id);
            $amount = $investment[0]['amount'];
            $coin = PaymentMethod::find(PaymentMethod::$table, 'id', $investment[0]['payment_method_id'])[0]['method'];
            
            
            if ($coin === 'Bitcoin') {
                $rcurrency = "BTC";
            } elseif ($coin === 'Etherium') {
                $rcurrency = "ETH";
            }
            
    
            $request = [
                'amount' => $amount,
                'currency1' => $scurrency,
                'currency2' => $rcurrency,
                'buyer_email' => $_SESSION['email'],
                'item' => $inv_id,
                'address' => "",
                'ipn_url' => "https://xinotex.com/investment/webhook"
            ];
    
            $result = $this->coinpayment->CreateTransaction($request);
            
            if ($result['error'] === 'ok') {
                Payment::insert(Payment::$table, [
                    'inv_id' => $inv_id,
                    'entered_amount' => $amount,
                    'amount' => $result['result']['amount'],
                    'from_currency' => $scurrency,
                    'to_currency' => $rcurrency,
                    'status' => 'initialized',
                    'gateway_id' => $result['result']['txn_id'],
                    'gateway_url' => $result['result']['status_url']
                ]);
                
                return Response::redirect(PAYMENT_PAGE.'/'.$inv_id);
            } else {
                return 'Error : '.$result['error']."\n";
            }
        } else {
            return Response::redirect(PAYMENT_PAGE.'/'.$inv_id);
        }
    }

    public function user($id)
    {
        $userid = $id[0];
        $investments = ModelsInvestment::investments($userid);
        $useremail = User::findSingle(User::$table, 'id', $userid)[0]['email'];
        return $this->view('users_investments', ['email' => $useremail, 'investments' => $investments]);
    }

    public function payment($params)
    {
        $inv_id = $params[0];
        $payments = Payment::findMultiple(Payment::$table, "inv_id = '$inv_id' ORDER BY id DESC LIMIT 1 ");
        return $this->view('payment_page', $payments);
    }

    public function webhook()
    {
        $merchant_id = "456270b2f9257634bd03fb1b8d75aa67";
        $ipn_secret = '!@#$%Odogwu';
        $debug_email = "maxgomery931@gmail.com";
        $txn_id = $_POST['txn_id'];
        
        $payments = Payment::findSingle(Payment::$table, 'gateway_id', $txn_id);
        $order_currency = $payments[0]['to_currency']; //COIN
        $order_total = $payments[0]['amount']; //COIN

        if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
            self::edie($debug_email, "IPN Mode is not HMAC");
        }

        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
            self::edie($debug_email, "No HMAC signature sent");
        }

        $request = file_get_contents('php://input');
        
        if ($request === false || empty($request)) {
            self::edie($debug_email, "Error in reading Post Data");
        }

        if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($merchant_id)) {
            self::edie($debug_email, "No or incorrect merchant id");
        }

        $hmac = hash_hmac("sha512", $request, trim($ipn_secret));
        if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
            self::edie($debug_email, "HMAC Signature does not match");
        }

        $amount1 = floatval($_POST['amount1']); //IN USD
        $amount2 = floatval($_POST['amount2']); //IN COIN
        $currency1 = $_POST['currency1']; //USD
        $currency2 = $_POST['currency2']; //COIN
        $status = intval($_POST['status']);

        if ($currency2 != $order_currency) {
            self::edie($debug_email, "currency mismatch");
        }

        if ($amount2 < $order_total) {
            self::edie($debug_email, "Amount is lesser than order total");
        }

        if ($status >= 100 || $status == 2) {
            // payment is complete

            $status = Payment::findSingle(Payment::$table, 'gateway_id', $txn_id)[0]['status'];

            if ($status !== 'success') {
                Payment::update(Payment::$table, "status = 'success'", 'gateway_id', $txn_id);
                $package_id = ModelsInvestment::findSingle(ModelsInvestment::$table, 'id', $payments[0]['inv_id'])[0]['package_id'];
                $period = Package::findSingle(Package::$table, 'id', $package_id)[0]['period'];
                $expire = time() + (60 * 60 * 24 * $period);
                ModelsInvestment::update(ModelsInvestment::$table, "period = '$expire', is_paid = 1, is_active = 1", 'id', $payments[0]['inv_id']);

                $user_id = ModelsInvestment::find(ModelsInvestment::$table, "id", $payments[0]['inv_id'])[0]['user_id'];
                $email = User::find(User::$table, "id", $user_id)[0]['email'];
                $name = Profile::find(Profile::$table, "user_id", $user_id)[0]['firstname'];
                $amount = '$'.$payments[0]['entered_amount'];

                $mail = new Mail;
                $mail->receiver = $email;
                $mail->subject = "Payment Confirmed";
                $template = $mail->template();
                $mail->body = $mail->inject($template, APP_NAME, 'PAYMENT CONFIRMATION', $name, "your payment of <b>$amount</b> worth of coin has been confirmed");
                $mail->sendemail();
            }
        } elseif ($status < 0) {
            Payment::update(Payment::$table, "status = 'error'", 'gateway_id', $txn_id);
        } else {
            Payment::update(Payment::$table, "status = 'pending'", 'gateway_id', $txn_id);
        }
        
        die("IPN OK");
    }

    public static function edie($debug_email, $error_msg)
    {
        
        $report = "Error : ".$error_msg."\n\n";
        $report .= "POST DATA \n\n";
        foreach ($_POST as $key => $value) {
            $report .= "|$key| = |$value| \n";
        }

        $mail = new Mail();
        $mail->subject = "Payment Error";
        $mail->receiver = $debug_email;
        $template = $mail->template();
        $mail->body = $report;
        $mail->inject($template, APP_NAME, "PAYMENT ERROR", $debug_email, $mail->body);
        $mail->sendemail();
        die($error_msg);
    }
}
