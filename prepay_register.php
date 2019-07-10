<?

//
//#// ################################################
//#// Is the seller logged in?
//if(!isset($_SESSION['HAPPYBID_LOGGED_IN'])) {
//    $REDIRECT_AFTER_LOGIN = "boards.php";
//    $_SESSION['REDIRECT_AFTER_LOGIN']=$REDIRECT_AFTER_LOGIN;
//
//    Header("Location: user_login.php");
//    exit;
//
//} 

include "./includes/config.inc.php";

$msg1 = isset($_POST["msg1"]) ? $_POST["msg1"] : "";
$msg2 = isset($_POST["msg2"]) ? $_POST["msg2"] : "";

include "header.php";
include phpa_include("template_post_registered_php.html");
include "footer.php";
exit;




?>
