<?php require("header.inc.php"); ?>
<?php
if (isGetValEmpty("number")) {
	echo("Error!");
	require("footer.inc.php");
	die();
}
$ticketNumber = intval(getVal("number"));
$ticket = getTicket($ticketNumber);
$ticketActions = getTicketActions($ticketNumber);
?>
<div class="container">
	<h1><?php echo htmlspecialchars($ticket["ticketName"]); ?></h1>
	<?php foreach ($ticketActions as $action) { ?>
		<div class="action<?php echo ($action["actionDetails"] != "" ? ' wrote' : '');?>">
			<?php
				$usrRecord = getUserRecordFromId(intval($action["actionUser"]));
				$accountName = $usrRecord["accountName"];
				if (intval($action["actionUser"]) == false || $action["actionUser"] == "-1") {
					$accountName = "Anonymous User";
				}
				$user = "<strong>" . $accountName . "</strong>";
				switch($action["actionType"]) {
					case "created":
						$name = "Created by " . $user;
						break;

					case "assigned":
						$name = "Assigned to " . $user;
						break;

					case "wrote":
						$name = $user . " wrote";
						break;

					case "status":
						$name = $user . " changed the status";
						break;
				}
			?>
			<div<?php echo ($action["actionDetails"] != "" ? ' class="wroteHeader"' : ''); ?>>
			<?php echo $name; ?>
			</div>
			<?php if ($action["actionDetails"] != "") {
				echo $action["actionDetails"];
			} ?>
		</div>
	<?php } ?>
</div>
<style>
.action {
	border: solid 1px black;
	border-radius: 5px;
	box-shadow: 1px 1px 1px black;
	margin: 10px auto;
	padding: 10px;
	width: 400px;
}
.wrote {
	width: 700px;
}
.wroteHeader {
	border-bottom: solid 1px black;
	margin-bottom: 7px;
	padding-bottom: 7px;
}
</style>
<?php require("footer.inc.php"); ?>