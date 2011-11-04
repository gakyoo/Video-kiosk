<?php

	defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
	defined("SITE_ROOT") ? null : define("SITE_ROOT", DS."opt".DS."lampp".DS."htdocs".DS."videokiosk");
	defined("LIB_PATH") ? null : define("LIB_PATH", SITE_ROOT.DS."includes");

	require_once("config.php");
	require_once("functions.php");
	

?>
