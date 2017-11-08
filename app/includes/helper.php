<?php

// Enable sessions for each PHP page
	session_start();

// Render combines header, main & footer files while passing any values to $files (php file)
	function render($file, $values = [])
	{
		if (file_exists("../views/{$file}"))
		{
			extract($values);
			require("../views/header.php");
			require("../views/{$file}");
			require("../views/footer.php");
			exit ;
		}
		trigger_error("Invalid view: {$file}", E_USER_ERROR);
	}

// Redirects user to location passed
	function redirect($location)
	{
		if (!header_sent($file, $line))
		{
			header("Location: {$location}");
			exit ;
		}
		trigger_error("HTTP headers already sent at {$file}:{$line}", E_USER_ERROR);
	}

// Logout function - Disconnects user temporarily until they re-login
	function logout()
	{
		session_unset();
		if (!empty($_COOKIE[session_name()]))
			setcookie(session_name(), "", time() - 42000);
		session_destroy();
	}
?>
