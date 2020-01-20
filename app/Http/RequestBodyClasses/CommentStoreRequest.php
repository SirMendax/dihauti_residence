<?php


namespace App\Http\RequestBodyClasses;

/**
 * @OA\Schema(
 *     description="Comment request models",
 *     type="object",
 *     title="Comment store request",
 * )
 */
class CommentStoreRequest
{
    /**
     * @OA\Property(
     *     title="Text",
     *     description="Text comment",
     *     format="string",
     *     example="Lorem ipsum",
     *)
     * @var string
     */
    public $body;
}
