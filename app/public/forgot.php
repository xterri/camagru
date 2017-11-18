<?php
	require("../includes/helper.php");
	require_once("../includes/admin_functions.php");

	if ($_SERVER["REQUEST_METHOD"] == "GET")
		render("forgot_form.php", ["title"=>"Forgot Password"]);
	else if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (empty($_POST["email"]))
			render("error.php", ["message"=>"Email Required"]);
		// check if account exists
		if (!(email_exists($_POST["email"])))
			render("error.php", ["message"=>"User does not exist"]);
		$results = get_user_info_by_email($_POST["email"]);
		$user_db = $results['username'];
		$confirm_code = rand();
		$email = $results['email'];

		// send email msg to user to reset password
		$msg = "Click the link below to change your password
				http://192.168.99.100:8088/public/reset.php?username=$user_db&code=$confirm_code";

		// requires "mail(<email address>, <subject title>, <msg>, <sender/src email>)" function
		mail($email, "Change your Password on Camagru", $msg, "From: donotreply@camagru.com");

		update_validation($user_db, $confirm_code, 'f');
		// will need to pass registeration values & render the button click to an "register complete" page
		render("success.php", ["message"=>"An email has been sent. Please check it to change your password"]);
	}
?>
