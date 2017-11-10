<?php
	require("../includes/helper.php");
	require_once("../db/connect.php");

	// getting the values from the email activation link query
	$username = $_GET["username"];
	$code = $_GET["code"];

	$query = $conn->prepare("SELECT * FROM users WHERE username = :username);");
	$query->bindParam(':username', $username);
	while ($row = // get associative array from query)
	{
		// get confirm_code from user's table and check if it matches with link query code
		$db_code = $row['confirm_code'];
	}
	// code from url == code in db
	if ($code == $db_code)
	{
		// create 2 queries to UPDATE the user table/details
			// Update validation to true
			// Update confirm-code to zero / NULL value
	}
	else
		render("error.php", ["message"=>"Username and code do not match"]);
	render("success.php", ["title"=>"Email Confirmation", "message"=>"Your account is now activated."]);
?>
