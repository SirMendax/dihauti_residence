<?php


namespace App\Services\Contracts;

/**
 * Interface SenderBuilderInterface
 * @package App\Services\Contracts
 */

interface SenderBuilderInterface
{
    /**
     * @param string $type
     * @param string $recipient
     * @param array $message
     * @return SenderInterface
     */
    public static function createSender(string $type, string $recipient, array $message) : SenderInterface;
}
