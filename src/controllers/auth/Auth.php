<?php

namespace Src\Controllers;

use PDOException;
use Src\Core\App;
use Src\Core\Controller;
use Src\Core\Utils\Annotations\Get;
use Src\Core\Utils\Annotations\Middleware;
use Src\Core\Utils\Annotations\Post;
use Src\Core\Utils\Request;
use Src\Core\Utils\Token;
use Src\Middlewares\Authentication;
use Src\Models\User;

#[Middleware(new Authentication)]
class Auth extends Controller
{
	#[Get('/login')]
	#[Middleware(new Authentication)]
	public function login(Request $request)
	{
		return view('auth.login');
	}

	#[Get('/register')]
	public function register(Request $request)
	{
		return view('auth.register');
	}

	#[Get('/forgot')]
	public function forgot(Request $request)
	{
		return view('auth.forgot');
	}

	#[Post('/forgot')]
	public function forgothandler(Request $request)
	{
		$username = $_POST['username'];
		$password = $_POST['newpass'];

		$hashedpw = password_hash($password, PASSWORD_DEFAULT);

		$user = User::find(['username' => $username]);

		if ($user == null) {
			return view('auth.forgot', [
				'errors' => ['username' => 'user not found'],
			]);
		}
		$user->setPassword($hashedpw);

		$user->update();

		return redirect('/auth/login');
	}

	#[Post('/login')]
	public function loghandler(Request $request)
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		$user = User::find(['username' => $username]);

		if ($user == null) {

			return view('auth.login', [
				'errors' => ['username' => 'user not found'],
			]);
		}

		if (!password_verify($password, $user->getPassword())) {

			return view('auth.login', [
				'errors' => ['password' => 'wrong credentials'],
			]);
		}

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

		return redirect('/webfront');
	}

	#[Post('/register')]
	public function registerhandler(Request $request)
	{
		$email =	$_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];

		$errors = [];

		if (strlen($password) < 8) {
			$errors['password'] = "password must be at least 8 characters";
		}

		if ($confirm != $password) {
			$errors['confirm'] = "Password is not match";
		}

		if (sizeof($errors) > 0) {
			return view('auth.register', [
				'errors' => $errors,
			]);
		}

		$hashedpw = password_hash(
			htmlspecialchars($password),
			PASSWORD_DEFAULT
		);

		try {
			$user = new User(
				email: htmlspecialchars($email),
				password: $hashedpw,
				username: htmlspecialchars($username)
			);

			$user->save();
		} catch (PDOException $e) {

			if ($e->getCode() == 23000) {

				return view('auth.register', [
					'errors' => [
						'email' => 'Email is already taken'
					],
				]);
			}
		}

		return redirect('/auth/login');
	}

	#[Post('/logout')]
	public function logouthandler(Request $request)
	{
		$token = $_COOKIE['auth_token'] ?? '';

		setcookie('auth_token', $token, [
			'path' => '/',
			'expires' => time() - 3306,
			'domain' => 'localhost',
			'secure' => true,
			'httponly' => true,
			'samesite' => 'Strict'
		]);

		unset($_COOKIE['auth_token']);

		return redirect('/auth/login');
	}
}
