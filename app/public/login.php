<?php
	require("../includes/helper.php");
	require_once("../db/connect.php");

	if ($_SERVER["REQUEST_METHOD"] == "GET")
		render("login_form.php", ["title"=>"Log In"]);
	else if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (empty($_POST["email"]))
			render("error.php", ["message"=>"Email Required"]);
		if (empty($_POST["password"]))
			render("error.php", ["message"=>"Password Required"]);
		
		try {
			$conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pw);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e) {
			render("error.php", ["message"=>"Trouble connecting to the server / database."."<br>Error: ".$e->getMessage()]);
		}
		// check if account exists 
		$check_user = $conn->prepare("SELECT password FROM users WHERE email = :email LIMIT 1");
		$check_user->bindParam(':email', $_POST["email"]);
		$check_user->execute();
		if ($check_user->rowCount() <= 0) {
			render("error.php", ["message"=>"Unable to look up user"]);
		}
		
		// check password entered
		$db_pw = $check_user->fetch(PDO::FETCH_OBJ);
		if (password_verify($_POST["password"], $db_pw->password))
		{
			// get user's unique id and set it to $_SESSION
			$get_id = $conn->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
			$get_id->bindParam(':email', $_POST["email"]);
			$get_id->execute();
			
			$id = $get_id->fetch(PDO::FETCH_OBJ);
			$_SESSION["id"] = $id->id;
			redirect("/public/index.php");
		}
		render("error.php", ["message"=>"Incorrect Password"]);
	}
?>
