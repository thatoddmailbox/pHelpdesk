<?php require("header.inc.php"); ?>
<div class="container">
	<h1>Welcome to <?php echo htmlentities(SITE_NAME); ?>!</h1>
	<p>Thanks for signing up! If you've made any tickets with the same email, they will be automatically assigned to this account.</p>
	<a href="<?php echo SITE_URL; ?>submitTicket.php" class="btn btn-lg btn-primary">Submit a ticket &raquo;</a>
	<br />
	<a href="<?php echo SITE_URL; ?>kb/" class="btn btn-lg btn-primary">View the knowledgebase &raquo;</a>
	<br />
	<br />
	<a href="<?php echo SITE_URL; ?>myTickets.php" class="btn btn-primary">View my tickets &raquo;</a>
	<a href="<?php echo SITE_URL; ?>profile.php" class="btn btn-primary">View my profile &raquo;</a>
</div>
<?php require("footer.inc.php"); ?>
