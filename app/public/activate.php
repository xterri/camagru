<?php
	require("../includes/helper.php");
	require_once("../db/connect.php");

	// getting the values from the email activation link query
	$username = $_GET["username"];
	$code = $_GET["code"];

	$query = $conn->prepare("SELECT * FROM users WHERE username='$username'");
	$query->execute();
	while ($row = $query->fetch(PDO::FETCH_ASSOC))
	{
		// get confirm_code from user's table and check if it matches with link query code
		$db_code = $row['confirm_code'];
		$user_db = $row['username'];
		// get_id value to set session_id
		$id = $row['id'];
	}
	echo "id: ".$id."\nusername: ".$user_db."\ndb_code: ".$db_code;
	// code from url == code in db; unnecessary to check username from GET and username from db?
	if ($code == $db_code && $username == $user_db)
	{
		// create 2 queries to UPDATE the user table/details
		// Update validation to true
		$stmt = "UPDATE users SET validation='t' WHERE username='$username'";
		$conn->exec($stmt);
		// Update confirm-code to zero / NULL value
		$stmt = "UPDATE users SET confirm_code='0' WHERE username='$username'";
		$conn->exec($stmt);
		// set session_id if successful
		$_SESSION["id"] = $id;
		render("success.php", ["title"=>"Email Confirmation", "message"=>"Your account is now activated."]);
	}
	else
		render("error.php", ["message"=>"Username and code do not match"]);
?>
