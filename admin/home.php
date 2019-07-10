<?
include "../includes/config.inc.php";
include "loggedin.inc.php";
?>


<link rel='stylesheet' type='text/css' href='style.css' />

<?
#// ################################################################
#// Alter user if the install script is already present
if(file_exists("install.php")) {
	print "<SPAN CLASS=error>$MSG_25_0024</SPAN>";
}
if($_GET['show'] == "stats") {
	include "./home.stats.php";
} else {
	include "./home.installation.php";
}
?>
