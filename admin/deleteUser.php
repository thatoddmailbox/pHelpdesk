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
		if (isPostValEmpty("delete") || postVal("delete") != "delete") {
			form_error("Please type 'delete' (all lowercase) to confirm deletion.");
		}

		if (!$isError) {
			if ($userRecord["accountLevel"] == "admin") {
				$adminChkStmt = $db->query("SELECT * FROM `" . DB_PREF . "accounts` WHERE accountLevel='admin'");
				
				if (count($adminChkStmt->fetchAll(PDO::FETCH_ASSOC)) == 1) {
					form_error("You cannot delete this account because it is the only administrator account.");
				}
			}
		}

		if (!$isError) {
			$deleteStmt = $db->prepare("DELETE FROM `" . DB_PREF . "accounts` WHERE accountId=:id");
			$deleteStmt->execute(array( ":id" => getVal("id") ));

			redirect(SITE_URL . "admin/users.php");
		}
	}

?>
<div class="container">
	<h1>Delete user</h1>
	<h3><?php echo htmlentities($userRecord["accountName"]); ?></h3>

	<?php form_output_errors(); ?>

	<form method="POST">
		<p>Are you sure you want to delete <strong><?php echo htmlentities($userRecord["accountName"]); ?></strong>?</p>

		<strong>This action is irreversible. You may want to double-check backups before continuing.</strong>
		<br />
		<strong>Please type 'delete' (all lowercase) to confirm deletion.</strong>

		<input type="text" class="form-control" name="delete" />
		
		<input type="submit" class="btn btn-danger" name="submit" value="Confirm deletion" />
		<a href="<?php echo SITE_URL; ?>admin/users.php" class="btn btn-primary">Cancel</a>

	</form>
</div>
<?php require("../footer.inc.php"); ?>