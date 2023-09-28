<?php

require_once './src/Repository/MainRepository.php';

class Newsletter
{
	/* #Region We subscribe a user to the newsletter */
	static public function subscribe()
	{

		// We collect the email address to add the subscriber
		$email = $_POST['email'];

		// We check if the email address is not empty
		if (!empty($email)) {
			// We check if the email address is valid
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				// We check if the email address is already in the database
				$repo = new MainRepository("newsletter");
				$subscriber = $repo->getOneBy([
					'email' => $email
				]);
				if ($subscriber) {
					// If the email address is already in the database, we check if the status is 'active'
					if ($subscriber['status'] == 'active') {
						// If the status is 'active', we change the status to 'inactive'
						$repo = new MainRepository("newsletter", null, 'email', $email);
						$id = $repo->getOneBy([
							'email' => $email
						])['id'];
						$repo = new MainRepository("newsletter", $id);
						$repo->update([
							'status' => 'inactive'
						]);
						// We throw a message to confirm the unsubscription
						throw new \Exception("You have been successfully unsubscribed", 200);
					} else {
						// If the status is 'inactive', we update the status to 'active'
						$repo = new MainRepository("newsletter", null, 'email', $email);
						$id = $repo->getOneBy([
							'email' => $email
						])['id'];
						$repo = new MainRepository("newsletter", $id);
						$repo->update([
							'status' => 'active'
						]);
						// We redirect the user to the userProfile page after 3 seconds
						session_start();
						header("Refresh:3; url=index.php?page=userProfile&action=getOne&option=user&id=" . $_SESSION['user_id']);
						throw new \Exception("You have been successfully registered", 200);
					}
				} else {
					// If the email address is not in the database, we add it
					$repo = new MainRepository("newsletter");
					$repo->create([
						'email' => $email
					]);
					// We redirect the user to the userProfile page after 3 seconds
					session_start();
					header("Refresh:3; url=index.php");
					throw new \Exception("You have been successfully registered", 200);
				}
			} else {
				// If the email address is not valid, we return an error message
				throw new \Exception("This email address is not valid", 400);
			}
		} else {
			// If the email address is empty, we return an error message
			throw new \Exception("The email address is empty", 400);
		}
	}
	/* #EndRegion */


	/* #Region We unsubscribe a user from the newsletter */
	static public function unsubscribe()
	{
		// We collect the email address to add the subscriber
		$email = $_POST['email'];

		// We check if the email address is not empty
		if (!empty($email)) {
			// We check if the email address is valid
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				// We check if the email address is already in the database
				$repo = new MainRepository("newsletter");
				$subscriber = $repo->getOneBy([
					'email' => $email
				]);
				if ($subscriber) {
					// If the email address is already in the database, we update the status to 'inactive'
					$repo = new MainRepository("newsletter", null, 'email', $email);
					$id = $repo->getOneBy([
						'email' => $email
					])['id'];
					$repo = new MainRepository("newsletter", $id);
					$repo->update([
						'status' => 'inactive'
					]);
					// We redirect the user to the profile page after 3 seconds
					session_start();
					header("Refresh:3; url=index.php?page=userProfile&action=getOne&option=user&id=" . $_SESSION['user_id']);
					// We return a success message
					throw new Exception("You have been successfully unsubscribed", 200);
				} else {
					// If the email address is not in the database, we return an error message
					throw new Exception("This email address is not registered", 400);
				}
			} else {
				// If the email address is not valid, we return an error message
				throw new Exception("This email address is not valid", 400);
			}
		} else {
			// If the email address is empty, we return an error message
			throw new Exception("The email address is empty", 400);
		}
	}
	/* #EndRegion */


	/* #Region We get the status of a subscriber */
	static public function getStatus($email)
	{
		// We check if the email address is not empty
		if (!empty($email)) {
			// We check if the email address is valid
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				// We check if the email address is already in the database
				$repo = new MainRepository("newsletter");
				$subscriber = $repo->getOneBy([
					'email' => $email
				]);
				if ($subscriber) {
					// If the email address is already in the database, we return the status
					return $subscriber['status'];
				} else {
					// If the email address is not in the database, we return an error message
					throw new Exception("This email address is not registered", 400);
				}
			} else {
				// If the email address is not valid, we return an error message
				throw new Exception("This email address is not valid", 400);
			}
		} else {
			// If the email address is empty, we return an error message
			throw new Exception("The email address is empty", 400);
		}
	}
	/* #EndRegion */
}
