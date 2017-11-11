<?php

require_once("../db/connect.php");

// Create table 
try
{
	$conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pw);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "CREATE TABLE IF NOT EXISTS users (
	id serial PRIMARY KEY NOT NULL,
	username VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	confirm_code INTEGER NULL, 
	creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	privilege VARCHAR(255) NOT NULL DEFAULT 'user',
	validation BOOLEAN NOT NULL DEFAULT 'f'
	);";
	$conn->exec($sql);
}
catch(PDOException $e)
{
	echo $sql."<br>".$e->getMessage();
}
// end connection
$conn = null;
?>
