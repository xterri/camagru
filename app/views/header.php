<!DOCTYPE html>
<!-- <?include_once('../public/admin_functions.php')?> -->
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
					<li><a href="index.php">Home</a></li>
					<?if (!empty($_SESSION["id"])): ?>
						<li><a href="#">Lemme Take a Selfie</a></li>
						<li><a href="#">Account Settings</a></li>
						<li><a href="#">Fine, Leave Me</a></li>
					<?else: ?>
						<li><a href="#">Log In</a></li>
						<li><a href="#">Register</a></li>
					<?endif ?>
				</ul>
			</div>
			<div id="spacer"></div>
			<div id="middle">
