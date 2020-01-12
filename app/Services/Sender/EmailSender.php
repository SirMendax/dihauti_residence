<?php


namespace App\Services\Sender;


use App\Mail\EmailNotification;
use App\Services\Contracts\SenderInterface;
use Mail;


class EmailSender implements SenderInterface
{
    /**
     * @var string
     */
    protected string $recipient;
    /**
     * @var array
     */
    protected array $message;

    /**
     * EmailSender constructor.
     * @param string $recipient
     * @param array $message
     * @param string $type
     */
    public function __construct(string $recipient, array $message)
    {
        $this->recipient = $recipient;
        $this->message = $message;
    }

    /**
     * @return void
     */
    public function sendNotification() :void
    {
        Mail::to($this->recipient)->send(new EmailNotification($this->message));
    }

}
