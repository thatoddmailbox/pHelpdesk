<?php require("../header.inc.php"); ?>
<?php require("../requireLogin.inc.php"); ?>
<div class="container">
	<h1>User management</h1>
	<table class="sortable">
		<thead>
			<tr>
				<th>ID Number</th>
				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Level</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$usersStmt = $db->prepare("SELECT * FROM `" . DB_PREF . "accounts`");
				$usersStmt->execute();
				$results = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($results as $entry) {
					echo "<tr>";

					echo "<td>";
					echo htmlentities($entry["accountId"]);
					echo "</td>";

					echo "<td>";
					echo htmlentities($entry["accountName"]);
					echo "</td>";

					echo "<td>";
					echo htmlentities($entry["accountUsername"]);
					echo "</td>";

					echo "<td>";
					echo htmlentities($entry["accountEmail"]);
					echo "</td>";

					echo "<td>";
					echo htmlentities($entry["accountLevel"]);
					echo "</td>";

					echo "<td>";
					echo '<a href="' . SITE_URL . 'admin/editUser.php?id=' . $entry["accountId"] . '" class="btn btn-primary btn-xs">Edit</a>';
					echo ' ';
					echo '<a href="' . SITE_URL . 'admin/deleteUser.php?id=' . $entry["accountId"] . '" class="btn btn-danger btn-xs">Delete</a>';
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