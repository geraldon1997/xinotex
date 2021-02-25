<?php
session_start();

use App\Core\Route;
use App\Models\User;

require_once "vendor/autoload.php";

define('APP_NAME', 'XINOTEX');
define('APP_ABBRV', 'XTX');
define('APP_URL', 'http://xinotex.test/');
define('ASSETS', APP_URL.'assets/');
define('HOME', '/');
define('ABOUT', '/page/about');
define("PAPER", "/page/whitepaper");
define("PLANS", "/page/plans");
define("WAPSPEED", "/page/wapspeed");
define("TEAM", "/page/team");
define("APP", "/page/app");
define("WHY_US", "/page/whyus");
define("CONTACT", "/page/contact");
define('SIGNUP', '/user/create');
define('SIGNIN', '/user/signin');
define('FORGOT_PASSWORD', '/user/forgotpassword');
define('RESET_PASSWORD', '/user/resetpassword');
define('PROFILE', '/user/profile');
define('DASHBOARD', '/user/dashboard');

define('WHITE_PAPER', APP_URL.'App/Views/tridex_white_paper_');

define('REFERRALS', '/user/referrals');
define('ACTIVE_MEMBERS', '/user/activemembers');
define('MODERATORS', '/user/moderators');
define('INACTIVE_MEMBERS', '/user/inactivemembers');
define('BONUS', '/user/bonus');
define("LOGIN", "/user/login");

if (isset($_SESSION['email'])) {
    if (User::isMember() || User::isModerator()) {
        define('ACTIVE_INVESTMENT', '/user/investment/active');
        define('PENDING_INVESTMENT', '/user/investment/pending');
        define('COMPLETED_INVESTMENT', '/user/investment/completed');
        define('PAYMENT_PAGE', '/investment/payment');
/************************************************************************************/
        define('WALLET', '/user/wallet');
/************************************************************************************/
        define('PENDING_WITHDRAWAL', '/user/withdrawal/pending');
        define('COMPLETED_WITHDRAWAL', '/user/withdrawal/completed');
    } elseif (User::isAdmin()) {
        define('VIEW_USER', '/user/details/');
        define('VIEW_USER_REFERRALS', '/referral/users/');
        define('ACTIVE_INVESTMENT', '/investment/active');
        define('PENDING_INVESTMENT', '/investment/pending');
        define('COMPLETED_INVESTMENT', '/investment/completed');
/************************************************************************************/
        define('PENDING_WITHDRAWAL', '/withdrawal/pending');
        define('COMPLETED_WITHDRAWAL', '/withdrawal/completed');
/************************************************************************************/
        define('WALLET', '/wallet/all');
        define('VIEW_USER_INVESTMENTS', '/investment/user/');
    }

    if (User::isModerator()) {
        define('VIEW_USER', '/user/details/');
        define('VIEW_USER_INVESTMENTS', '/referral/investments/');
    }
}


echo Route::init();
