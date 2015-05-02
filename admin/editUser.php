<?php require("../header.inc.php"); ?>
<?php require("../requireLogin.inc.php"); ?>
<?php
	if (isGetValEmpty("id")) {
		friendlyErrorMsg("Missing parameter!");
	}

	$userRecord = getUserRecordFromId(getVal("id"));
	if (count($userRecord) == 0) {
		friendlyErrorMsg("Invalid parameter!");		
	}

	if (!isPostValEmpty("submit")) {
		if (isPostValEmpty("name")) {
			form_error("Please enter a name.");
		}
		if (isPostValEmpty("username")) {
			form_error("Please enter a username.");
		}
		if (isPostValEmpty("email") || !filter_var(postVal("email"), FILTER_VALIDATE_EMAIL)) {
			form_error("Please enter an valid email address.");
		}

		if (!$isError) {
			if (strlen(postVal("name")) > 255) {
				form_error("Your name is too long.");
			}
			if (strlen(postVal("username")) > 255) {
				form_error("Your username is too long.");
			}
			if (strlen(postVal("email")) > 255) {
				form_error("Your email is too long.");
			}
			if (!isPostValEmpty("pwd") && strlen(postVal("pwd")) > 72) {
				form_error("Your password is too long.");
			}
		}

		if (!$isError) {
			$updateStmt = $db->prepare("UPDATE  `" . DB_PREF . "accounts` SET accountName=:name, accountUsername=:username, accountEmail=:email, accountLevel=:level WHERE accountId=:id");
			$updateStmt->execute(array( ":id" => getVal("id"),
										":name" => postVal("name"),
										":username" => postVal("username"),
										":email" => postVal("email"),
										":level" => postVal("level")));

			if (!isPostValEmpty("pwd")) {
				$pwdStmt = $db->prepare("UPDATE  `" . DB_PREF . "accounts` SET accountPass=:password WHERE accountId=:id");
				$pwdStmt->execute(array( ":id" => getVal("id"),
										 ":password" => $hasher->HashPassword(postVal("pwd")) ));
			}

			redirect(SITE_URL . "admin/users.php");
			die();
		}
	}
?>
<div class="container">
	<h1>Edit user</h1>
	<h3><?php echo htmlentities($userRecord["accountName"]); ?></h3>

	<?php form_output_errors(); ?>

	<form method="POST">
		<strong>Name</strong>
		<input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($userRecord["accountName"]); ?>" maxlength="255" />

		<br />

		<strong>Username</strong>
		<input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($userRecord["accountUsername"]); ?>" maxlength="255" />

		<br />

		<strong>Email</strong>
		<input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($userRecord["accountEmail"]); ?>" maxlength="255" />

		<br />

		<strong>Password</strong>
		<input type="password" class="form-control" name="pwd" placeholder="(cannot be viewed, but change this to reset it)" maxlength="72" />

		<br />

		<strong>Account level</strong>
		<br />
		<select name="level">
			<option value="user"<?php if($userRecord["accountLevel"]=="user"){echo " selected";} ?>>User - A standard user, like one can create from the main website.</option>
			<option value="agent"<?php if($userRecord["accountLevel"]=="agent"){echo " selected";} ?>>Agent - An agent can respond to tickets and add knowledgebase articles.</option>
			<option value="admin"<?php if($userRecord["accountLevel"]=="admin"){echo " selected";} ?>>Administrator - An administrator can do everything an agent can do, add users, and control site settings.</option>
		</select>

		<br />
		<br />

		<input type="submit" class="btn btn-primary" name="submit" value="Submit" />
		<a href="<?php echo SITE_URL; ?>admin/deleteUser.php?id=<?php echo $userRecord["accountId"]; ?>" class="btn btn-danger">Delete</a>

	</form>
</div>

<?php require("../footer.inc.php"); ?>