<?php
require_once("config.inc.php");
require_once("db.inc.php");

session_start();

require_once("util.inc.php");

if (!isset($_POST["ticketNumber"])) {
	die("Error.");
}
$ticketNumber = intval($_POST["ticketNumber"]);
$ticket = getTicket($ticketNumber);
if (count($ticket) == 0) {
	die("Error.");
}
$ticketActions = getTicketActions($ticketNumber);
$canEdit = ($currentUserRecord["accountLevel"] != "user" || $currentUserRecord["accountId"] == intval($ticketActions[0]["actionUser"]));

if (!$canEdit) {
	die("Error.");
}

redirect("ticket.php?number=" . $ticketNumber);
