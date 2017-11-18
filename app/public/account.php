<?php
	require("../includes/helper.php");
	
	if ($_SERVER["REQUEST_METHOD"] == "GET")
		render("settings.php", ["title"=>"Settings"]);
?>
