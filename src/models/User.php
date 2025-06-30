<?php

namespace Src\Models;

use Src\Core\Model;


class User extends Model
{
	private $id, $password;
	public $username, $email, $createdAt;

	public function __construct(
		$id = null,
		$password = null,
		$username = null,
		$email = null,
		$createdAt = null
	) {

		$this->id = $id;
		$this->password = $password;
		$this->username = $username;
		$this->email = $email;
		$this->createdAt = $createdAt;
	}

	public static function initUser()
	{
		self::migrateModel('
			id int primary key auto_increment,
			password varchar(255) not null,
			username varchar(50) not null,
			email varchar(50) unique not null,
			createdAt timestamp default current_timestamp
		');
	}


	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}
}
