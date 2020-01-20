<?php


namespace App\Http\RequestBodyClasses;

/**
 * @OA\Schema(
 *     description="Post request models",
 *     type="object",
 *     title="Post store request",
 * )
 */
class PostStoreRequest
{
    /**
     * @OA\Property(
     *     title="Title",
     *     description="Title post",
     *     format="string",
     *     example="Lorem ipsum",
     *)
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *     title="Blog category id",
     *     description="Blog category id for post",
     *     format="int64",
     *     example="1",
     *)
     * @var int
     */
    public $blog_category_id;

    /**
     * @OA\Property(
     *     title="Description",
     *     description="Description post",
     *     format="string",
     *     example="Lorem ipsum",
     *)
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *     title="Text",
     *     description="Text post",
     *     format="string",
     *     example="Lorem ipsum",
     *)
     * @var string
     */
    public $body;
}
