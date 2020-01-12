<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {

    Route::get('/', 'IndexController@index');

    Route::get('/messages', 'MessageController@getAllDialog');
    Route::get('/dialog/{dialog}', 'MessageController@getDialog');
    Route::get('/contacts', 'MessageController@getAllUsers');
    Route::get('/messages/{dialog}', 'MessageController@getMessage');
    Route::post('/messages/{dialog}/send', 'MessageController@sendMessage');
    Route::post('/startDialog', 'MessageController@startDialog');

    Route::group(['namespace' => 'Blog'], function () {

        Route::apiResource('/posts', 'BlogPostController');
        Route::get('/sortedPosts', 'BlogPostController@getSort');
        Route::apiResource('/blogCategories', 'BlogCategoryController');
        Route::apiResource('/posts/{post}/comments', 'BlogCommentController');
        Route::post('/posts/{post}/like', 'LikePostController');
        Route::post('/posts/{post}/comments/{comment}/like', 'LikeCommentController');

    });

    Route::group(['namespace' => 'Forum'], function () {

        Route::apiResource('/questions', 'ForumQuestionController');
        Route::get('/sortedQuestionsReplies', 'ForumQuestionController@getSortReplies');
        Route::get('/sortedQuestionsCategory', 'ForumQuestionController@getSortNewQuestion');
        Route::get('/forumCategories/{forumCategory}', 'ForumQuestionController@getQuestionCategory');
        Route::apiResource('/forumCategories', 'ForumCategoryController');
        Route::apiResource('/questions/{question}/replies', 'ForumReplyController');
        Route::post('/questions/{question}/like', 'LikeQuestionController');
        Route::post('/questions/{question}/replies/{reply}/like', 'LikeReplyController');

    });

    Route::group(['namespace' => 'Profile'], function () {

        Route::get('/users', 'ProfileController@index');
        Route::get('/users/{user}', 'ProfileController@show');
        Route::put('/users/update', 'ProfileController@update');
        Route::delete('/users/delete', 'ProfileController@delete');
        Route::put('/users/passwordUpdate', 'ProfileController@updatePassword');
        Route::put('/users/loginUpdate', 'ProfileController@updateLogin');

    });

    Route::group(['namespace' => 'Auth'], function () {

        Route::post('registration', 'RegisterController');
        Route::post('login', 'LoginController')->middleware("throttle:10,2")->name('login');
        Route::post('reset', 'ResetPasswordController@resetPassword')->middleware("throttle:3,2");
        Route::post('logout', 'LogoutController')->middleware('auth:api');
        Route::post('verify', 'VerificationController')->middleware('auth:api');

        Route::get('/users/{user}/getRoles', "RoleController@get");
        Route::post('/users/{user}/storeRole', "RoleController@store");
        Route::put('/users/{user}/updateRole', "RoleController@update");
        Route::delete('/users/{user}/deleteRole', "RoleController@delete");

    });
});
