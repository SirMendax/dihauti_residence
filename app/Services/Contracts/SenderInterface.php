<?php


namespace App\Services\Contracts;

/**
 * Interface SenderInterface
 * @package App\Services\Contracts
 */
interface SenderInterface
{
    /**
     * @return void
     */
    public function sendNotification() :void;
}
