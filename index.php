<?php require("header.inc.php"); ?>
<div class="jumbotron">
	<div class="container">
		<h1>Welcome to <?php echo htmlentities(SITE_NAME); ?>!</h1>
		<p>This website is dedicated to helping you solve issues with your software. Here, you can create support tickets quickly and easily, or you can access the knowledgebase.</p>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-6 submitTicket">
			<h3>Submit a ticket</h3>
			<p>Need help from a human? Submit a support ticket with the easy-to-use online system and we'll get back to you as soon as possible.</p>
			<a href="<?php echo SITE_URL; ?>submitTicket.php" class="btn btn-primary btn-lg">Submit ticket</a>
		</div>
		<div class="col-md-6 knowledgebase">
			<h3>View the knowledgebase</h3>
			<p>Need to find some information? Use our comprehensive knowledgebase! Find articles describing your problem and how to fix it.</p>
			<a href="<?php echo SITE_URL; ?>knol/" class="btn btn-primary btn-lg">View knowledgebase</a>
		</div>
	</div>
</div>

<style>
html body {
	padding-top: 50px;
}
.submitTicket {
	text-align: right;
}
</style>
<?php require("footer.inc.php"); ?>