<?php

namespace App\Services\Interfaces;

interface UserServiceInterface {
  public function register(array $data);
  public function verifyEmail($useID, $hash);
  public function login(string $user);
}
