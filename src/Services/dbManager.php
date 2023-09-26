<?php

require_once __DIR__ . '/../../config/config.local.php';

abstract class dbManager
{
	// PDO Object to connect to the database
	private static $db;

	// Get the PDO object to connect to the database
	protected function dbConnect()
	{
		if (self::$db === null) {
			// Create the PDO object and store the connection in the attribute $db
			self::$db = new PDO(
				'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . DB_PORT . ';charset=utf8',
				DB_USER,
				DB_PASSWORD,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
			);
		}

		return self::$db;
	}
}
