<?php
	require("../includes/helper.php");
	require("../includes/admin_functions.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["new_email"]) || empty($_POST["pw"]))
			render("settings.php", ["message"=>"Please fill in everything"]);
		else {
			$results = get_user_info_by_id($_SESSION["id"]);
			$pw_db = $results["password"];
			$name = $results["username"];
			$email = $results["email"];
			if (password_verify($_POST["pw"], $pw_db)) {
				// send activation email to old email for confirmation
					// good or bad idea? should it just change to the new email?
					// or send a link to 'undo' the changes if user did not request it?
				$new_email = $_POST["new_email"];
				$confirm_code = rand();
				$msg = "Click the link to confirm the new email change to $new_email: 
						http://192.168.99.100:8088/public/activate_email.php?email=$new_email&username=$name&code=$confirm_code";
				mail($email, "Confirm the Email Change", $msg, "From: donotreply@camagru.com");
				update_validation($name, $confirm_code, 'f');
				render("success.php", ["message"=>"An email has been sent to your previous address. Please confirm the email change."]);
			}
			else 
				render("settings.php", ["message"=>"Incorrect password. Cannot change to new email"]);
		}
	}
	elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
		if (!empty($_SESSION["id"]))
			render("settings.php", ["title"=>"Settings"]);
		render("error.php", ["message"=>"Please login to access this page"]);
	}
?>
