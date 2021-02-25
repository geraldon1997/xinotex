<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Models\Auth;
use App\Models\Investment;
use App\Models\Profile;
use App\Models\Referral;
use App\Models\User as ModelsUser;
use App\Models\Wallet;
use App\Models\Withdrawal;

class User extends Controller
{
    public $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function create($params)
    {
        $referrer = ($params ? $params[0] : '');
        return $this->view('register', $referrer);
    }

    public function signin()
    {
        return $this->view('signin');
    }

    public function forgotpassword()
    {
        return $this->view('forgotpassword');
    }

    public function dashboard()
    {
        return $this->view('dashboard');
    }

    public function profile()
    {
        return $this->view('profile');
    }

    public function generateToken($input, $strength = 8)
    {
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
     
        return $random_string;
    }

    public function store()
    {
        $email = $_POST['email'];
        $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
        $ref = $this->generateToken($this->permitted_chars, 6);

        $values = [
            'role_id' => 3,
            'ref' => $ref,
            'email' => $email,
            'pass' => $pass,
            'joined_at' => date('Y-m-d')
        ];

        $createuser = ModelsUser::insert(ModelsUser::$table, $values);

        if ($createuser) {
            if (isset($_SESSION['referrer'])) {
                $referrer = $_SESSION['referrer'];
                $referrerid = ModelsUser::find(ModelsUser::$table, 'ref', $referrer)[0]['id'];
                $referredid = ModelsUser::userid($email)[0]['id'];

                Referral::insert(Referral::$table, [
                    'referrer' => $referrerid,
                    'referred' => $referredid
                    ]);
                    unset($_SESSION['referrer']);
            }
            

            $email_token = $this->generateToken($this->permitted_chars, 32);
            $email_token_expiry = time() + (60 * 30);
            $userid = ModelsUser::userid($_POST['email']);

            $auth = [
                'user_id' => $userid,
                'is_email_verified' => 0,
                'email_verification_token' => $email_token,
                'email_verification_token_expiry' => $email_token_expiry,
                'email_verified_at' => '0000-00-00',
                'is_active' => 0,
                'is_logged_in' => 0,
                'is_deleted' => 0
            ];

            $createauth = Auth::insert(Auth::$table, $auth);

            if ($createauth) {
                $sendverificationlink = $this->sendverificationemail($email, $email_token, $_POST['pass']);

                if (!$sendverificationlink) {
                    $sendverificationlink;
                    return 0;
                }
                
                return 1;
            }
        }
    }

    public function sendverificationemail($email, $email_token, $password)
    {
        $mail = new Mail();
                $mail->receiver = $email;
                $mail->subject = "Welcome to ".APP_NAME;
                $template = $mail->template();
                $body = "<h4>Your login information</h4>";
                $body .= "<p><b>Login : $email</b></p>";
                $body .= "<p><b>Password : $password</b></p>";
                $body .= "<p>You can Login Here <a href='".APP_URL."user/signin'>".APP_NAME."</a></p>";
                $link = APP_URL.'user/verify/'.$email_token;
                $mail->body = $mail->inject($template, APP_NAME, 'Welcome to [site_title]', $email, "Thank you for registering with us, click on the button to verify your email address, <hr><br><a class='btn' href='[link]'>Verify email</a><hr> $body", $link);
        return $mail->sendemail();
    }

    public function sendlogincode($email, $code)
    {
        $mail = new Mail;
        $mail->receiver = $email;
        $mail->subject = "User authentication";
        $template = $mail->template();
        $mail->body = $mail->inject($template, APP_NAME, 'User Login Code', $email, "<p>find below your login code, it expires in 15 minutes <br> <b>$code</b></p>");
        return $mail->sendemail();
    }

    public function registersuccess()
    {
        return 'registerations was successul';
    }

    public function verify()
    {
        return $this->view('verifyuser');
    }

    public function verifyuseremail()
    {
        $time = time();
        $token = $_POST['token'];
        $auth = Auth::findSingle(Auth::$table, 'email_verification_token', $token);
        
        if (!$auth) {
            return 'it';
        }

        if ($auth[0]['email_verification_token_expiry'] < $time) {
            return 'te';
        }

        $verify = Auth::update(Auth::$table, "is_email_verified = 1 ", 'email_verification_token', $token);

        if (!$verify) {
            return 'env';
        }

        return 'ev';
    }

    public function activate()
    {
        $id = $_POST['id'];
        return Auth::update(Auth::$table, "is_email_verified = 1", 'user_id', $id);
    }

    public function delete()
    {
        $id = $_POST['userid'];
        return ModelsUser::delete(ModelsUser::$table, 'id', $id);
    }

    public function auth()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $details = ModelsUser::find(ModelsUser::$table, 'email', $email);
        
        if (!$details) {
            return "ne";
        }

        $verifypassword = password_verify($password, $details[0]['pass']);

        if (!$verifypassword) {
            return "ic";
        }

        $auth = Auth::findSingle(Auth::$table, 'user_id', $details[0]['id']);

        if (!$auth[0]['is_email_verified']) {
            $token = $this->generateToken($this->permitted_chars, 32);
            $token_expiry = time() + (60 * 15);

            $generate_token = Auth::update(Auth::$table, "email_verification_token = '$token', email_verification_token_expiry = '$token_expiry' ", 'user_id', $details[0]['id']);
            
            if (!$generate_token) {
                return "tni";
            }

            $sendmail = $this->sendverificationemail($email, $token, $_POST['password']);

            if (!$sendmail) {
                return "mns";
            }
            return "ms";
        }

        $_SESSION['email'] = $email;
        return "usli";
    }

    public function login()
    {
        return $this->view('login');
    }

    public function verifylogincode()
    {
        $lc = $_POST['login_code'];
        $auth = Auth::findSingle(Auth::$table, 'login_code', $lc);

        if (empty($auth)) {
            $new_login_code = $this->generateToken($this->permitted_chars, 8);
            $new_login_code_expiry = time() + (60 * 5);
            $userid = ModelsUser::findSingle(ModelsUser::$table, 'email', $_SESSION['email'])[0]['id'];
            $generate_new_login_code = Auth::update(Auth::$table, "login_code = '$new_login_code', login_code_expiry = '$new_login_code_expiry' ", 'user_id', $userid);

            $this->sendlogincode($_SESSION['email'], $new_login_code);

            return 'ilc';
        }

        $current_time = time();
        if ($auth[0]['login_code_expiry'] > $current_time) {
            $login = Auth::update(Auth::$table, "is_logged_in = 1", 'login_code', $lc);
            return 'lcv';
        }

        if ($auth[0]['login_code_expiry'] < $current_time) {
            $new_login_code = $this->generateToken($this->permitted_chars, 8);
            $new_login_code_expiry = time() + (60 * 5);
            $userid = ModelsUser::findSingle(ModelsUser::$table, 'email', $_SESSION['email'])[0]['id'];
            $generate_new_login_code = Auth::update(Auth::$table, "login_code = '$new_login_code', login_code_expiry = '$new_login_code_expiry' ", 'user_id', $userid);

            if ($generate_new_login_code) {
                $this->sendlogincode($_SESSION['email'], $new_login_code);
                return 'exlc';
            }
            unset($_SESSION['email']);
            return 'lcng';
        }
    }

    public function sendpasswordresetlink()
    {
        $email = $_POST['email'];
        $user = ModelsUser::findSingle(ModelsUser::$table, 'email', $email);
        if (empty($user)) {
            return 'ie';
        }
        $password_reset_token = $this->generateToken($this->permitted_chars, 32);
        $password_reset_token_expiry = time() + (60 * 30);

        ModelsUser::update(ModelsUser::$table, "password_reset_token = '$password_reset_token', password_reset_token_expiry = '$password_reset_token_expiry' ", 'email', $email);

        $mail = new Mail;
        $mail->subject = "Password Reset";
        $mail->receiver = $email;
        $template = $mail->template();
        $mail->body = $mail->inject($template, APP_NAME, 'Password Reset Link', $email, "<p>Click on the button to reset your password</p><a href='".APP_URL."user/resetpassword/".$password_reset_token."' class='btn btn-primary'>click to reset password</a>");
        $mail->sendemail();
        return 'prls';
    }

    public function resetpassword($params)
    {
        if (!empty($params)) {
            $token = $params[0];
            return $this->view('resetpassword', $token);
        }
        return Response::redirect('/user/signin');
    }

    public function checkpasswordresettoken()
    {
        $token = $_POST['token'];
        $token_exists = ModelsUser::findSingle(ModelsUser::$table, 'password_reset_token', $token);
        if (!$token_exists) {
            return 'tde';
        }

        $time = time();
        if ($token_exists[0]['password_reset_token_expiry'] < $time) {
            return 'the';
        }

        return 1;
    }

    public function updatepassword()
    {
        $token = $_POST['token'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $update = ModelsUser::update(ModelsUser::$table, "pass = '$password'", 'password_reset_token', $token);

        if (!$update) {
            return 'pnu';
        }
        return 1;
    }

    public function logout()
    {
        if (!isset($_SESSION['email'])) {
            return Response::redirect('/');
        }

        if (!isset($_POST['logout'])) {
            return Response::redirect(DASHBOARD);
        }

        $userid = ModelsUser::userid($_SESSION['email']);
        $logout = Auth::update(Auth::$table, "is_logged_in = 0", 'user_id', $userid);

        if (!$logout) {
            return Response::redirect(DASHBOARD);
        }

        unset($_SESSION['email']);
        return 1;
    }

    public function wallet()
    {
        $wallet = Wallet::details();
        return $this->view('wallet', ['user' => $wallet]);
    }

    public function referrals()
    {
        $referral = Referral::myReferrals();
        return $this->view('referrals', $referral);
    }

    public function activemembers()
    {
        $active = ModelsUser::users(3, 1);
        return $this->view('active_members', $active);
    }

    public function inactivemembers()
    {
        $inactive = ModelsUser::users(3, 0);
        return $this->view('inactive_members', $inactive);
    }

    public function moderators()
    {
        $moderators = ModelsUser::users(2, 1);
        return $this->view('moderators', $moderators);
    }

    public function investment($type)
    {
        $type = $type[0];
        $userid = ModelsUser::userid($_SESSION['email']);
        if ($type == 'active') {
            $investment = Investment::active($userid);
        } elseif ($type == 'pending') {
            $investment = Investment::pending($userid);
        } elseif ($type == 'completed') {
            $investment = Investment::completed($userid);
        }
        return $this->view($type.'_investments', ['user' => $investment]);
    }

    public function bonus()
    {
        return $this->view('bonus');
    }

    public function withdrawal($type)
    {
        $type = strtolower($type[0]);
        $userid = ModelsUser::userid($_SESSION['email']);

        if ($type === 'pending') {
            $withdrawal = Withdrawal::findMultiple(Withdrawal::$table, "user_id = '$userid' AND status = 0");
        } elseif ($type === 'completed') {
            $withdrawal = Withdrawal::findMultiple(Withdrawal::$table, "user_id = '$userid' AND status = 1");
        }
        return $this->view($type.'_withdrawals', ['user' => $withdrawal]);
    }

    public function addprofile()
    {
        $userid = ModelsUser::userid($_SESSION['email']);
        $_POST = ['user_id' => $userid] + $_POST;
        $add = Profile::insert(Profile::$table, $_POST);
        if (!$add) {
            return false;
        }
        return Auth::update(Auth::$table, "is_active = 1", 'user_id', $userid);
    }

    public function updateprofile()
    {
        $userid = ModelsUser::userid($_SESSION['email']);
        $fn = $_POST['firstname'];
        $ln = $_POST['lastname'];
        $cn = $_POST['country'];
        $st = $_POST['state'];
        $ci = $_POST['city'];
        $ad = $_POST['address'];
        $ph = $_POST['phone'];
        $gn = $_POST['gender'];

        $data = "firstname = '$fn', ";
        $data .= "lastname = '$ln', ";
        $data .= "country = '$cn', ";
        $data .= "state = '$st', ";
        $data .= "city = '$ci', ";
        $data .= "address = '$ad', ";
        $data .= "phone = '$ph', ";
        $data .= "gender = '$gn' ";
        
        return Profile::update(Profile::$table, $data, 'user_id', $userid);
    }

    public function details($data)
    {
        $userid = $data[0];
        $user = Profile::findSingle(Profile::$table, 'user_id', $userid);
        return $this->view('user', $user);
    }

    public function upgrade()
    {
        $userid = $_POST['userid'];
        return ModelsUser::update(ModelsUser::$table, "role_id = 2", 'id', $userid);
    }

    public function downgrade()
    {
        $userid = $_POST['userid'];
        return ModelsUser::update(ModelsUser::$table, "role_id = 3", 'id', $userid);
    }
}
