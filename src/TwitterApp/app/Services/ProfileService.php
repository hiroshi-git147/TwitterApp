<?php

namespace App\Services;

use App\Services\Interfaces\ProfileServiceInterface;
use App\Models\User;

class ProfileService implements ProfileServiceInterface
{
    public function updateUserProfile(User $user, array $data): User
    {
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return $user;
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }
}
