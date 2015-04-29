<?php
require_once("config.inc.php");
require_once("db.inc.php");

session_start();

require_once("util.inc.php");

if (count($currentUserRecord) == 0) {
	redirect(SITE_URL . "login.php");
	die();
}

$currentLevel = "user";

if (strpos($_SERVER["PHP_SELF"], "/agent/") !== FALSE) {
	$currentLevel = "agent";
}
if (strpos($_SERVER["PHP_SELF"], "/admin/") !== FALSE) {
	$currentLevel = "admin";
}

if ($currentLevel != "user") {
	if (!($currentUserRecord["accountLevel"] == $currentLevel || $currentUserRecord["accountLevel"] == "admin")) {
		redirect(SITE_URL . "login.php");
		die();
	}
}