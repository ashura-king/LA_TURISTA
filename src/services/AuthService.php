<?php

namespace Src\Services;

use Src\Core\Utils\Token;
use Src\Models\User;

class AuthService
{
  static function getAuthenticatedUser()
  {
    $token = $_COOKIE['auth_token'] ?? null;

    if (!$token) {
      return null;
    }

    $payload = Token::verify($token, $_ENV['SECRET_KEY']);

    if (!$payload) {
      return null;
    }

    return $payload;
  }

  static function refreshPayload()
  {
    $payload = static::getAuthenticatedUser();

    if (!$payload) {
      return;
    }

    $user = User::findById($payload->id);

    $payload = [
      'id' => $user->getId(),
      'username' => $user->username
    ];

    $token = Token::sign($payload, $_ENV['SECRET_KEY']);

    setcookie('auth_token', $token, [
      'path' => '/',
      'expires' => time() + 86 * 120 * 60,
      'domain' => 'localhost',
      'secure' => true,
      'httponly' => true,
      'samesite' => 'Strict'
    ]);
  }


  public static function destroySession()
  {

    $token = $_COOKIE['auth_token'] ?? null;

    if (!$token) {
      return;
    }

    setcookie('auth_token', $token, [
      'path' => '/',
      'expires' => time() + 86 * 120 * 60,
      'domain' => 'localhost',
      'secure' => true,
      'httponly' => true,
      'samesite' => 'Strict'
    ]);

    session_destroy();
    return redirect('/auth/login');
  }
}
