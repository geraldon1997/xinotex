<?php
namespace App\Core;

use App\Models\Auth;
use App\Models\Role;
use App\Models\User;

class Controller
{
    public $main = 'main';
    public $dashboard = 'dashboard';

    public $views = [
        'auth' => [
            'general' => [
                'dashboard',
                'profile',
                'login',
                'wallet',
                'referrals',
                'active_investments',
                'pending_investments',
                'completed_investments',
                'pending_withdrawals',
                'completed_withdrawals',
                'bonus',
                'payment_page'
            ],
            'admin' => [
                'active_members',
                'inactive_members',
                'moderators',
                'user',
                'users_referrals',
                'users_investments'
            ],
            'moderator' => [
                'users_investments',
                'user'
            ]
        ],
        'nonauth' => [
            'home',
            'about',
            'white_paper',
            'plans',
            'wapspeed',
            'team',
            'app',
            'why_us',
            'register',
            'signin',
            'forgotpassword',
            'resetpassword',
            'verifyuser',
            'paper',
            'contact'
        ]
    ];

    public function view($view, $params = null)
    {
        if (!isset($_SESSION['email'])) {
            $non = in_array($view, $this->views['nonauth']);

            if ($non) {
                return View::renderView('main', $view, $params);
            }

            return View::renderView('main', 'signin', $params);
        }
        
        $general = in_array($view, $this->views['auth']['general']);
        $layout = 'dashboard';

        if ($general) {
            if ($view === 'login') {
                return View::renderView('main', $view, $params);
            }
            return View::renderView($layout, $view, $params);
        }

        if (User::isAdmin()) {
            $admin = in_array($view, $this->views['auth']['admin']);

            if ($admin) {
                return View::renderView($layout, $view, $params);
            }
        }

        if (User::isModerator()) {
            $moderator = in_array($view, $this->views['auth']['moderator']);

            if ($moderator) {
                return View::renderView($layout, $view, $params);
            }
        }
        
        $checknon = in_array($view, $this->views['nonauth']);

        if ($checknon) {
            return View::renderView('main', $view, $params);
        }

        unset($_SESSION['email']);
        return Response::redirect(SIGNIN);
    }
}
