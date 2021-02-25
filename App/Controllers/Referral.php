<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Investment;
use App\Models\Profile;
use App\Models\Referral as ModelsReferral;
use App\Models\User;

class Referral extends Controller
{
    public function users($id)
    {
        $referred = [];
        $id = $id[0];
        $referrals = ModelsReferral::find(ModelsReferral::$table, 'referrer', $id);
        foreach ($referrals as $key) {
            $profile = User::find(User::$table, 'id', $key['referred'])[0];
            array_push($referred, $profile);
        }
        $referrer = User::find(User::$table, 'id', $id)[0]['email'];
        return $this->view('users_referrals', ['referrer' => $referrer, 'referred' => $referred]);
    }

    public function investments($data)
    {
        $userid = $data[0];
        $email = User::findSingle(User::$table, 'id', $userid)[0]['email'];
        $investments = Investment::findMultiple(Investment::$table, "user_id = $userid ORDER BY is_active DESC");
        return $this->view('users_investments', ['email' => $email, 'investments' => $investments]);
    }
}
