<?
if(!defined("INCLUDED")) exit("Access denied");

$prefix = str_replace("http://", "", $prefix);
if ( file_exists($prefix.'./includes/config.inc.php'))
  require($prefix.'./includes/config.inc.php');
else
  exit ("Access forbbiden");

#// Atuomatically login user is necessary ("Remember me" option
if(!isset($_SESSION["HAPPYBID_LOGGED_IN"]) && isset($_COOKIE['HAPPYBID_RM_ID'])) {
	$query = "SELECT userid FROM HB_rememberme WHERE hashkey='".addslashes($_COOKIE['HAPPYBID_RM_ID'])."'";
	$res = mysql_query($query);
	if(!$res){
		MySQLError($query);
		exit;
	}elseif(mysql_num_rows($res) > 0){
		$REMEMBER = mysql_fetch_array(mysql_query("SELECT id,email,nick,name FROM HB_users WHERE id=".intval(mysql_result($res,0,"userid"))));
		mysql_error();
		$_SESSION["HAPPYBID_LOGGED_IN"] = $REMEMBER['id'];
		$_SESSION["HAPPYBID_LOGGED_EMAIL"] = $REMEMBER['email']; 
		$_SESSION["HAPPYBID_LOGGED_NAME"] = $REMEMBER['name'];
		$_SESSION["HAPPYBID_LOGGED_IN_USERNAME"] = $REMEMBER['nick'];
	}
}

/** *************************************************************************
* NOTE: Modules enbled version
* This version of header.php can be called from any HAPPYBID XL module
* It uses the $prefix variable to set the correct include path.
*
*
*****************************************************************************/

include $prefix."includes/ips.inc.php";
//-- Function definition section
include $prefix."includes/dates.inc.php";

include $prefix."maintenance.php";
include $prefix."includes/banners.inc.php";

if(isset($_GET['ref']))
{
	$referral_ID = $_GET['ref'];
	$expire=time()+60*60*24*30;
        $cookieName = "bidreferral";
	setcookie($cookieName, $referral_ID, $expire);
}


#//
if(basename($PHP_SELF) != "error.php")
{
	include $prefix."includes/stats.inc.php";
}
// flag to enable style editor
$editstyle=isset($_SESSION["HAPPYBID_ADMIN_USER"]) && !isset($_GET['thepage']);
$editstyle=$editstyle && $prefix=="";
// Added by Edgar 12/09/2005
// to handle relative paths to themes when browsing webstores
// Seeks path to header.php.html in address of being at home directory or webstores module


if (!isset($SETTINGS['theme']) || empty($SETTINGS['theme'])) $SETTINGS['theme']='default';
$htmlheader="themes/".$SETTINGS['theme']."/header.php.html";

if (!file_exists($htmlheader)) {
	$htmlheader="../../themes/".$SETTINGS['theme']."/header.php.html";
}


include($htmlheader);
?>
