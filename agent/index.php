<?php require("../header.inc.php"); ?>
<?php require("../requireLogin.inc.php"); ?>
<div class="container">
	<h1>Agent panel</h1>
	<p>Select an option:</p>
	<ul>
		<li><a href="<?php echo SITE_URL; ?>agent/tickets.php">Assigned tickets</a></li>
		<li><a href="<?php echo SITE_URL; ?>agent/kbManage.php">Knowledgebase management</a></li>
		<li><a href="<?php echo SITE_URL; ?>profile.php">My profile</a></li>
	</ul>
</div>
<?php require("../footer.inc.php"); ?>
