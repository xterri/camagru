<?php
	require("../includes/helper.php");
	require_once("../db/connect.php");
	
	if ($_SERVER["REQUEST_METHOD"] == "GET")
		render("register_form.php", ["title"=>"Register"]);
	elseif ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (empty($_POST["user"]) || empty($_POST["password"]) || empty($_POST["confirm"] || empty($_POST["email"]))) { 
			render("error.php", ["message"=>"Please complete all fields"]);
		}
		elseif ($_POST["password"] != $_POST["confirm"]) {
			render("error.php", ["message"=>"Passwords do not match. Please try again"]);
		}
		// check if password has at least an uppercase, a digit, and is 6 characters long
		elseif ((strlen($_POST["password"])) < 6) {
			render("error.php", ["message"=>"Password needs to have at least 6 characters"]);
		}
		elseif (!(preg_match('~[A-Z]~', $_POST["password"])) ||
				!(preg_match('~[a-z]~', $_POST["password"])) ||
				!(preg_match('~\d~', $_POST["password"]))) {
			render("error.php", ["message"=>"Password not secure enough. Password must include at least one uppercase and one digit"]);
		}
		// check that a valid email is entered, unnecessary?
		elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			render("error.php", ["message"=>"Please enter a valid email"]);
		}
		else
		{
			$host = "db";
			$db = "cama_db";
			$user = "cama_user";
			$pw = "password";

			//try {
			//	$conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pw);
			//	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//}
			//catch (PDOException $e) {
			//	render("error.php", ["message"=>"Unable to create user account"."<br>Error: ".$e->getMessage()]);
			//}
			$user_db = $_POST["user"];
			$pw_db = password_hash($_POST["password"], PASSWORD_DEFAULT);
			$email = $_POST["email"];

			// check if username already exists
			$check_user = $conn->prepare("SELECT user FROM users WHERE user = :user");
			$check_user->bindParam(':user', $user_db);
			$check_user->execute();
			if ($check_user->rowCount() > 0) {
				render("error.php", ["message"=>"Username already exists."]);
			}

			// check if email already exists
			$check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
			$check_email->bindParam(':email', $email);
			$check_email->execute();
			if ($check_email->rowCount() > 0) {
				render("error.php", ["message"=>"Email already in use."]);
			}

			$stmt = $conn->prepare("INSERT INTO users (user, email, password) 
									VALUES (:user, :email, :password);");
			$stmt->bindParam(':user', $user_db);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':password', $pw_db);
			$stmt->execute();
			
			$id = $conn->lastInsertId();
			session_start();
			$_SESSION["id"] = $id;
			redirect("/public/index.php");
		}
	}
?>
