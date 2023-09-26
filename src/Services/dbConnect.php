<?php

require_once __DIR__ . '/../../config/config.local.php';
abstract class databaseConnect
{
	// PDO Object to connect to the database
	private static $db;


	/* #Region Execute a SQL query which will eventually contain parameters */
	protected static function executeRequest($sql, $params = null)
	{
		if ($params === null) {
			$result = self::dbConnect()->query($sql);    // direct execution
		} else {
			$result = self::dbConnect()->prepare($sql);  // prepared request
			$result->execute($params);
		}
		return $result;
	}
	/* #EndRegion */

	/* #Region Get the PDO object to connect to the database */
	private static function dbConnect()
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
	/* #EndRegion */

	/* #Region Get the last inserted id */
	protected static function getLastInsertedId()
	{
		return self::dbConnect()->lastInsertId();
	}
	/* #EndRegion */
}
