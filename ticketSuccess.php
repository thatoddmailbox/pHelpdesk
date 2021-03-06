<?php require("header.inc.php"); ?>
<?php
if (isGetValEmpty("number")) {
	echo("Error!");
	require("footer.inc.php");
	die();
}
?>
<div class="container">
	<h1>Ticket submitted!</h1>
	<p>Thanks for submitting a ticket! Your ticket number is #<strong><?php echo htmlentities(getVal("number")); ?></strong>. To view information about it, see <a href="ticket.php?number=<?php echo htmlentities(getVal("number")); ?>">this page</a>.</p>
	<?php if (EMAIL_ENABLED) { ?>
		<p>You should receive a confirmation email soon. Once we've replied, you'll get an email alerting you.</p>
	<?php } ?>
	<?php if (!$_SESSION["loggedIn"]) { ?>
		<h3>Create an account</h3>
		<p>Create an account to manage tickets and replies! This ticket will be automatically added to it.</p>
		<a href="createAccount.php" class="btn btn-primary">Create account</a>
	<?php } ?>
</div>
<?php require("footer.inc.php"); ?>
