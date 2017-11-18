<?php
	require("../includes/helper.php");
	require_once("../includes/admin_functions.php");

	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if (empty($_GET['username']))
			render("error.php", ["message"=>"Why are you here?"]);
		// getting the values from the email activation link query
		$username = $_GET["username"];
		$code = $_GET["code"];

		$results = get_user_info_by_name($username);

		$db_code = $results['confirm_code'];
		$user_db = $results['username'];
		// get_id value to set session_id
		$id = $results['id'];

		if ($code == $db_code && $username == $user_db)
		{
			$_SESSION['code'] = $code;
			$_SESSION['user'] = $username;
			render("reset_form.php", ["title"=>"Reset Password"]);
		}
		else
			render("error.php", ["message"=>"Link provided has expired."]);
	}
	elseif ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$user_ses = $_SESSION['user'];
		// create 2 queries to UPDATE the user table/details
		// Update validation to true and update confirm_code = 0 / NULL value
		update_validation($user_ses, 0, 't');
		// link immediately expires once user enters the "post" section
		$_SESSION['code'] = NULL;
		// if request method = post. allow user to be able to change their password (reset_form)
		if (empty($_POST["new_pw"]) || empty($_POST["confirm"]))
			render("reset_form.php", ["message"=>"Please enter a password"]);
		elseif ($_POST["new_pw"] != $_POST["confirm"])
			render("reset_form.php", ["message"=>"Passwords did not match"]);
		elseif ((strlen($_POST["new_pw"])) < 6) {
			render("reset_form.php", ["message"=>"Password needs to have at least 6 characters"]);
		}
		elseif (!(preg_match('~[A-Z]~', $_POST["new_pw"])) ||
				!(preg_match('~\d~', $_POST["new_pw"]))) {
			render("reset_form.php", ["message"=>"Your password must include at least one uppercase and one digit"]);
		}
		$results = get_user_info_by_name($user_ses);

		$id = $results['id'];
		$user_id = $results['username'];

		if ($user_id == $_SESSION["user"])
		{
			$pw = password_hash($_POST["new_pw"], PASSWORD_DEFAULT);
			update_password($user_id, $pw);

			// set session_id if successful
			$_SESSION["id"] = $id;
			$_SESSION['user'] = NULL;
			render("success.php", ["message"=>"Your password has been reset."]);
		}
		render("error.php", ["message"=>"Something went wrong"]);
	}
?>
