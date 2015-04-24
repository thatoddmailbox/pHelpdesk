<?php require("header.inc.php"); ?>
<div class="container">
	<h1>Create an account</h1>
	<form action="<?php echo SITE_URL; ?>createAccount.php" method="POST">
		<input type="text" class="form-control" name="username" placeholder="Username" />
		<input type="email" class="form-control" name="email" placeholder="Email address" />
		<input type="password" class="form-control" name="pwd" placeholder="Password" />
		<input type="password" class="form-control" name="pwdConf" placeholder="Password (confirm)" />
		
		<input type="submit" class="btn btn-primary" value="Create account" />
	</form>
</div>
<?php require("footer.inc.php"); ?>