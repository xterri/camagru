<?php if(!empty($_SESSION["id"])): ?>
<h1><?= htmlspecialchars($message) ?></h1>
<h3>Change your email address</h3>
<form action="email.php" method="post">
	<br />
	<div class="form-group">
	    <input class="form-control" name="new_email" placeholder="New email" type="email"/>
	</div>
	<br />
    <div class="form-group">
        <input autocomplete="off" autofocus class="form-control" name="pw" placeholder="Password" type="password"/>
	</div>
	<div class="form-group">
	    <input class="submit" type="submit" value="Save"/>
	</div>
</form>
<h3>Change your password</h3>
<form action="password.php" method="post">
	<div class="form-group">
	    <input class="form-control" name="new_pw" placeholder="New Password" type="password"/>
	</div>
	<div class="form-group">
	    <input class="form-control" name="confirm" placeholder="Confirm New Password" type="password"/>
	</div>
	<br />
	<div class="form-group">
		<input autocomplete="off" autofocus class="form-control" name="pw" placeholder="Current Password" type="password"/>
	</div>
	<div class="form-group">
	    <input class="submit" type="submit" value="Save"/>
	</div>
</form>
<h3>Delete your account</h3>
<form action="delete.php" method="post">
	 <input style="margin-top: 6em" class="submit" type="submit" value="Delete Account"/>
</form>
<?php else: ?>
<h1>Please Log in to access this page</h1>

<?php endif ?>
