<?php
	require("../includes/helper.php");
	require_once("../db/connect.php");

	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if (empty($_GET['username']))
			render("error.php", ["message"=>"Why are you here?"]);
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
		if ($code == $db_code && $username == $user_db)
		{
			// create 2 queries to UPDATE the user table/details
			// Update validation to true
			$stmt = "UPDATE users SET validation='t' WHERE username='$username'";
			$conn->exec($stmt);
			// Update confirm-code to zero / NULL value
			$stmt = "UPDATE users SET confirm_code='0' WHERE username='$username'";
			$conn->exec($stmt);
			$_SESSION['user'] = $username;
			render("reset_form.php", ["title"=>"Reset Password"]);
		}
		else
			render("error.php", ["message"=>"Link provided has expired."]);
	}
	elseif ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// if request method = post. allow user to be able to change their password (reset_form)
		if (empty($_POST["new_pw"]) || empty($_POST["confirm"]))
			render("error.php", ["message"=>"Please fill in all forms"]);
		elseif ($_POST["new_pw"] != $_POST["confirm"])
			render("error.php", ["message"=>"Passwords do not match"]);
		elseif ((strlen($_POST["new_pw"])) < 6) {
			render("error.php", ["message"=>"Password needs to have at least 6 characters"]);
		}
		elseif (!(preg_match('~[A-Z]~', $_POST["new_pw"])) ||
				!(preg_match('~\d~', $_POST["new_pw"]))) {
			render("error.php", ["message"=>"Your password must include at least one uppercase and one digit"]);
		}
		$user_ses = $_SESSION['user'];
		$query = $conn->prepare("SELECT * FROM users WHERE username='$user_ses'");
		$query->execute();
		while ($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			$id = $row['id'];
			$user_id = $row['username'];
		}
		if ($user_id == $_SESSION["user"])
		{
			$stmt = $conn->prepare("UPDATE users SET password = :password WHERE username = :username;");
			$stmt->bindParam(':username', $_SESSION['user']);
			$stmt->bindParam(':password', password_hash($_POST["new_pw"], PASSWORD_DEFAULT));
			$stmt->execute();
			// set session_id if successful
			$_SESSION["id"] = $id;
			$_SESSION['user'] = NULL;
			render("success.php", ["message"=>"Your password has been reset."]);
		}
		render("error.php", ["message"=>"Something went wrong"]);
	}
?>
