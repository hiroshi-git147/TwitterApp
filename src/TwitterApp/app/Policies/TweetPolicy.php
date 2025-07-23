<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tweet;
use Illuminate\Auth\Access\HandlesAuthorization;

class TweetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given Tweet can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tweet  $tweet
     * @return bool
     */
    public function view(User $user, Tweet $tweet)
    {
        return $user->id === $tweet->user_id;
    }

    /**
     * Determine if the given Tweet can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tweet  $tweet
     * @return bool
     */
    public function create(User $user)
    {
        return $user !== null;
    }

    /**
     * Determine if the given Tweet can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tweet  $tweet
     * @return bool
     */
    public function update(User $user, Tweet $tweet)
    {
        return $user->id === $tweet->user_id;
    }

    /**
     * Determine if the given Tweet can be deleted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tweet  $tweet
     * @return bool
     */
    public function destroy(User $user, Tweet $tweet)
    {
        return $user->id === $tweet->user_id;
    }
}
