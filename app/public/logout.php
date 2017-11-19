<?php
	require("../includes/helper.php");
	logout();
	$_SESSION['id'] = NULL;
	$_SESSION['name'] = NULL;
	redirect("/public/index.php");
?>
