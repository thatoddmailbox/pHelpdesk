<?php
function isNotEmpty($formField) {
	return !isset($formField) || empty($formField);
}
function redirect($url) {
	echo "<script>window.location.href=\"";
	echo htmlspecialchars($url);
	echo "\";</script>";

	echo "<a href=\"";
	echo htmlspecialchars($url);
	echo "\">click here</a>";
}