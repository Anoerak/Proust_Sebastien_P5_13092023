<?php

require_once __DIR__ . '/../../config/config.local.php';
require_once __DIR__ . '/../lib/tools/Tools.php';

class Mailer
{
	static public function send()
	{
		// We get the blogmaster's email
		$blogmasterEmail = "seb@iamseb.dev";

		// We get the information from the contact form
		$contactName = $_POST['contactName'];
		$contactEmail = $_POST['contactEmail'];
		$contactSubject = $_POST['contactSubject'];
		$contactMessage = $_POST['contactMessage'];
		$honeypot = $_POST['honeypot'];


		// We check if the honeypot is empty
		if (!empty($honeypot)) {
			// We return an error message
			throw new \Exception("You are a bot.", 400);
		}
		// We check if the email is valid
		if (Tools::checkEmail($contactEmail)) {
			// We check if the name is not empty
			if (!empty($contactName)) {
				// We check if the subject is not empty
				if (!empty($contactSubject)) {
					// We check if the message is not empty
					if (!empty($contactMessage)) {
						// We set the headers
						// Production will use $headers = "From: daemon@iamseb.dev";
						// Development
						$headers  = 'MIME-Version: 1.0' . "\r\n"
							. 'Content-type: text/html; charset=utf-8' . "\r\n"
							. 'From: daemon@iamseb.dev' . "\r\n"
							. 'To: ' . $blogmasterEmail . "\r\n"
							. 'Reply-To: ' . $contactEmail . "\r\n";
						$headers2  = 'MIME-Version: 1.0' . "\r\n"
							. 'Content-type: text/html; charset=utf-8' . "\r\n"
							. 'From: daemon@iamseb.dev' . "\r\n"
							. 'To: ' . $contactEmail . "\r\n";
						// We set the message
						$message = "You received a message from " . $contactName . " with the email address " . $contactEmail . ".\n\n" . $contactMessage;
						// We send the email to the blogmaster
						mail($blogmasterEmail, $contactSubject, $message, $headers);
						// We send the email to the user
						mail($contactEmail, "Your message has been sent", "Your message has been sent. We will answer you as soon as possible.", $headers2);
						// We return a success message
						header('Refresh: 5; URL=/index.php');
						throw new \Exception("Your message has been sent. We will answer you as soon as possible.", 200);
					} else {
						// We return an error message
						throw new \Exception("Please enter a message.", 400);
					}
				} else {
					// We return an error message
					throw new \Exception("Please enter a subject.", 400);
				}
			} else {
				// We return an error message
				throw new \Exception("Please enter a name.", 400);
			}
		} else {
			// We return an error message
			throw new \Exception("Please enter a valid email address.", 400);
		}
	}
}
