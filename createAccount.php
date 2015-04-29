<?php require("header.inc.php"); ?>
<?php
	$isError = false;
	$error = "";

	function form_error($errMsg) {
		$isError = true;
		$error .= $errMsg;
		$error .= "<br />";
	}

	if (isset($_POST["submit"])) {
		if (isPostValEmpty("name")) {
			form_error("Please enter a name.");
		}
		if (isPostValEmpty("username")) {
			form_error("Please enter a username.");
		}
		if (isPostValEmpty("email") || !filter_var(postVal("email"), FILTER_VALIDATE_EMAIL)) {
			form_error("Please enter an valid email address.");
		}
		if (isPostValEmpty("pwd")) {
			form_error("Please enter a password.");
		}
		if (isPostValEmpty("pwdConf")) {
			form_error("Please confirm the password.");
		}

		if (!$isError) {
			if (postVal("pwd") != postVal("pwdConf")) {
				form_error("The two passwords are not the same.");
			}

			if (strlen(postVal("name")) > 255) {
				form_error("Your name is too long.");
			}
			if (strlen(postVal("username")) > 255) {
				form_error("Your username is too long.");
			}
			if (strlen(postVal("email")) > 255) {
				form_error("Your email is too long.");
			}
			if (strlen(postVal("pwd")) > 72) {
				form_error("Your password is too long.");
			}
		}

		if (!$isError) {
			// Check for existing user
			$chkStmt = $db->prepare("SELECT * FROM `" . DB_PREF . "accounts` WHERE accountUsername=:username");
			$chkStmt->execute(array(":username" => postVal("username")));
			if (count($chkStmt->fetchAll(PDO::FETCH_ASSOC)) > 0) {
				form_error("That username is taken!");
			}

			$chkEmailStmt = $db->prepare("SELECT * FROM `" . DB_PREF . "accounts` WHERE accountEmail=:email");
			$chkEmailStmt->execute(array(":email" => postVal("email")));
			if (count($chkEmailStmt->fetchAll(PDO::FETCH_ASSOC)) > 0) {
				form_error("That email is already in use! Use the Forgot Password form if you need to reset it.");
			}
		}

		if (!$isError) {
			$name = postVal("name");
			$username = postVal("username");
			$email = postVal("email");
			$password = $hasher->HashPassword(postVal("pwd"));

			if (strlen($password) < 20) {
				form_error("Unknown error occurred. Please try again later.");
			}

			if (!$isError) {
				$insStmt = $db->prepare("INSERT INTO `" . DB_PREF . "accounts` (accountName, accountUsername, accountEmail, accountPass, accountLevel) VALUES(:name, :username, :email, :pass, 'user')");
				$insStmt->execute(array(':name' => $name, ':username' => $username, ':email' => $email, ':pass' => $password));
				$affected_rows = $insStmt->rowCount();
				$_SESSION["loggedIn"] = true;
				$_SESSION["name"] = $name;
				$_SESSION["username"] = $username;
				redirect(SITE_URL . "welcome.php");
			}
		}
	}
?>
<div class="container">
	<h1>Create an account</h1>
	<?php if ($isError) { ?>
		<div class="alert alert-danger" role="alert">
			<strong>Error!</strong> <br /> <?php echo $error; ?>
		</div>
	<?php } ?>
	<form action="<?php echo SITE_URL; ?>createAccount.php" method="POST">
		<input type="text" class="form-control" name="name" placeholder="Name" maxlength="255" />
		<input type="text" class="form-control" name="username" placeholder="Username" maxlength="255" />
		<input type="email" class="form-control" name="email" placeholder="Email address" maxlength="255" />
		<input type="password" class="form-control" name="pwd" placeholder="Password" maxlength="72" />
		<input type="password" class="form-control" name="pwdConf" placeholder="Password (confirm)" maxlength="72" />

		<input type="submit" class="btn btn-primary" name="submit" value="Create account" />
	</form>
</div>
<?php require("footer.inc.php"); ?>