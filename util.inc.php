<?php
function isNotEmpty($formField) {
	return !isset($formField) || empty($formField);
}