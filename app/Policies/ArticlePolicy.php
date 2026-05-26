<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): string
    {
        return true;

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article): bool
    {
    //     if($article->status==='published'){

    //         return true;
    //     }

    //    return $user->id===$article->author_id || $article->reviewer_id===$user->id||$user->role==='admin';

           return true;//it will filter by the global scope in article model
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'writer']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
        if($user->role==='admin'){

            return true;
        }

        return $user->id===$article->author_id&& $user->role==='writer';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        return $user->role==='admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Article $article): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Article $article): bool
    {
        return false;
    }

    public function publish(User $user,Article $article){

//    if(!$user->id===$article->author_id)
//     return false;

//    else
    return $user->id===$article->author_id;
    }
}
