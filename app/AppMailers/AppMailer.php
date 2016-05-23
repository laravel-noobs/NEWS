<?php namespace App\AppMailers;


use App\Feedback;
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
     * @param Feedback $feedback
     * @param User $sender
     * @param null $message
     */
    public function send_feedback_notification_to(Feedback $feedback, User $sender, $message = null)
    {
        $user = $feedback->user;

        $this->to = $user->email;// $sender->email; for testing
        $this->view = 'emails.user_feedback_notification';
        $this->data = [
            'name' => $user->name,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'staff' => $sender,
            'staff_message' => $message,
            'feedback' => $feedback
        ];

        if(get_class($feedback->feedbackable) == \App\Post::class)
            $this->subject = "Phản hồi của bạn ở bài viết \"{$feedback->feedbackable->title}\" đã được quan tâm.";
        else if(get_class($feedback->feedbackable) == \App\Product::class)
            $this->subject = "Phản hồi của bạn về sản phẩm \"{$feedback->feedbackable->name}\" đã được quan tâm.";

        $this->deliver();
    }

    public function send_user_banned_notification_to(User $user, User $staff, $reason, $message)
    {
        $this->to = $user->email;
        $this->view = 'emails.user_banned_notification';
        $this->data = [
            'name' => $user->name,
            'expired_at' => $user->expired_at,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'staff_first_name' => $staff->first_name,
            'staff_last_name' => $staff->last_name,
            'staff_message' => $message,
            'reason' => $reason
        ];

        $this->subject = "Tài khoản của bạn đã bị khóa.";
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
            $m->to($this->to, $data['name'])->subject($this->subject);
        });
    }
}