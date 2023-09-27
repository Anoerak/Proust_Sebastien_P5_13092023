<?php

require_once "./src/Repository/MainRepository.php";
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
		if ($repo->getPrivilege($id) > 0) {
			// We get the result
			$privileges = $repo->getPrivilege($id);
			// We return the User object
			return $privileges;
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

			// We check if the username is already taken
			$repo = new MainRepository("user", null, "username", $username);
			if ($repo->getOne(null, null, null) > 0) {
				throw new Exception("This username is already taken.");
				return false;
			}

			// We check if the email is already taken
			$repo = new MainRepository("user", null, "email", $email);
			if ($repo->getOne(null, null, null) > 0) {
				throw new Exception("This email is already taken.");
				return false;
			}

			// We check if the passwords match
			if ($password != $passwordCheck) {
				throw new Exception("The passwords do not match.");
				return false;
			}

			// We check if the password is valid
			if (!Tools::checkPassword($password, $passwordCheck)) {
				throw new Exception("The password is not valid. Must be least 8 characters long, contains at least one uppercase letter, one lowercase letter, one number and one special character.");
				return false;
			}

			// Hash the password & the email
			$password = password_hash($password, PASSWORD_DEFAULT);

			// Sanitize the email
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);

			// We create the user in the user table
			$repo = new MainRepository("user");
			$repo->create([
				'username' => $username,
				'email' => $email
			]);

			// We get the user id which by getting the last user created
			$repo = new MainRepository("user");
			$id = $repo->getLastInsertedId();

			// We create the user in the credential table
			$repo = new MainRepository("credentials");
			$repo->create([
				'username' => $username,
				'password' => $password,
				'user_id' => $id
			]);

			// We create the user in the privilege table
			$repo = new MainRepository("privilege");
			$repo->create([
				'user_id' => $id
			]);

			// We create the user in the newsletter table
			$repo = new MainRepository("newsletter");
			$repo->create([
				'email' => $email
			]);

			// We check if the user has been created
			if ($repo) {
				header('Refresh: 1; URL=./index.php?page=login');
				throw new Exception("Your account has been created. You will be redirected to the login page in 1 seconds.", 200);
			} else {
				throw new Exception("An error occurred while creating the user.");
				return false;
			}
		} else {
			// If the request returned no result, we return false
			throw new Exception("No user found.");
			return false;
		}
	}

	public static function update()
	{
		$updatedValues = array(
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
		foreach ($updatedValues as $key => $value) {
			if ($key !== 'passwordCheck' && $key !== 'newPassword' && $key !== 'currentPassword') {
				if (empty($_POST[$key])) {
					$updatedValues[$key] = $_SESSION[$key];
				} else {
					$updatedValues[$key] = Tools::checkInput($_POST[$key]);
				}
			}
		}

		// We add the values for oldPassword, currentPassword and newPassword
		$updatedValues['currentPassword'] = !empty($_POST['currentPassword']) ? trim($_POST['currentPassword']) : null;
		$updatedValues['newPassword'] = !empty($_POST['newPassword']) ? trim($_POST['newPassword']) : null;
		$updatedValues['passwordCheck'] = !empty($_POST['passwordCheck']) ? trim($_POST['passwordCheck']) : null;

		// We check if the username is already taken
		$repo = new MainRepository("user", null, "username", $updatedValues['username']);
		if ($repo->getOne(null, null, null) > 0) {
			throw new Exception("This username is already taken.");
			return false;
		}

		// We check if the email is already taken
		$repo = new MainRepository("user", null, "email", $updatedValues['email']);
		if ($repo->getOne(null, null, null) > 0) {
			throw new Exception("This email is already taken.");
			return false;
		}

		// We check if the birthday is valid
		if (!empty($updatedValues['birthday'])) {
			if (!Tools::checkBirthday($updatedValues['birthday'])) {
				throw new Exception("The birthday is not valid.");
				return false;
			}
			// We replace the birthday format for the database(datetime)
			$updatedValues['birthday'] = date('Y-m-d', strtotime($updatedValues['birthday']));
		} else {
			$updatedValues['birthday'] = date('Y-m-d', strtotime($updatedValues['birthday']));
		}

		// We check if the profile picture is valid
		if (!empty($_FILES['profile_picture']['name'])) {
			$checkPicture = Tools::uploadPicture('profile_picture');
			if (!$checkPicture) {
				throw new Exception();
			} else {
				$updatedValues['profile_picture'] = $checkPicture;
			}
		}

		// We check if the old password matches the hashed one in credentials table, is different from the new password and is valid
		// We get the password from the credentials table
		if (!empty($updatedValues['currentPassword']) && !empty($updatedValues['newPassword']) && !empty($updatedValues['passwordCheck'])) {
			$repo = new MainRepository("credentials", null, "user_id", $_SESSION['id']);
			$result = $repo->getOne(null, null, null);
			// We check if the old password matches the hashed one in credentials table
			if (password_verify($updatedValues['currentPassword'], $result['password'])) {
				// We check if the old password is different from the new password
				if ($updatedValues['currentPassword'] !== $updatedValues['newPassword']) {
					// We check if the new password is valid
					if (Tools::checkPassword($updatedValues['newPassword'], $updatedValues['passwordCheck'])) {
						// We hash the new password
						$updatedValues['newPassword'] = password_hash($updatedValues['newPassword'], PASSWORD_DEFAULT);
					} else {
						throw new Exception("The new password is not valid. Must be least 8 characters long, contains at least one uppercase letter, one lowercase letter, one number and one special character.");
						return false;
					}
				} else {
					throw new Exception("The old password and the new password must be different.");
					return false;
				}
			} else {
				throw new Exception("The old password is not correct.");
				return false;
			}
		}

		// We sanitize the email
		$updatedValues['email'] = filter_var($updatedValues['email'], FILTER_SANITIZE_EMAIL);

		// We update the user in the user table
		$repo = new MainRepository("user", $_SESSION['id']);
		foreach ($updatedValues as $key => $value) {
			if ($key !== 'id' && $key !== 'currentPassword' && $key !== 'newPassword' && $key !== 'passwordCheck') {
				$repo->update($key, $value);

				if (!$repo) {
					throw new Exception("An error occurred while updating the user.");
					return false;
				}
			}
		}

		// We update the user in the credentials table
		if (!empty($updatedValues['newPassword'])) {
			$repo = new MainRepository("credentials", null, "user_id", $_SESSION['id']);
			$repo->update('password', $updatedValues['newPassword']);

			if (!$repo) {
				throw new Exception("An error occurred while updating the user.");
				return false;
			}
		}
		if (!empty($updatedValues['username'])) {
			$repo = new MainRepository("credentials", null, "user_id", $_SESSION['id']);
			$repo->update('username', $updatedValues['username']);

			if (!$repo) {
				throw new Exception("An error occurred while updating the user.");
				return false;
			}
		}

		// We update the user in the profile picture
		if (!empty($updatedValues['profile_picture'])) {
			$repo = new MainRepository("user", $_SESSION['id']);
			$repo->update('profile_picture', $updatedValues['profile_picture']);

			if (!$repo) {
				throw new Exception("An error occurred while updating the user.");
				return false;
			}
		}

		// We check if the user has been updated 
		if ($repo) {
			// We update the $_SESSION array
			foreach ($updatedValues as $key => $value) {
				if ($key !== 'currentPassword' && $key !== 'newPassword' && $key !== 'passwordCheck') {
					$_SESSION[$key] = $value;
				}
			}
			header('Refresh: 1; URL=./index.php?page=profile');
			throw new Exception("Your account has been updated. You will be redirected to the profile page in 1 seconds.", 200);
		} else {
			throw new Exception("An error occurred while updating the user.");
			return false;
		}
	}

	public static function delete($id)
	{
		$repo = new MainRepository("user", $id);
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
