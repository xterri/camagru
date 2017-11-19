<?php
	require("../includes/helper.php");
	require_once("../includes/admin_functions.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		delete_user($_SESSION["id"]);
		$_SESSION["id"] = NULL;
		$_SESSION["name"] = NULL;
		logout();
		render("success.php", ["message"=>"Your Account has been successfully deleted"]);
	}
	render("error.php", ["message"=>"An error has occurred"]);
?>
