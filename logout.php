<?

	include "includes/config.inc.php";
	
	$fb_app_id = $SETTINGS['fb_app_id'];
	unset($_SESSION['fb_{.$fb_app_id.}_code']);
	unset($_SESSION['fb_{.$fb_app_id.}_access_token']);
	unset($_SESSION['fb_{.$fb_app_id.}_user_id']);

	$userid = $_SESSION["HAPPYBID_LOGGED_IN"];

	unset($HAPPYBID_LOGGED_IN);
	unset($HAPPYBID_LOGGED_IN_USERNAME);
	unset($HAPPYBID_LOGGED_IN_NAME);
	unset($HAPPYBID_LOGGED_IN_EMAIL);
	unset($_SESSION["HAPPYBID_LOGGED_IN"]);
	unset($_SESSION["HAPPYBID_LOGGED_IN_USERNAME"]);
	unset($_SESSION["HAPPYBID_LOGGED_IN_NAME"]);
	unset($_SESSION["HAPPYBID_LOGGED_ACCOUNT"]);
	unset($_SESSION["HAPPYBID_LOGGED_IN_EMAIL"]);

	if(isset($_COOKIE['HAPPYBID_RM_ID'])) {
		@mysql_query("DELETE FROM HB_rememberme WHERE hashkey='".$_COOKIE['HAPPYBID_RM_ID']."'");
		setcookie("HAPPYBID_RM_ID","",time()-3600);
	}
	session_destroy();
	Header("Location: $SETTINGS[siteurl]"."index.php");
	exit;

?>
