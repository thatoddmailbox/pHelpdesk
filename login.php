<?php require("header.inc.php"); ?>
<?php
	if (isset($_POST["submit"])) {
		if (isPostValEmpty("username")) {
			form_error("Please enter a username.");
		}
		if (isPostValEmpty("pwd")) {
			form_error("Please enter a password.");
		}

		if (!$isError) {
			if (strlen(postVal("username")) > 255) {
				form_error("Your username is too long.");
			}
			if (strlen(postVal("pwd")) > 72) {
				form_error("Your password is too long.");
			}
		}

		if (!$isError) {
			$chkStmt = $db->prepare("SELECT * FROM `" . DB_PREF . "accounts` WHERE accountUsername=:username");
			$chkStmt->execute(array(":username" => postVal("username")));
			$results = $chkStmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($results) == 0) {
				form_error("The username or password is incorrect.");
			} else {
				if (!$hasher->CheckPassword(postVal("pwd"), $results[0]["accountPass"])) {
					form_error("The username or password is incorrect.");
				} else {
					$_SESSION["loggedIn"] = true;
					$_SESSION["username"] = $results[0]["accountUsername"];
					redirect(SITE_URL . "index.php");
				}
			}
		}
	}
?>
<div class="container">
	<h1>Log in</h1>
	<?php form_output_errors(); ?>
	<form action="<?php echo SITE_URL; ?>login.php" method="POST">
		<input type="text" class="form-control" name="username" placeholder="Username (not your full name)" maxlength="255" />
		<input type="password" class="form-control" name="pwd" placeholder="Password" maxlength="72" />

		<input type="submit" class="btn btn-primary" name="submit" value="Log in" />
	</form>
</div>
<?php require("footer.inc.php"); ?>