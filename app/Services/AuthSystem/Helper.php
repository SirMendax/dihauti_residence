<?php


namespace App\Services\AuthSystem;


use App\Jobs\SendMessage;
use App\Models\User;
use App\Notifications\UserRegistration;
use Exception;
use Str;
use Notification;

class Helper
{
    /**
     * @param $request
     * @return mixed
     */
    public static function createNewUser($request)
    {
        $verification_code = Str::random(10);
        return User::create(array_merge(
            $request->only('name', 'email'),
            [
                'password' => bcrypt($request->password),
                'verification_code' => $verification_code,
                'verified' => false,
            ]
        ));
    }


    /**
     * @param string $type
     * @param string $email
     * @param string $code
     * @param string $name
     */
    public static function sendMessageForNewUser(string $type, string $email, string $code, string $name) :void
    {
        SendMessage::dispatch($type, $email, [
            'subject' => 'Регистрация на сайте dihauti.ru',
            'text' => "Поздравляем, $name! Вы зарегестрировались на сайте Dihauti Residence. Пожалуйста, используйте данный код для подтверждения своего аккаунта",
            'url' => 'https://dihauti.ru/profile',
            'code' => $code
        ]);
    }

    /**
     * @param User $user
     * @throws Exception
     */
    public static function sendNotifyForAdmin(User $user)
    {
        $admin = self::getAdminUser(User::get());
        if($admin){
            Notification::send($admin, new UserRegistration($user));
        } else{
            throw new Exception('Administrator is not found');
        }
    }

    /**
     * @param $users
     * @return mixed
     */
    protected static function getAdminUser($users)
    {
        foreach ($users as $user){
            if($user->isAdmin())
            {
                return $user;
            }
        }
    }
}
