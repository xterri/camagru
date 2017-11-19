<?php
	require("../includes/helper.php");
	require("../includes/admin_functions.php");

	if (empty($_SESSION['id'])) {
		if ($_SERVER["REQUEST_METHOD"] == "GET")
			render("login_form.php", ["title"=>"Log In"]);
		else if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			if (empty($_POST["email"]))
				render("login_form.php", ["message"=>"Email Required"]);
			if (empty($_POST["password"]))
				render("login_form.php", ["message"=>"Password Required"]);
			
			try {
				$conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pw);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e) {
				render("error.php", ["message"=>"Trouble connecting to the server / database."."<br>Error: ".$e->getMessage()]);
			}
			// check if account exists 
			if (!email_exists($_POST["email"]))
				render("login_form.php", ["message"=>"Email / User does not exist"]);
			
			$results = get_user_info_by_email($_POST["email"]);
			// check password
			if (password_verify($_POST["password"], $results["password"]))
			{
				if ($results['confirm_code'] == 0 && $results['validation'] == TRUE)
				{
					$id = $results['id'];
					$_SESSION["id"] = $id;
					redirect("/public/index.php");
				}
				// maybe create another page for users to be able to "resend" the activation email
				render("login_form.php", ["message"=>"Account Not Activated. Please check your email to activate your account."]);	
			}
			render("login_form.php", ["message"=>"Incorrect Password"]);
		}
	}
	render("error.php");
?>
