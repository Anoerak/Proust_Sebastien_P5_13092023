<?php

require_once __DIR__ . '/../../config/config.local.php';
abstract class DbConnect
{
	// PDO Object to connect to the database
	private static $db;


	/* #Region Execute a SQL query which will eventually contain parameters */
	protected static function executeRequest($sql, $params = null)
	{
		if ($params === null) {
			$result = self::getDb()->query($sql);    // direct execution
		} else {
			$result = self::getDb()->prepare($sql);  // prepared request
			$result->execute($params);
		}
		return $result;
	}
	/* #EndRegion */

	/* #Region Get the PDO object to connect to the database */
	private static function getDb()
	{
		if (self::$db === null) {
			// Create the PDO object and store the connection in the attribute $db
			// Development Server

			// Windows
			// $host = DB_HOST;
			// $port = DB_PORT;

			// MAC
			$host = DB_HOST;
			$port = DB_PORT;

			$db = DB_NAME;
			$user = DB_USER;
			$password = DB_PASSWORD;


			self::$db = new PDO(
				'mysql:host=' . $host . ';dbname=' . $db . ';port=' . $port . ';charset=utf8',
				$user,
				$password,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
			);
		}

		return self::$db;
	}
	/* #EndRegion */

	/* #Region Get the last inserted id */
	protected static function getLastInsertedId()
	{
		return self::getDb()->lastInsertId();
	}
	/* #EndRegion */
}
