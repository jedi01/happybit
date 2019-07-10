<?
// Connect to sql server & inizialize configuration variables
require('./includes/config.inc.php');

#// If user is not logged in redirect to login page

if(!isset($_SESSION["HAPPYBID_LOGGED_IN"])) {
	Header("Location: user_login.php");
	exit;
}
#// Update database
if($_POST['action']=='update' && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF'])) {
	$query = "UPDATE HB_users SET payment_details='".addslashes($_POST['payment_details'])."' WHERE id=".$_SESSION['HAPPYBID_LOGGED_IN'];
	$res = @mysql_query($query);
	if (!$res) {
		MySQLError($query);
		exit;
	}else{
		$MSG = $MSG_30_0079;
	}
}	

#// Retrieve payment details from the database
$payment_details=@mysql_result(@mysql_query("SELECT payment_details FROM HB_users WHERE id=".$_SESSION['HAPPYBID_LOGGED_IN']),0,"payment_details");

require("header.php");
include phpa_include("template_payment_details_php.html");
include "./footer.php";

?>
