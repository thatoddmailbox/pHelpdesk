<?php require("header.inc.php"); ?>
<?php
	if (isset($_POST["submit"])) {
		if (isPostValEmpty("ticketName")) {
			form_error("Please enter a ticket name.");
		}
		if (isPostValEmpty("ticketDesc")) {
			form_error("Please enter a ticket description.");
		}
		if ((isPostValEmpty("email") || !filter_var(postVal("email"), FILTER_VALIDATE_EMAIL)) && !$_SESSION["loggedIn"]) {
			form_error("Please enter a valid email address.");
		}

		$name = postVal("ticketName");
		$desc = postVal("ticketDesc");
		$email = postVal("email");
		$attachments = "";

		if (!$isError && $_SESSION["loggedIn"]) {
			$email = $currentUserRecord["accountEmail"];
		}

		if (strlen($name) > 255) {
			form_error("Ticket name too long!");
		}
		if (strlen($email) > 255) {
			form_error("Email too long!");
		}

		if (!$isError) {
			$stmt = $db->prepare("INSERT INTO `" . DB_PREF . "tickets` (`ticketName`, `ticketDesc`, `ticketEmail`, `ticketAttachments`) VALUES (:ticketName, :ticketDesc, :ticketEmail, :ticketAttachments)");
			$stmt->execute(array(':ticketName' => $name, ':ticketDesc' => $desc, ':ticketEmail' => $email, ':ticketAttachments' => $attachments));

			$ticketId = $db->lastInsertId();

			$actStmt = $db->prepare("INSERT INTO `" . DB_PREF . "ticketActions` (`actionType`, `actionTicket`) VALUES ('created', :ticketId)");
			$actStmt->execute(array(':ticketId' => $ticketId));
			
			$act2Stmt = $db->prepare("INSERT INTO `" . DB_PREF . "ticketActions` (`actionType`, `actionDetails`, `actionTicket`) VALUES ('wrote', :ticketDesc, :ticketId)");
			$act2Stmt->execute(array(':ticketDesc' => $desc, ':ticketId' => $ticketId));

			redirect("ticketSuccess.php?number=" . $ticketId);
			die();
		}
	}
?>
<div class="container">
	<h1>Submit a ticket</h1>
	<?php form_output_errors(); ?>
	<p>You can use this form to submit a support ticket! A member of our staff will assist you.</p>
	<?php if (!$_SESSION["loggedIn"]) { ?>
		<p>If you'd like, you can also <a href="<?php echo SITE_URL; ?>createAccount.php">create an account</a> or <a href="<?php echo SITE_URL; ?>login.php">log in</a>. An account allows you to manage tickets and view replies.</p>
	<?php } ?>
	<form action="<?php echo SITE_URL; ?>submitTicket.php" method="POST">
		<p>Give your ticket a name. We recommend keeping it a short description of the problem you're experiencing.</p>
		<input type="textbox" class="form-control" name="ticketName" placeholder="Ticket name" maxlength="255" />
		<br />

		<p>Describe the problem you need support for. <strong>Be detailed!</strong></p>
		<textarea class="tinymce-activate" name="ticketDesc"></textarea>

		<br />
		<h4>Images</h4>
		<p>Upload screenshots or other images describing the problem you're experiencing.</p>
		<div class="dropzone dropzone-activate" data-action="<?php echo SITE_URL; ?>uploadHandler.php">
			
		</div>

		<br />

		<?php if ($_SESSION["loggedIn"]) { ?>
			<p>You're logged in, and emails will be sent to the email address on this account, <strong><?php echo htmlentities($currentUserRecord["accountEmail"]); ?></strong>.</p>
			<p>To change this email, <a href="<?php echo SITE_URL; ?>profile.php">visit the profile page</a>.
		<?php } else { ?>
			<input type="email" class="form-control" name="email" placeholder="Email address" maxlength="255" />
			<p>A valid email address is required. Replies to this ticket will be sent here.</p>
		<?php } ?>

		<br />
		<br />

		<input type="submit" name="submit" value="Submit ticket" class="btn btn-primary btn-lg" />
	</form>
</div>
<?php require("footer.inc.php"); ?>