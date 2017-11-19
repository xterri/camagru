<?php
	require("../includes/helper.php");
	require_once("../includes/admin_functions.php");

	if (!empty($_GET['username'])) {
		// getting the values from the email activation link query
		$username = $_GET["username"];
		$code = $_GET["code"];
		$email = $_GET["email"];

		$results = get_user_info_by_name($username);
		$db_code = $results['confirm_code'];
		$user_db = $results['username'];
		// get_id value to set session_id
		$id = $results['id'];
	
		// code from url == code in db; unnecessary to check username from GET and username from db?
		if ($code == $db_code && $username == $user_db)
		{
			// create 2 queries to UPDATE the user table/details
			// Update validation to true & confirm_code to zero / NULL value
			update_validation($username, 0, 't');
			update_email($user_db, $email); 
			// set session_id if successful
			$_SESSION["id"] = $id;
			$_SESSION["name"] = $user_db;
			render("success.php", ["title"=>"Email Confirmation", "message"=>"Your email has been changed."]);
		}
		else
			render("error.php", ["message"=>"Username and code do not match"]);
	}
	render("error.php");
?>
