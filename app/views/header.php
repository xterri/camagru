<!DOCTYPE html>
<html>
	<head>
		<link href="/public/css/styles.css" rel="stylesheet"/>
		<?if (isset($title)): ?>
			<title>Camagru: <?= htmlspecialchars($title) ?></title>
		<?else: ?>
			<title>Camagru</title>
		<?endif ?>
	</head>
	<body>
		<div class="container">
			<div id="top">
				<ul class="nav" align="right">
					<li><a href="/public/index.php">Home</a></li>
					<?if (!empty($_SESSION["id"])): ?>
						<li><a href="#">Lemme Take a Selfie</a></li>
						<li><a href="#">Account Settings</a></li>
						<li><a href="/public/logout.php">Fine, Leave Me</a></li>
					<?else: ?>
						<li><a href="#">Log In</a></li>
						<li><a href="/public/register.php">Register</a></li>
					<?endif ?>
				</ul>
			</div>
			<div id="spacer"></div>
			<div id="middle">
