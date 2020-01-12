<?php


namespace App\Services\Like;


use Illuminate\Http\Response;

class CreateLikeService
{
    /**
     * @param $entity
     * @param $user_id
     * @return array
     */
    public static function like($entity, $user_id)
    {
        $checkLike = (bool)$entity->likes()->where(['user_id' => $user_id])->count();
        if ($checkLike) {
            $entity->likes()->where(['user_id' => $user_id])->delete();
            return [
                'content' => NULL,
                'message' => 'Unliked this post successfully.',
                'status' => Response::HTTP_ACCEPTED
            ];
        } else {
            $entity->likes()->create(['user_id' => $user_id]);
            return [
                'content' => NULL,
                'message' => 'Liked this post successfully.',
                'status' => Response::HTTP_CREATED
            ];
        }
    }
}
