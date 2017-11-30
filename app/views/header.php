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
						<li><a href="/public/preupload.php">Test</a></li>
						<li><a href="#"><?= htmlspecialchars($_SESSION['name']) ?></a></li>
						<li><a href="/public/upload.php">Lemme Take a Selfie</a></li>
						<li><a href="/public/account.php">Settings</a></li>
						<li><a href="/public/logout.php">Log Out</a></li>
					<?else: ?>
						<li><a href="/public/login.php">Log In</a></li>
						<li><a href="/public/register.php">Register</a></li>
					<?endif ?>
				</ul>
			</div>
			<div id="spacer"></div>
			<div id="middle">
