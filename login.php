<?php require("header.inc.php"); ?>
<div class="container">
	<h1>Log in</h1>
	<form action="<?php echo SITE_URL; ?>createAccount.php" method="POST">
		<input type="text" class="form-control" name="username" placeholder="Username" />
		<input type="password" class="form-control" name="pwd" placeholder="Password" />

		<input type="submit" class="btn btn-primary" value="Log in" />
	</form>
</div>
<?php require("footer.inc.php"); ?>