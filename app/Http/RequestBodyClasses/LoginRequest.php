<?php


namespace App\Http\RequestBodyClasses;

/**
 * @OA\Schema(
 *     description="Auth request",
 *     type="object",
 *     title="Auth request",
 * )
 */
class LoginRequest
{
    /**
     * @OA\Property(
     *     title="Email",
     *     description="Email",
     *     format="string",
     *     example="exapmple@mail.com",
     *)
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *     title="Password",
     *     description="Password",
     *     format="string",
     *     example="secret_pass",
     *)
     * @var string
     */
    public $password;
}
