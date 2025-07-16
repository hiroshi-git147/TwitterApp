<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verification_code' => $data['verification_code'],
            'verification_code_expires_at' => $data['verification_code_expires_at'],
        ]);

        return $user;
    }

    public function verifyEmail($userId, $hash)
    {
        $user = User::findOrFail($userId);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return false;
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return true;
    }
}
