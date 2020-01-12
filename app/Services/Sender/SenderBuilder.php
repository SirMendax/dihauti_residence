<?php


namespace App\Services\Sender;


use App\Services\Contracts\SenderBuilderInterface;
use App\Services\Contracts\SenderInterface;
use Exception;

/**
 * Class SenderBuilder
 * @package App\Services\Sender
 */

class SenderBuilder implements SenderBuilderInterface
{
    /**
     * @param string $type
     * @param string $recipient
     * @param array $message
     * @return SenderInterface
     * @throws Exception
     */
    public static function createSender(
        string $type,
        string $recipient,
        array $message) : SenderInterface
    {
        switch ($type) {
            case 'email':
                return new EmailSender($recipient, $message);
            case 'phone':
                return new PhoneSender($recipient, $message);
            default:
                throw new Exception('Undefined type sender');
        }
    }
}
