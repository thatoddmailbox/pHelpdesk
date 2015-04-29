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
	return isEmpty($_GET[$key]);
}
function isPostValEmpty($key) {
	return isEmpty($_POST[$key]);
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

require_once("include/PasswordHash.php");
$hasher = new PasswordHash(SITE_HASH_COST, SITE_HASH_PORTABLE);

require_once("mail.inc.php");