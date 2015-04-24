<?php require("header.inc.php"); ?>
<?php
	$isError = false;
	$error = "";

	if (isset($_POST["submit"])) {
		if (isPostValEmpty("ticketName")) {
			$isError = true;
			$error .= "Please enter a ticket name.<br />";
		}
		if (isPostValEmpty("ticketDesc")) {
			$isError = true;
			$error .= "Please enter a ticket description.<br />";
		}
		if (isPostValEmpty("email") || !filter_var(postVal("email"), FILTER_VALIDATE_EMAIL)) {
			$isError = true;
			$error .= "Please enter a valid email address.<br />";
		}

		$name = postVal("ticketName");
		$desc = postVal("ticketDesc");
		$email = postVal("email");
		$attachments = "";

		$stmt = $db->prepare("INSERT INTO `pHelpdesk`.`" . DB_PREF . "tickets` (`ticketName`, `ticketDesc`, `ticketEmail`, `ticketAttachments`) VALUES (:ticketName, :ticketDesc, :ticketEmail, :ticketAttachments)");
		$stmt->execute(array(':ticketName' => $name, ':ticketDesc' => $desc, ':ticketEmail' => $email, ':ticketAttachments' => $attachments));

		redirect("ticketSuccess.php?number=" . $db->lastInsertId());
		die();
	}
?>
<div class="container">
	<h1>Submit a ticket</h1>
	<?php if ($isError) { ?>
		<div class="alert alert-danger" role="alert">
			<strong>Error!</strong> <br /> <?php echo $error; ?>
		</div>
	<?php } ?>
	<p>You can use this form to submit a support ticket! A member of our staff will assist you.</p>
	<p>If you'd like, you can also <a href="<?php echo SITE_URL; ?>register.php">create an account</a> or <a href="<?php echo SITE_URL; ?>login.php">log in</a>. An account allows you to manage tickets and view replies.</p>
	<form action="<?php echo SITE_URL; ?>submitTicket.php" method="POST">
		<br />
		<p>Give your ticket a name. We recommend keeping it a short description of the problem you're experiencing.</p>
		<input type="textbox" class="form-control" name="ticketName" placeholder="Ticket name" />
		<br />

		<p>Describe the problem you need support for. <strong>Be detailed!</strong></p>
		<textarea class="tinymce-activate" name="ticketDesc"></textarea>

		<br />
		<h4>Images</h4>
		<p>Upload screenshots or other images describing the problem you're experiencing.</p>
		<div class="dropzone dropzone-activate" data-action="<?php echo SITE_URL; ?>uploadHandler.php">
			
		</div>

		<br />

		<input type="email" class="form-control" name="email" placeholder="Email address" />
		<p>A valid email address is required. Replies to this ticket will be sent here.</p>

		<br />

		<input type="submit" name="submit" value="Submit ticket" class="btn btn-primary btn-lg" />
	</form>
</div>
<?php require("footer.inc.php"); ?>