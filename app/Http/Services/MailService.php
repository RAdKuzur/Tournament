<?php

namespace App\Http\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class MailService extends Mailable
{
    use Queueable, SerializesModels;
    protected $link;
    public function __construct($link = null)
    {
        $this->link = $link;
    }

    public function build()
    {
        return $this->view('email.reset-password')
            ->with(['link' => $this->link])
            ->subject('Восстановление пароля');
    }

    public function sendNewPasswordLink($email, $url)
    {
        Mail::to($email)->send(new MailService($url));
    }
    public function createTempLink($baseUrl, $duration, $userId) {
        $expires = now()->addSeconds($duration);
        $url = URL::temporarySignedRoute(
            $baseUrl,
            $expires,
            ['id' => $userId]
        );
        return $url;
    }

}
