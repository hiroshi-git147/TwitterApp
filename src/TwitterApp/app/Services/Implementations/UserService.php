<?php

namespace App\Services\Implementations;

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
        ]);

        // メール認証通知
        event(new Registered($user));

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

    public function login(string $user) {
        return;
    }

}
