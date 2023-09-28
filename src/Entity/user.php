<?php

require_once "./src/Repository/MainRepository.php";
require_once "./src/Security/UserManager.php";
require_once "./src/lib/tools/Tools.php";

class User
{
	public int $id;
	public $username;
	public $firstname;
	public $lastname;
	public $email;
	public $password;
	public $birthday;
	public $profile_picture;
	public $created_at;
	public $updated_at;

	public function __construct($id = null, $username = null, $firstname = null, $lastname = null, $email = null, $password = null, $birthday = null, $profile_picture = null, $created_at = null, $updated_at = null)
	{
		$this->id = $id;
		$this->username = $username;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->email = $email;
		$this->password = $password;
		$this->birthday = $birthday;
		$this->profile_picture = $profile_picture;
		$this->created_at = $created_at;
		$this->updated_at = $updated_at;
	}

	public static function getOne($id)
	{
		$repo = new MainRepository("user");
		// We check if the request returned at least one result
		if ($repo->getOne($id) > 0) {
			// We get the result
			$result = $repo->getOne($id);
			// We create a new User object with the result
			$user = new User(
				$result['id'],
				$result['username'],
				$result['firstname'],
				$result['lastname'],
				$result['email'],
				'', // We don't return the password
				$result['birthday'],
				$result['profile_picture'],
				$result['created_at'],
				$result['updated_at']
			);
			// We return the User object
			return $user;
		} else {
			// If the request returned no result, we return false
			throw new Exception("No user found.");
			return false;
		}
	}

	public static function getAll()
	{
		$users = array();
		$repo = new MainRepository("user");
		// We check if the request returned at least one result
		if ($repo->getAll(null, null, null) > 0) {
			// We get the result
			$results = $repo->getAll(null, null, null);
			// We create a new User object with the result
			foreach ($results as $result) {
				$user = new User(
					$result['id'],
					$result['username'],
					$result['firstname'],
					$result['lastname'],
					$result['email'],
					'', // We don't return the password
					$result['birthday'],
					$result['profile_picture'],
					$result['created_at'],
					$result['updated_at']
				);
				// We add the User object to the array
				array_push($users, $user);
			}
			// We return the User object
			return $users;
		} else {
			// If the request returned no result, we return false
			throw new Exception("No user found.");
			return false;
		}
	}

	public static function getPrivilege($id)
	{
		$repo = new MainRepository("privilege");
		// We check if the request returned at least one result
		if ($repo->getOneBy([
			'user_id' => $id
		]) > 0) {
			// We get the result
			$privilege = $repo->getOneBy([
				'user_id' => $id
			]);
			// We return the User object
			return $privilege;
		} else {
			// If the request returned no result, we return false
			throw new Exception("No privilege found.");
			return false;
		}
	}

	public static function create()
	{
		// We check if the request returned at least one result
		if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['passwordCheck'])) {
			// We get the result
			$username = Tools::checkInput($_POST['username']);
			$email = Tools::checkInput($_POST['email']);
			$password = Tools::checkInput($_POST['password']);
			$passwordCheck = Tools::checkInput($_POST['passwordCheck']);

			// We check if the username and email are already taken with the UserManager::checkUsernameAndEmail() method
			if (!UserManager::checkUsernameAndEmail($username, $email)) {
				return false;
			} else {
				$username = UserManager::checkUsernameAndEmail($username, $email)['username'];
				$email = UserManager::checkUsernameAndEmail($username, $email)['email'];
			}

			// We check the password and email and get a hashed password and sanitize email with the UserManager::checkPasswordAndEmail() method
			if (!UserManager::checkPasswordAndEmail($password, $passwordCheck, $email)) {
				return false;
			} else {
				$email = UserManager::checkPasswordAndEmail($password, $passwordCheck, $email)['email'];
				$password = UserManager::checkPasswordAndEmail($password, $passwordCheck, $email)['password'];
			}

			// We create the user with the UserManager::createUser() method
			if (!UserManager::createUser($username, $email, $password)) {
				throw new Exception(UserManager::createUser($username, $email, $password));
				return false;
			} else {
				throw new Exception(UserManager::createUser($username, $email, $password));
			}
		} else {
			// If the request returned no result, we return false
			throw new Exception("No user found.");
			return false;
		}
	}

	public static function update()
	{
		$values = array(
			'id' => null,
			'username' => null,
			'firstname' => null,
			'lastname' => null,
			'email' => null,
			'birthday' => null,
			'profile_picture' => null,
			'currentPassword' => null,
			'newPassword' => null,
			'passwordCheck' => null
		);

		// If the updatedValue is empty, we fetch the value from the $_SESSION array
		foreach ($values as $key => $value) {
			if (
				$key !== 'passwordCheck' && $key !== 'newPassword' && $key !== 'currentPassword'
			) {
				$values[$key] = !empty($_POST[$key]) ? trim($_POST[$key]) : $_SESSION[$key];
			}
		}

		// We add the values for oldPassword, currentPassword and newPassword
		$values['currentPassword'] = !empty($_POST['currentPassword']) ? trim($_POST['currentPassword']) : null;
		$values['newPassword'] = !empty($_POST['newPassword']) ? trim($_POST['newPassword']) : null;
		$values['passwordCheck'] = !empty($_POST['passwordCheck']) ? trim($_POST['passwordCheck']) : null;

		// We use the UserManager::updateUser() method to update the user
		if (!UserManager::updateUser($values)) {
			throw new Exception(UserManager::updateUser($values));
			return false;
		} else {
			throw new Exception(UserManager::updateUser($values));
		}
	}

	public static function delete($id)
	{
		$repo = new MainRepository("user", $id);
		$repo->delete();
		// We check if the request returned at least one result
		if ($repo) {
			session_destroy();
			header('Refresh: 1; URL=./index.php');
			throw new Exception('The user has been deleted. You will be redirected to the home page in 1 seconds.', 200);
		} else {
			throw new Exception('An error occurred while deleting the user. The user has not been deleted.', 400);
		}
	}
}
