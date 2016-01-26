<?php namespace App\AppMailers;


use App\User;
use Illuminate\Mail\Mailer;

class AppMailer
{
    /**
     * @var
     */
    protected $from = ['address' => 'administrator@meongu.net', 'name' => 'NEWS'];

    /**
     * @var
     */
    protected $subject;

    /**
     * @var
     */
    protected $to;
    /**
     * @var
     */
    protected $view;
    /**
     * @var
     */
    protected $data;
    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * AppMailer constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param User $user
     */
    public function send_email_confirmation_to(User $user)
    {
        $this->to = $user->email;
        $this->view = 'emails.user_email_verify';
        $this->data = [
            'name' => $user->name,
            'email' => $user->email,
            'verify_token' => $user->verify_token,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name
        ];

        $this->subject = "Xác thực email tại NEWS - Còn một bước nữa, rất nhanh thôi.";
        $this->deliver();
    }

    /**
     *
     */
    public function deliver()
    {
        $data = $this->data;
        $this->mailer->send($this->view, $this->data, function ($m) use($data) {
            $m->from($this->from['address'], $this->from['name']);
            $m->to($data['email'], $data['name'])->subject($this->subject);
        });
    }
}