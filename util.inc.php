<?php
function redirect($url) {
	echo "<script>window.location.href=\"";
	echo htmlspecialchars($url);
	echo "\";</script>";

	echo "<a href=\"";
	echo htmlspecialchars($url);
	echo "\">click here</a>";
}

function isEmpty($formField) {
	return !isset($formField) || empty($formField);
}
function isGetValEmpty($key) {
	return !isset($_GET[$key]) || isEmpty($_GET[$key]);
}
function isPostValEmpty($key) {
	return !isset($_POST[$key]) || isEmpty($_POST[$key]); // extra isset to avoid warning
}

function getVal($key)
{
	$value = $_GET[$key];
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
	return $value;
}
function postVal($key)
{
	$value = $_POST[$key];
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
	return $value;
}

function friendlyErrorMsg($desc) {
	die($desc); // TODO: make friendlier
}

$isError = false;
$error = "";

function form_error($errMsg) {
	global $isError;
	global $error;

	$isError = true;
	$error .= $errMsg;
	$error .= "<br />";
}
function form_output_errors() {
	global $isError;
	global $error;

	if ($isError) {
		echo '<div class="alert alert-danger" role="alert">';
		echo '<strong>Error!</strong> <br />';
		echo $error;
		echo '</div>';
	}
}

function getUserRecord($username) {
	global $db;
	$chkStmt = $db->prepare("SELECT * FROM `" . DB_PREF . "accounts` WHERE accountUsername=:username");
	$chkStmt->execute(array(":username" => $username));
	$results = $chkStmt->fetchAll(PDO::FETCH_ASSOC);
	if (count($results) == 0) {
		return array();
	}
	return $results[0];
}
function getUserRecordFromId($id) {
	global $db;
	$chkStmt = $db->prepare("SELECT * FROM `" . DB_PREF . "accounts` WHERE accountId=:id");
	$chkStmt->execute(array(":id" => $id));
	$results = $chkStmt->fetchAll(PDO::FETCH_ASSOC);
	if (count($results) == 0) {
		return array();
	}
	return $results[0];
}
function getTicket($id) {
	global $db;
	$db->query("set time_zone = '+00:00';");
	$chkStmt = $db->prepare("SELECT * FROM `" . DB_PREF . "tickets` WHERE ticketNumber=:id");
	$chkStmt->execute(array(":id" => $id));
	$results = $chkStmt->fetchAll(PDO::FETCH_ASSOC);
	if (count($results) == 0) {
		return array();
	}
	return $results[0];
}
function getTicketActions($id) {
	global $db;
	$db->query("set time_zone = '+00:00';");
	$chkStmt = $db->prepare("SELECT * FROM `" . DB_PREF . "ticketActions` WHERE actionTicket=:id");
	$chkStmt->execute(array(":id" => $id));
	$results = $chkStmt->fetchAll(PDO::FETCH_ASSOC);
	if (count($results) == 0) {
		return array();
	}
	return $results;
}

$currentUserRecord = array();
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
	$currentUserRecord = getUserRecord($_SESSION["username"]);
}

require_once("include/PasswordHash.php");
$hasher = new PasswordHash(SITE_HASH_COST, SITE_HASH_PORTABLE);

require_once("mail.inc.php");
