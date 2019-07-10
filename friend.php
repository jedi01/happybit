<?

// Connect to sql server & inizialize configuration variables
require('./includes/config.inc.php');

if (!isset($_POST['id']) && !isset($_GET['id'])) {
	$id = intval($_SESSION["CURRENT_ITEM"]);
} else {
	$_SESSION["CURRENT_ITEM"]=$_GET['id'];
}

$TPL_error_text = "";
$TPL_auction_id = $_REQUEST['id'];
$TPL_friend_name_value = $_POST['friend_name'];
$TPL_friend_email_value = $_POST['friend_email'];
$TPL_sender_name_value = $_POST['sender_name'];
$TPL_sender_email_value = $_POST['sender_email'];
$TPL_sender_comment_value = $_POST['sender_comment'];

$auction_id = $_REQUEST['id'];
$friend_name = $_POST['friend_name'];
$friend_email = $_POST['friend_email'];
$sender_name = $_POST['sender_name'];
$sender_email = $_POST['sender_email'];
$sender_comment = $_POST['sender_comment'];
$item_title = $_POST['item_title'];

//--Get item data
$query = "select title,category from HB_auctions where id=".intval($_GET['id']);
$result = mysql_query($query);
if(!$result) {
	MySQLError($query);
	exit;
} elseif(mysql_num_rows($result) > 0) {
	$TPL_item_title = stripslashes(mysql_result($result,0,"title"));
}

if (empty($_POST['action'])) {
	include "header.php";
	include phpa_include("template_friend_php.html");
	include "footer.php";
	exit;
}

if($_POST['action'] == 'sendmail' && basename($_SERVER['HTTP_REFERER']) != basename($_SERVER['PHPSELF'])) {
	//--Check errors
	if(!$_POST['sender_name'] || !$_POST['sender_email'] || !$_POST['friend_name'] || !$_POST['friend_email']) {
		$TPL_error_text = $ERR_032;
	}
	
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$",$_POST['sender_email']) ||
	!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$",$_POST['friend_email'])) {
		$TPL_error_text = $ERR_008;
	}
	
	if (strlen($TPL_error_text)>0) {
		include "header.php";
		include phpa_include("template_friend_php.html");
		include "footer.php";
		exit;
	}
	
	//-- Send e-mail message
	include $include_path.'friend_confirmation.inc.php';
	
	//-- Display confirmation web page
	include "header.php";
	include phpa_include("template_friend_confirmation_php.html");
	include "footer.php";
	exit;
}
?>
