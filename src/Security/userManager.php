<?php

require_once './src/Repository/MainRepository.php';
require_once './src/lib/tools/Tools.php';


class UserManager extends MainRepository
{

	// We check if the username and email are already taken
	public static function checkUsernameAndEmail($username, $email)
	{
		// We check if the username is already taken, if so, we return an exception
		$repo = new MainRepository("user");
		$checkUsername = $repo->getOneBy(array('username' => $username));
		if ($checkUsername) {
			throw new Exception("The username is already taken.");
			return false;
		}

		// We check if the email is already taken, if so, we return an exception
		$repo = new MainRepository("user");
		$checkEmail = $repo->getOneBy(array('email' => $email));
		if ($checkEmail) {
			throw new Exception("The email is already taken.");
			return false;
		}

		return array(
			'username' => $username,
			'email' => $email
		);
	}

	// We check the password and email and return a hashed password and sanitize email
	public static function checkPasswordAndEmail($password, $passwordCheck, $email)
	{
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

		return array(
			'password' => $password,
			'email' => $email
		);
	}

	// We create a user in the user table,  the credential table, the privilege table and the newsletter table
	public static function createUser($username, $email, $password)
	{
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
	}

	// We check tha datas before updating the user
	public static function checkBeforeUpdate($values)
	{
		// We check if the username is already taken
		if ($values['username'] !== $_SESSION['username']) {
			$repo = new MainRepository("user");
			$sql = $repo->getOneBy(array('username' => $values['username']));
			if ($sql) {
				throw new Exception('This username is already taken.');
			}
		}

		// We check if the email is already taken
		if ($values['email'] !== $_SESSION['email']) {
			$repo = new MainRepository("user");
			$sql = $repo->getOneBy(array('email' => $values['email']));
			if ($sql) {
				throw new Exception('This email is already taken.');
			}
		}

		// We check if the profile picture is valid
		if (!empty($_FILES['profile_picture']['name'])) {
			$checkPicture = Tools::uploadPicture('profile_picture');
			if (!$checkPicture) {
				throw new Exception();
			} else {
				$values['profile_picture'] = $checkPicture;
			}
		}

		// We check if the birthday is valid
		if ($values['birthday'] !== $_SESSION['birthday']) {
			if (!Tools::checkBirthday($values['birthday'])) {
				throw new Exception('The birthday is not valid.');
			}
			// We replace the birthday format for the database(datetime)
			$values['birthday'] = date('Y-m-d', strtotime($values['birthday']));
		} else {
			// We replace the birthday format for the database(datetime)
			$values['birthday'] = date('Y-m-d', strtotime($values['birthday']));
		}

		// We check if the old password matches the hashed one in credentials table, is different from the new password and is valid. We get the password from the credentials table
		if (!empty($values['currentPassword']) && !empty($values['newPassword']) && !empty($values['passwordCheck'])) {
			$repo = new MainRepository("credentials", $values['id']);
			$hashedPassword = $repo->getOneBy(array('user_id' => $values['id']));
			// We check if the password matches the hashed one
			if (password_verify((string)$values['currentPassword'], (string)$hashedPassword['password']) === false) {
				throw new Exception('The old password is not valid.');
			}
			// We check if the password is valid
			if (!Tools::checkPassword($values['newPassword'], $values['passwordCheck'])) {
				throw new Exception('The password is not valid. Must be least 8 characters long, contains at least one uppercase letter, one lowercase letter, one number and one special character');
			}
			// We check if the password matches the password check
			if ($values['newPassword'] !== $values['passwordCheck']) {
				throw new Exception('The passwords do not match.');
			}
			// We hash the password
			$values['newPassword'] = password_hash($values['newPassword'], PASSWORD_DEFAULT);
		}

		// We sanitize the email
		if ($values['email'] !== $_SESSION['email']) {
			$values['email'] = filter_var($values['email'], FILTER_SANITIZE_EMAIL);
		}

		return $values;
	}

	// We update a user in the user table, the credential table and the newsletter table
	public static function updateUser($values)
	{
		// We check the datas before updating the user
		$updatedValues = self::checkBeforeUpdate($values);

		// We update the user in the user table
		foreach ($updatedValues as $key => $value) {
			if ($key !== 'id' && $key !== 'passwordCheck' && $key !== 'currentPassword' && $key !== 'newPassword') {
				$repo = new MainRepository("user", $values['id']);
				$repo->update([
					$key => $value
				]);
				if (!$repo) {
					throw new Exception('An error occurred while updating your account.');
				}
			}
			// We update the username and password in the credential table
			if ($key === 'username') {
				$repo = new MainRepository("credentials", null, 'user_id', $values['id']);
				$repo->update([
					$key => $value
				]);
				if (!$repo) {
					throw new Exception('An error occurred while updating your account.');
				}
			}
			if ($key === 'newPassword' && !empty($value)) {
				$repo = new MainRepository("credentials", null, 'user_id', $values['id']);
				$repo->update([
					'password' => $value
				]);
				if (!$repo) {
					throw new Exception('An error occurred while updating your account.');
				}
			}
			// We update the user in the newsletter table
			if ($key === 'email') {
				// we get the id from the newsletter table
				$repo = new MainRepository("newsletter", null, 'email', $_SESSION['email']);
				$id = $repo->getOneBy([
					'email' => $_SESSION['email']
				])['id'];
				$repo = new MainRepository("newsletter", $id);
				$repo->update([
					$key => $value
				]);
				if (!$repo) {
					throw new Exception('An error occurred while updating your account.');
				}
			}
		}

		// We update the profile in the user Session
		foreach ($updatedValues as $key => $value) {
			if ($key !== 'passwordCheck' && $key !== 'currentPassword' && $key !== 'newPassword') {
				$_SESSION[$key] = $value;
			}
		}

		// We check if the user has been updated
		if ($repo) {
			header('Refresh: 1; URL=./index.php?page=userProfile&action=getOne&option=user&id=' . $values['id'] . '');
			throw new Exception('Your account has been updated. You will be redirected to the profile page in 1 seconds.', 200);
		} else {
			throw new Exception('An error occurred while updating your account.');
		}
	}
}
