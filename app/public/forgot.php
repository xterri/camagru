<?php
	require("../includes/helper.php");
	require_once("../db/connect.php");

	if ($_SERVER["REQUEST_METHOD"] == "GET")
		render("forgot_form.php", ["title"=>"Forgot Password"]);
	else if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (empty($_POST["email"]))
			render("error.php", ["message"=>"Email Required"]);
		try {
			$conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pw);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e) {
			render("error.php", ["message"=>"Trouble connecting to the server / database."."<br>Error: ".$e->getMessage()]);
		}
		// check if account exists
		$check_user = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
		$check_user->bindParam(':email', $_POST["email"]);
		$check_user->execute();
		if ($check_user->rowCount() <= 0) {
			render("error.php", ["message"=>"User does not exist"]);
		}
		$results = $check_user->fetch(PDO::FETCH_ASSOC);
		$user_db = $results['username'];
		$confirm_code = rand();
		$email = $results['email'];

		// send email msg to user to reset password
		$msg = "Click the link below to change your password
				http://192.168.99.100:8088/public/reset.php?username=$user_db&code=$confirm_code";

		// requires "mail(<email address>, <subject title>, <msg>, <sender/src email>)" function
		mail($email, "Change your Password on Camagru", $msg, "From: donotreply@camagru.com");

		$stmt = "UPDATE users SET validation='f' WHERE email='$email'";
		$conn->exec($stmt);
		$stmt = "UPDATE users SET confirm_code=$confirm_code WHERE email='$email'";
		$conn->exec($stmt);
		// will need to pass registeration values & render the button click to an "register complete" page
		render("success.php", ["message"=>"An email has been sent. Please check it to change your password"]);
	}
?>
