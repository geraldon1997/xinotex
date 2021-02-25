<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawal as ModelsWithdrawal;
use App\Controllers\User as Cuser;

class Withdrawal extends Controller
{
    public function pending()
    {
        $withdrawal = ModelsWithdrawal::find(ModelsWithdrawal::$table, 'status', 0);
        return $this->view('pending_withdrawals', ['admin' => $withdrawal]);
    }

    public function completed()
    {
        $withdrawal = ModelsWithdrawal::find(ModelsWithdrawal::$table, 'status', 1);
        return $this->view('completed_withdrawals', ['admin' => $withdrawal]);
    }

    public function paid()
    {
        $id = $_POST['id'];
        $userid = ModelsWithdrawal::find(ModelsWithdrawal::$table, 'id', $id)[0]['user_id'];
        $wallet = Wallet::find(Wallet::$table, 'user_id', $userid)[0]['wallet_address'];
        $email = User::find(User::$table, 'id', $userid)[0]['email'];
        $name = Profile::find(Profile::$table, 'user_id', $userid)[0]['firstname'];
        $amount = '$'.ModelsWithdrawal::find(ModelsWithdrawal::$table, 'id', $id)[0]['amount'];

        $gen = new Cuser;
        $transID = $gen->generateToken($gen->permitted_chars, 16);

        $mail = new Mail;
        $mail->receiver = $email;
        $mail->subject = "WITHDRAWAL CONFIRMED";
        $template = $mail->template();
        $body = "The sum of <b>$amount</b> worth of coin has been sent to your wallet <b>$wallet</b>";
        $body .= "<hr>";
        $body .= "<table>";
        $body .= "<tr><td><b>Transaction ID</b></td><td>$transID</td></tr>";
        $body .= "<tr><td><b>Amount</b></td><td>$amount</td></tr>";
        $body .= "<tr><td><b>VAT</b></td><td>0.00</td></tr>";
        $body .= "<tr><td><b>Total</b></td><td>$amount</td></tr>";
        $body .= "</table>";
        $mail->body = $mail->inject($template, APP_NAME, "<b style='background: grey; padding:10px; color: white;'>Withdrawal Confirmation</b>", $name, $body);
        $mail->sendemail();
        
        return ModelsWithdrawal::update(ModelsWithdrawal::$table, "status = 1", 'id', $id);
    }
}
