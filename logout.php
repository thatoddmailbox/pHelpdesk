<?php
require_once("config.inc.php");
require_once("util.inc.php");
session_start();
session_unset();
session_destroy();
redirect(SITE_URL . "index.php");