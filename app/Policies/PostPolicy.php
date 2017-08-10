<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Post;

class PostPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return User::findOrFail($user->id)->hasPermissionTo('post_create');
    }

    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id || User::findOrFail($user->id)->hasPermissionTo('post_edit');
    }

    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id || User::findOrFail($user->id)->hasPermissionTo('post_delete');
    }
}