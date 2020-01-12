<?php


namespace App\Services\Sender;


use App\Services\Contracts\SenderInterface;
use DebugBar;

/**
 * Class PhoneSender
 * @package App\Services\Sender
 */

class PhoneSender implements SenderInterface
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
     * PhoneSender constructor.
     * @param string $recipient
     * @param array $message
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
        \Log::info( $this->message . ' for ' . $this->recipient);
    }
}
