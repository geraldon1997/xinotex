<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Migration;

class Page extends Controller
{
    public function default($params)
    {
        if (!empty($params)) {
            $arr = explode('=', $params);
            $_SESSION['referrer'] = $arr[1];
        }

        return $this->view('home');
    }

    public function about()
    {
        return $this->view('about');
    }

    public function questionguide()
    {
        return $this->view('qguide');
    }

    public function terms()
    {
        return $this->view('terms');
    }

    public function wapspeed()
    {
        return $this->view('wapspeed');
    }

    public function team()
    {
        return $this->view('team');
    }

    public function app()
    {
        return $this->view('app');
    }

    public function whyus()
    {
        return $this->view('why_us');
    }

    public function contact()
    {
        return $this->view('contact');
    }

    public function dbseeder()
    {
        $mail = new Mail;
        $template = $mail->template('verify');
        return $mail->inject($template, 'BTC', 'welcome to [site_title]', 'mosco@email.com', '<a class="btn btn-primary" href="[link]">verify</a>', 'https://google.com');
    }
}
