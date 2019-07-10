<?

require "./includes/config.inc.php";

//-- Get auction_id from sessions variables

if (!isset($_POST['auction_id']) && !isset($_GET['auction_id'])) {
  $auction_id = $_SESSION["CURRENT_ITEM"];
} else {
  $_SESSION["CURRENT_ITEM"]=intval($_GET[auction_id]);
}
/*$query = "select u.id,u.email,u.nick
          FROM   HB_users u,
              HB_auctions a
          WHERE u.id=a.user
          AND a.id=$auction_id";*/
$query = "select * FROM HB_users WHERE id=".intval($_REQUEST['user_id']);
$result = mysql_query($query);
if(!$result) {
  MySQLError($query);
  exit;
} else {
  $user_id= @mysql_result($result,0,"id");
  $email = @mysql_result($result,0,"email");
  $username = @mysql_result($result,0,"nick");
}

if (!isset($_POST['action'])) {
  /*
  display form
  */
  $TPL_id_value = $_REQUEST[auction_id];
  
  include "header.php";
  include phpa_include("template_email_request_form.html");
  include "footer.php";
  exit;
} elseif($_POST['action'] == "proceed"  && basename($_SERVER["HTTP_REFERER"]) != basename($_SERVER["PHPSELF"])) {
  /*
  check username/password
  if correct: display user's email
  if incorrect: display form once again
  */
  
  if(!$_POST[TPL_sender_name] || !$_POST[TPL_sender_mail] || !$_POST[TPL_subject] || !$_POST[TPL_text]) {
    $TPL_error_text = $ERR_116;
    include "header.php";
    include phpa_include("template_email_request_form.html");
    include "footer.php";
    exit;
  } else {
    //-- Send e-mail message
    $from = "From:$_POST[TPL_sender_name] <$_POST[TPL_sender_mail]>\n"."Content-Type: text/html; charset=$CHARSET";
    $subject = "$MSG_335 $SETTINGS[sitename] $MSG_336 $auction_id";
    mail($email,$subject,$MSG_30_0001." ".$MSG_240.": ".$_POST[TPL_sender_mail]."<br><br>".$_POST[TPL_subject]."<br><br>".$_POST[TPL_text],$from);
    include "header.php";
    include phpa_include("template_email_request_result.html");
    include "footer.php";
    exit;
    
  }
}
?>