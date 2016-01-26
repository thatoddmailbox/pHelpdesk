<?php require("../header.inc.php"); ?>
<?php require("../requireLogin.inc.php"); ?>
<div class="container">
	<h1>Administration panel</h1>
	<p>Select an option:</p>
	<ul>
		<li><a href="<?php echo SITE_URL; ?>admin/users.php">User management</a></li>
		<li><a href="<?php echo SITE_URL; ?>admin/ticketAssignment.php">Ticket assignment</a></li>
		<li><a href="<?php echo SITE_URL; ?>admin/kbConfig.php">Knowledgebase configuration</a></li>
		<li><a href="<?php echo SITE_URL; ?>admin/siteAppearance.php">Site appearance</a></li>
		<li><a href="<?php echo SITE_URL; ?>admin/siteConfig.php">Site configuration</a></li>
	</ul>
</div>
<?php require("../footer.inc.php"); ?>
