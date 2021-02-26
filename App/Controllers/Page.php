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

    public function contact()
    {
        return $this->view('contact');
    }

    public function sendContact()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $body = "<h1>Email Details</h1>";
        $body .= "<p><b>Name :</b> $name</p>";
        $body .= "<p><b>Email :</b> $email</p>";
        $body .= "<p><b>message :</b> <br>$message</p>";

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$email."\r\n".
                    'Reply-To: '.$email."\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        $send = mail('support@xinotex.com', $subject, $body, $headers);

        if ($send) {
            return 'sent';
        } else {
            return 'not sent';
        }
    }
}
