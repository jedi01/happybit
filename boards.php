<?

include("./includes/config.inc.php");

if($SETTINGS['boards'] == 'n') {
	Header("Location: index.php");
}


#// ################################################
#// Is the seller logged in?
if(!isset($_SESSION['HAPPYBID_LOGGED_IN'])) {
	$REDIRECT_AFTER_LOGIN = "user_menu.php";
	$_SESSION['REDIRECT_AFTER_LOGIN']=$REDIRECT_AFTER_LOGIN;

	Header("Location: user_login.php");
	exit;
}
#// ################################################

//#// Retrieve message boards from the database
//$query = "SELECT * FROM HB_community WHERE active=1 ORDER BY name";
//$ress_ = @mysql_query($query);
//if(!$ress_) {
//	$TMP_ERROR =  "Error: $query<BR>".mysql_error();
//	$_SESSION["TMP_ERROR"]=$TMP_ERROR;
//
//	Header("Location: error.php");
//	exit;
//}
//
//include "./header.php";
//include phpa_include("template_boards_php.html");
//include "./footer.php";

?>
