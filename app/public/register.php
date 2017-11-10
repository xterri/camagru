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
				!(preg_match('~\d~', $_POST["password"]))) {
			render("error.php", ["message"=>"Your password must include at least one uppercase and one digit"]);
		}
		// check that a valid email is entered, unnecessary?
		elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			render("error.php", ["message"=>"Please enter a valid email"]);
		}
		else
		{
			try {
				$conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pw);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e) {
				render("error.php", ["message"=>"Unable to create user account"."<br>Error: ".$e->getMessage()]);
			}
			$user_db = $_POST["user"];
			$pw_db = password_hash($_POST["password"], PASSWORD_DEFAULT);
			$email = $_POST["email"];

			// confirmation code generated by a random number for activation
			$confirm_code = rand();

			// check if username already exists
			$check_user = $conn->prepare("SELECT username FROM users WHERE username = :username");
			$check_user->bindParam(':username', $user_db);
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

			$stmt = $conn->prepare("INSERT INTO users (username, email, password, confirm_code) 
									VALUES (:username, :email, :password, :confirm_code);");
			$stmt->bindParam(':username', $user_db);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':password', $pw_db);
			$stmt->bindParam(':confirm_code', $confirm_code);
			$stmt->execute();
			
			// Send email message to user for account activation
				// ideally would require full domain name but using server ip address
			$msg = "Confirm Your Email
					Click the link below to verify your account
					http://192.168.99.100:8088/activate.php?username=$user_db&code=$confirm_code";
			
			// requires "mail(<email address>, <subject title>, <msg>, <sender/src email>)" function
				// may require an actual web server in order to send the emails
			
			mail($email, "Verify Your Email on Camagru", $msg, "From: donotreply@camagru.com");
		
			// will need to pass registeration values & render the button click to an "register complete" page 
			render("success.php", ["message"=>"Registration Complete! Please activate your account through the email provided."]);

			//$id = $conn->lastInsertId();
			//session_start();
			//$_SESSION["id"] = $id;
			//redirect("index.php");
		}
	}
?>
