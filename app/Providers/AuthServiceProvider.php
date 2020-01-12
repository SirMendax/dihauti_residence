<?php

namespace App\Providers;

use App\Models\Blog\BlogCategory;
use App\Models\Blog\BlogComment;
use App\Models\Blog\BlogPost;
use App\Models\Dialog;
use App\Models\Forum\ForumCategory;
use App\Models\Forum\ForumQuestion;
use App\Models\Forum\ForumReply;
use App\Models\Profile\Profile;
use App\Policies\BlogCategoryPolicy;
use App\Policies\BlogCommentPolicy;
use App\Policies\BlogPostPolicy;
use App\Policies\ForumCategoryPolicy;
use App\Policies\ForumQuestionPolicy;
use App\Policies\ForumReplyPolicy;
use App\Policies\MessagePolicy;
use App\Policies\ProfilePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        BlogPost::class => BlogPostPolicy::class,
        BlogCategory::class => BlogCategoryPolicy::class,
        BlogComment::class => BlogCommentPolicy::class,
        ForumCategory::class => ForumCategoryPolicy::class,
        ForumQuestion::class => ForumQuestionPolicy::class,
        ForumReply::class => ForumReplyPolicy::class,
        Profile::class => ProfilePolicy::class,
        Dialog::class => MessagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
