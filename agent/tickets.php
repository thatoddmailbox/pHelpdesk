<?php require("../header.inc.php"); ?>
<?php require("../requireLogin.inc.php"); ?>
<div class="container">
	<h1>Tickets</h1>
	<table class="sortable">
		<thead>
			<tr>
				<th>Ticket number</th>
				<th>Ticket name</th>
				<th>Email</th>
				<th>Assigned to</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$usersStmt = $db->prepare("SELECT * FROM `" . DB_PREF . "tickets`");
				$usersStmt->execute();
				$results = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($results as $entry) {
					echo "<tr>";

					echo "<td>";
					echo htmlentities($entry["ticketNumber"]);
					echo "</td>";

					echo "<td>";
					echo htmlentities($entry["ticketName"]);
					echo "</td>";

					echo "<td>";
					echo htmlentities($entry["ticketEmail"]);
					echo "</td>";

					echo "<td>";
					$accountName = "unassigned";
					if (intval($entry["ticketAssignedTo"]) != false && $entry["ticketAssignedTo"] != "-1") {
						$usrRecord = getUserRecordFromId(intval($entry["ticketAssignedTo"]));
						$accountName = $usrRecord["accountName"];
					}
					echo htmlentities($accountName);
					echo "</td>";

					echo "<td>";
					echo htmlentities($entry["ticketStatus"]);
					echo "</td>";

					echo "<td>";
					echo '<a href="' . SITE_URL . 'agent/viewTicket.php?id=' . $entry["ticketNumber"] . '" class="btn btn-primary btn-xs">View</a>';
					echo "</td>";

					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>
<script src="<?php echo SITE_URL; ?>js/sorttable.js"></script>
<style>
th {
	min-width: 170px;
}
</style>
<?php require("../footer.inc.php"); ?>
