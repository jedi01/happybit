<?
if(!defined('INCLUDED')) exit("Access denied");

$R = @mysql_query("SELECT * FROM HB_https");
if(!$R) {
	MySQLError($query);
	exit;
} else {
	$Https = @mysql_fetch_array($R);
}

if(($HTTPS == "on" || $HTTPS == "1") &&
(basename($_SERVER['PHP_SELF']) == "logout.php")) {
	return;
}

if((isset($_SESSION['HAPPYBID_LOGGED_IN']) || isset($_SESSION["HAPPYBID_ADMIN_LOGIN"])) && $Https['https'] == 'yes') {
	$SETTINGS['siteurl']=$Https['httpsurl'];
} elseif($Https['https'] == 'no') {
	$Https['httpsurl']=$SETTINGS['siteurl'];	
}#// Force SSL transaction if this is the sign up script.

if(!($HTTPS == "on" || $HTTPS == "1") && $Https['https'] == 'yes' &&
(basename($_SERVER['PHP_SELF']) == "login.php" &&
strpos($_SERVER['PHP_SELF'],"admin/"))) {
	$GOTO = $Https['httpsurl']."admin/".basename($_SERVER['PHP_SELF']);
	Header("Location: $GOTO");
	exit;
}
if(!($HTTPS == "on" || $HTTPS == "1") && $Https['https'] == 'yes' &&
(basename($_SERVER['PHP_SELF']) == "login.php" ||
basename($_SERVER['PHP_SELF']) == "register.php" ||
basename($_SERVER['PHP_SELF']) == "user_login.php")) {
	$GOTO = $Https['httpsurl'].basename($_SERVER['PHP_SELF']);
	Header("Location: $GOTO");
	exit;
}


?>
