<?

require('./includes/config.inc.php');

#// If user is not logged in redirect to login page
if(!isset($_SESSION["HAPPYBID_LOGGED_IN"])) {
	Header("Location: user_login.php");
	exit;
}

  // get achievements information  
  $query = "select * from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
  $result = @mysql_query($query);
  $TPL_balance = "0";
  if(!$result) {
      MySQLError($query);
      exit;
  } else {
      $USER = mysql_fetch_array($result);
      $subid= $USER['nick'];
      $USER_ID = $USER['id'];
      $TPL_nick = $USER['nick'];
	  $A1 = $USER['a1'];
	  $A2 = $USER['a_wins'];
	  $A3 = $USER['a3'];
	  $A4 = $USER['a4'];
	  $A5 = $USER['a_packs'];
	  $A6 = $USER['a6'];
	  $A7 = $USER['a7'];
	  $A8 = $USER['a8'];
	  $A9 = $USER['a_feedback'];
	  $A10 = $USER['a10'];
	  $A11 = $USER['verified'];
	  $A12 = $USER['a_poser'];
	  $A13 = $USER['a_tweet'];
	  $A14 = $USER['a_faceb'];
	  $A15 = $USER['a_25coins'];
	  $A16 = $USER['a_50coins'];
	  $A17 = $USER['a_100coins'];
	  $A18 = $USER['a_200coins'];
	  $A19 = $USER['a19'];
	  $A20 = $USER['a20'];
	  $A21 = $USER['a21'];
	  $A22 = $USER['regtime'];
	  $A23 = $USER['a23'];
	  $A24 = $USER['a24'];
	  $A25 = $USER['a_survey'];
	  $A26 = $USER['a_2coin'];
	  $A27 = $USER['a_3coin'];
	  $A28 = $USER['a_5coin'];
	  $A29 = $USER['a_daylight'];
	  $A30 = $USER['a_bargain'];
	  $A31 = $USER['a_lightning'];
	  $A32 = $USER['a32'];
	  $A33 = $USER['a33'];
	  $A34 = $USER['a34'];
	  $A35 = $USER['a35'];
	  $A36 = $USER['a36'];
	  $A37 = $USER['a37'];
	  $A38 = $USER['a38'];
	  $A39 = $USER['a39'];
	  $A40 = $USER['a40'];
  }


require("header.php");
include phpa_include("template_achievements_php.html");
include "./footer.php";

?>