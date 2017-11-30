<?php
	require("../includes/helper.php");
	require("../includes/admin_functions.php");

	$pw = password_hash('Terri8', PASSWORD_DEFAULT);
	add_user('terri', 't@t.t', $pw, 0);
	add_category_name('test_category');
	update_validation('terri', 0, 't');
?>
