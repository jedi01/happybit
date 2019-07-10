<?

include "./includes/config.inc.php";
include $include_path."messages.inc.php";
include $include_path."html.inc.php";
include $include_path.'wordfilter.inc.php';

if($SETTINGS[boards] == 'n') {
	Header("Location: index.php");
}

#// ################################################
#// Is the seller logged in?
if(!isset($_SESSION[HAPPYBID_LOGGED_IN])) {
	$REDIRECT_AFTER_LOGIN = "boards.php";
	$_SESSION["REDIRECT_AFTER_LOGIN"]=$REDIRECT_AFTER_LOGIN;

	Header("Location: user_login.php");
	exit;
}
#// ################################################

#//
$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
$NOW = date("YmdHis",$TIME);
$TOTALMSGS = mysql_result(mysql_query("SELECT count(id) AS count from HB_comm_messages WHERE boardid=".intval($_REQUEST['board_id'])),0,"count");

#// Insert new message in the database
if($_POST[action] == "insertmessage" && !empty($_POST[newmessage])) {
	if($SETTINGS[wordsfilter] == 'y') {
		$MSG_ = strip_tags(Filter($_POST[newmessage]));
	} else {
		$MSG_ = strip_tags($_POST[newmessage]);
	}
	$query = "INSERT INTO HB_comm_messages
				  VALUES
				  (NULL,
				  ".intval($_POST[board_id]).",
				  '$NOW',
				  '".intval($_SESSION[HAPPYBID_LOGGED_IN])."',
				  '".addslashes($_SESSION[HAPPYBID_LOGGED_IN_USERNAME])."',
				  '".addslashes($MSG_)."'
				  )";
	$res_ = @mysql_query($query);
	if(!$res_) {
		MySQLError($query);
		exit;
	}

	#// Update messages counter and lastmessage date
	$query = "UPDATE HB_community
				  SET
				  messages=messages+1, lastmessage='$NOW'
				  WHERE id=".intval($_POST[board_id]);
	$res__ = @mysql_query($query);
	if(!$res__) {
		MySQLError($query);
		exit;
	}
}


#// retrieve message board title
$query = "SELECT name,active,msgstoshow FROM HB_community WHERE id=".intval($_REQUEST['board_id']);
$res_b = @mysql_query($query);
if(!$res_b) {
	MySQLError($query);
	exit;
} else {
	$BOARD_TITLE = mysql_result($res_b,0,"name");
	$BOARD_ACTIVE = mysql_result($res_b,0,"active");
	$BOARD_LIMIT = mysql_result($res_b,0,"msgstoshow");
}

if(!isset($_GET['PAGE']) || $PAGE == 1 || $PAGE == 0 || $PAGE == "") {
	$OFFSET = 0;
	$PAGE = 1;
} else {
	$OFFSET = ( $PAGE - 1) * $BOARD_LIMIT;
}
$PAGES = ceil($TOTALMSGS / $BOARD_LIMIT);
if(!$PAGES) $PAGES = 1;

if($BOARD_ACTIVE == 2) {
	Header("Location: boards.php");
	exit;
}

if($_GET[show] == "all") {
	$SQL_LIMIT = "";
} else {
	$SQL_LIMIT = " LIMIT $OFFSET,$BOARD_LIMIT";
}

#// Retrieve messages for this message board
$query = "SELECT * FROM HB_comm_messages WHERE boardid=".intval($_REQUEST['board_id'])." ORDER BY msgdate DESC $SQL_LIMIT";
$res_msgs = @mysql_query($query);
if(!$res_msgs) {
	MySQLError($query);
	exit;
}

#// Count message
$query = "SELECT count(id) as COUNT FROM HB_comm_messages";
$r_ = @mysql_query($query);
if(!$r_) {
	MySQLError($query);
	exit;
} else
{
	$COUNT = @mysql_result($r_,0,"COUNT");
}


#// Build the bottom navigation line for the template
if($COUNT > $BOARD_LIMIT && $_GET[show] != "all") {
	$NAVIGATION = "<a href=".basename($_SERVER['PHP_SELF'])."?show=all&offset=".$_REQUEST['offset']."&board_id=".$_REQUEST['board_id'].">$MSG_5062</a> ($COUNT)";
} elseif($_GET[show] == "all") {
	$NAVIGATION = "<a href=".basename($_SERVER['PHP_SELF'])."?board_id=".$_REQUEST['board_id']."&offset=".$_REQUEST['offset'].">&lt;&lt; $MSG_5066</a> ";
} else {
	$NAVIGATION = "";
}

include "header.php";
include phpa_include("template_msgboard_php.html");
include "footer.php";

?>
