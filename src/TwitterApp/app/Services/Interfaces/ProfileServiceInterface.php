<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface ProfileServiceInterface
{
    public function updateUserProfile(User $user, array $data): User;

    public function deleteUser(User $user): void;
}
