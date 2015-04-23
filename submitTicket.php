<?php require("header.inc.php"); ?>
<div class="container">
	<h1>Submit a ticket</h1>
	<p>You can use this form to submit a support ticket! A member of our staff will assist you.</p>
	<p>If you'd like, you can also <a href="<?php echo SITE_URL; ?>register.php">create an account</a> or <a href="<?php echo SITE_URL; ?>login.php">log in</a>. An account allows you to manage tickets and view replies.</p>
	<form action="<?php echo SITE_URL; ?>submitTicket.php" method="POST">
		<input type="textbox" class="form-control" name="ticketName" placeholder="Ticket name" />
		<p>Give your ticket a name. We recommend keeping it a short description of the problem you're experiencing.</p>
		
		<textarea class="tinymce-activate" name="ticketDesc"></textarea>
		<p>Describe the problem you need support for. <strong>Be detailed!</strong></p>

		<h4>Images</h4>
		<p>Upload screenshots or other images describing the problem you're experiencing.</p>
		<div class="dropzone dropzone-activate" data-action="<?php echo SITE_URL; ?>uploadHandler.php">
			
		</div>

		<br />

		<input type="email" class="form-control" placeholder="Email address" />
		<p>A valid email address is required. Replies to this ticket will be sent here.</p>

		<br />

		<input type="submit" name="submit" value="Submit ticket" class="btn btn-primary btn-lg" />
	</form>
</div>
<?php require("footer.inc.php"); ?>