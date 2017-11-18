<h3><?= htmlspecialchars($message) ?></h3>
<form action="reset.php" method="post">
	<br />
	<div class="form-group">
	    <input class="form-control" name="new_pw" placeholder="New Password" type="password"/>
	</div>
	<div class="form-group">
	    <input class="form-control" name="confirm" placeholder="Confirm New Password" type="password"/>
	</div>
	<div class="form-group">
	    <input class="submit" type="submit" value="Save"/>
	</div>
</form>
