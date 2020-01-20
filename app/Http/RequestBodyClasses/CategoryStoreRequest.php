<?php


namespace App\Http\RequestBodyClasses;

/**
 * @OA\Schema(
 *     description="Category request models",
 *     type="object",
 *     title="Category store request",
 * )
 */

class CategoryStoreRequest
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name category",
     *     format="string",
     *     example="Музыка",
     *)
     * @var string
     */
    public $name;
}
