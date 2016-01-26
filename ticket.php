<?php require("header.inc.php"); ?>
<?php
if (isGetValEmpty("number")) {
	echo("<div class='container'>Error!</div>");
	require("footer.inc.php");
	die();
}
$ticketNumber = intval(getVal("number"));
$ticket = getTicket($ticketNumber);
if (count($ticket) == 0) {
	echo("<div class='container'><h1>Error</h1>Permission denied. Make sure you are logged in and have permission to view this ticket.</div>");
	require("footer.inc.php");
	die();
}
$ticketActions = getTicketActions($ticketNumber);
$isAnon = ($ticketActions[0]["actionUser"] == -1 || intval($ticketActions[0]["actionUser"]) == false);
$canEdit = ($currentUserRecord["accountLevel"] != "user" || $currentUserRecord["accountId"] == intval($ticketActions[0]["actionUser"]));
if (!$isAnon && $currentUserRecord["accountLevel"] == "user" && $currentUserRecord["accountId"] != intval($ticketActions[0]["actionUser"])) {
	echo("<div class='container'><h1>Error</h1>Permission denied. Make sure you are logged in and have permission to view this ticket.</div>");
	require("footer.inc.php");
	die();
}
date_default_timezone_set("GMT0"); // timezones.
?>
<div class="container">
	<h1><?php echo htmlspecialchars($ticket["ticketName"]); ?></h1>
	<?php if ($isAnon) { ?>
		<div class="action wrote text-centered">
			<p><strong>WARNING: </strong> This email address is not associated with any user account, meaning anyone can view it. <a href="createAccount.php">Create an account</a> using the same email address you used to make the ticket to prevent this.</p>
		</div>
		<br />
	<?php } ?>
	<?php foreach ($ticketActions as $action) { ?>
		<div class="action<?php echo ($action["actionDetails"] != "" ? ' wrote' : '');?>">
			<?php
				$usrRecord = getUserRecordFromId(intval($action["actionUser"]));
				$accountName = "Anonymous User";
				if (intval($action["actionUser"]) != false && $action["actionUser"] != "-1") {
					$accountName = $usrRecord["accountName"] . " (" . $usrRecord["accountEmail"] . ")";
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
			<div <?php echo ($action["actionDetails"] != "" ? 'class="wroteHeader"' : ''); ?>>
				<?php echo $name; ?>
				<div class="pull-right date">
					<abbr class="timeago" title="<?php echo date("c", strtotime($action["actionTimestamp"])); ?>"><?php echo $action["actionTimestamp"]; ?></abbr>
				</div>
			</div>
			<?php if ($action["actionDetails"] != "") {
				echo $action["actionDetails"];
			} ?>
		</div>
	<?php } ?>
	<br />
	<?php if ($isAnon && count($currentUserRecord) == 0) { ?>
		<div class="action text-centered">
			<p><a href="createAccount.php">Create an account</a> to respond to this ticket.</p>
		</div>
	<?php } elseif ($canEdit) { ?>
		<div class="action wrote">
			<form action="ticketResp.php" method="POST">
				<textarea class="tinymce-activate" name="ticketDesc"></textarea>
				<input type="hidden" name="ticketNumber" value="<?php htmlentities($ticketNumber); ?>" />
				<input type="submit" value="Submit response" class="btn btn-primary" />
			</form>
		</div>
		<div class="action wrote">
			<p>Ticket actions</p>
			<ul>
				<li><a href=""></a></li>
			</ul>
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
.date {
	color: #AAA;
}
</style>
<?php require("footer.inc.php"); ?>
