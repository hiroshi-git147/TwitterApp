<?php

namespace App\Services;

use App\Services\Interfaces\ProfileServiceInterface;
use App\Models\User;

class ProfileService implements ProfileServiceInterface
{
    /**
     * ユーザー情報を更新する
     * 
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateUserProfile(User $user, array $data): User
    {
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return $user;
    }

    /**
     * ユーザーを削除する
     * 
     * @param User $user
     * @return void
     */
    public function deleteUser(User $user): void
    {
        $user->delete();
    }
}
