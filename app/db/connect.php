<?php

$host = "db";
$db = "cama_db";
$user = "cama_user";
$pw = "password";

	try 
	{
		$conn = new PDO("pgsql:host=$host;dbname=$db;user=$user;password=$pw");
		// set PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// display a message if connected to the PostgreSQL successfully
			// echo "Connected to the <strong>cama_db</strong> database successfully!";
	}
	catch (PDOException $e)
	{
		// report error message
		echo "Connection failed: ".$e->getMessage();
		//closes the connection
		$conn = null;
	}
?>
