<?php
	require("../includes/helper.php");
	require("../includes/admin_functions.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["pw"]) || empty($_POST["new_pw"]) || empty($_POST["confirm"]))
			render("settings.php", ["message"=>"Please fill in everything"]);
		elseif ($_POST["new_pw"] != $_POST["confirm"])
			render("settings.php", ["message"=>"New passwords do not match"]);
		elseif ((strlen($_POST["new_pw"])) < 6)
			render("settings.php", ["message"=>"Password needs to have at least 6 characters"]);
		elseif (!(preg_match('~[A-Z]~', $_POST["new_pw"])) ||
				!(preg_match('~\d~', $_POST["new_pw"])))
				render("settings.php", ["message"=>"Your password must include at least one uppercase and one digit"]);
		else {
			$results = get_user_info_by_id($_SESSION["id"]);
			$old_pw = $results["password"];
			$name = $results["username"];
			if (!(password_verify($_POST["pw"], $old_pw)))
				render("settings.php", ["message"=>"Incorrect password. Cannot update with the new password"]);
			else {
				update_password($name, password_hash($_POST["new_pw"], PASSWORD_DEFAULT));
				render("success.php", ["message"=> "Password successfully changed"]);
			}
		}
	}
	elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
		if (!empty($_SESSION["id"]))
			render("settings.php", ["title"=>"Settings"]);
		render("error.php", ["message"=>"Please login to access this page"]);
	}
?>
