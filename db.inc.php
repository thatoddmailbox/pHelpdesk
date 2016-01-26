<?php
define("DB_HOST", "localhost");
define("DB_USER", "pHelpdesk");
define("DB_PASS", "pHelpdesk");
define("DB_BASE", "pHelpdesk");
define("DB_PREF", "pHelpdesk_");

$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_BASE . ';charset=utf8', DB_USER, DB_PASS, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
