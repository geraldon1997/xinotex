<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Models\Wallet as ModelsWallet;
use App\Models\Withdrawal;

class Wallet extends Controller
{
    public function all()
    {
        $wallets = [];
        $wallet = ModelsWallet::all(ModelsWallet::$table);
        foreach ($wallet as $key) {
            $user = User::find(User::$table, 'id', $key['user_id'])[0];
            array_push($wallets, ['wallets' => $key, 'user' => $user]);
        }

        return $this->view('wallet', ['admin' => $wallets]);
    }

    public function updateaddress()
    {
        $userid = User::userid($_SESSION['email']);
        $wallet = ModelsWallet::exists(ModelsWallet::$table, 'user_id', $userid);
        $address = $_POST['wa'];

        if ($wallet) {
            return ModelsWallet::update(ModelsWallet::$table, "wallet_address = '$address', withdrawable = 1 ", 'user_id', $userid);
        }

        return ModelsWallet::insert(ModelsWallet::$table, [
            'user_id' => $userid,
            'wallet_address' => $address,
            'withdrawable' => 1
            ]);
    }

    public function withdraw()
    {
        $userid = User::userid($_SESSION['email']);
        $amount = $_POST['amount'];

        $wallet = ModelsWallet::findSingle(ModelsWallet::$table, 'user_id', $userid);
        $previous_balance = $wallet[0]['balance'];
        $new_balance = $previous_balance - $amount;

        ModelsWallet::update(ModelsWallet::$table, "balance = '$new_balance' ", 'user_id', $userid);

        $name = Profile::find(Profile::$table, 'user_id', $userid)[0]['firstname'];

        $mail = new Mail;
        $mail->receiver = $_SESSION['email'];
        $mail->subject = "WITHDRAWAL REQUEST";
        $template = $mail->template();
        $mail->body = $mail->inject($template, APP_NAME, "Request for withdrawal of funds", $name, "Your request to withdraw the sum of <b>$$amount</b> has been received and is being processed. <br> The funds will be transfered shortly");
        $mail->sendemail();

        return  Withdrawal::insert(Withdrawal::$table, [
                    'user_id' => $userid,
                    'amount' => $amount,
                    'status' => 0
                ]);
    }

    public function updatebalance()
    {
        $userid = $_POST['userid'];
        $newbalance = $_POST['newbalance'];

        return ModelsWallet::update(ModelsWallet::$table, "balance = $newbalance", 'user_id', $userid);
    }
}
