<?

include "./includes/config.inc.php";
include $include_path."dates.inc.php";
include $include_path."membertypes.inc.php";

#// If user is not logged in redirect to login page
if(!isset($_SESSION["HAPPYBID_LOGGED_IN"])) {
	Header("Location: user_login.php");
	exit;
}

if (($_SERVER["REQUEST_METHOD"]=="GET" || !$_SERVER["REQUEST_METHOD"]))
{
	$secid = $_SESSION['HAPPYBID_LOGGED_IN'];
	$TPL_rater_nick=$_SESSION['HAPPYBID_LOGGED_IN_USERNAME'];
	$sql="SELECT nick, rate_sum, rate_num FROM HB_users WHERE id=".intval($secid);

	$res=mysql_query ($sql);
	if ($res)
	{
		if (mysql_num_rows($res)>0)
		{
			$arr=mysql_fetch_array ($res);
			$TPL_nick=$arr['nick'];
			$i=0;
		}
    } else {
		$TPL_err=1;
		$TPL_errmsg="$ERR_105";
    }
} else {
    $TPL_err=1;
    $TPL_errmsg="$ERR_106";
}

// Calls the appropriate templates
  include "header.php";
  include phpa_include("template_payment_history_php.html");
  include "footer.php";
?>
