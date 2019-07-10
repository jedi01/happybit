<?

include "./includes/config.inc.php";
//--
if (!isset($_POST['auction_id']) && !isset($_GET['auction_id'])) {
  $auction_id = $sessionVars["CURRENT_ITEM"];
} else {
  $sessionVars["CURRENT_ITEM"]=$auction_id;
}

include "header.php";

if ($_SERVER['REQUEST_METHOD']=="GET" && !$_POST['action']) {
  $query = "SELECT suspended FROM HB_users WHERE id=".intval($_GET['id']);
  $result = mysql_query($query);
  if(!$result) {
    MySQLError($query);
    exit;
  } elseif(mysql_num_rows($result) ==0) {
    $TPL_errmsg = $ERR_025;
    $TPL_err = 1;
  } elseif(mysql_result($result,0,suspended) == 0) {
    $TPL_errmsg = $ERR_039;
    $TPL_err = 1;
  } elseif(mysql_result($result,0,suspended) == 2) {
    $TPL_errmsg = $ERR_039;
    $TPL_err = 1;
  }
  
  if($TPL_err) {
    include phpa_include("template_confirm_error_php.html");
  } else {
    if($SETTINGS[signupfee] == 1 && $SETTINGS[invoicing] != 'y') {
      $NEWUSER_ID = $_GET['id'];
      $_SESSION["NEWUSER_ID"]=$NEWUSER_ID;
      include phpa_include("template_confirm_fee_php.html");
    } else {
      include phpa_include("template_confirm_php.html");
    }
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST" && $_POST['action'] == $MSG_249) {
  //-- User wants to confirm his/her registration
  
  $query = "UPDATE HB_users SET suspended=0,reg_date=reg_date where id=".intval($_POST['id'])." and suspended = 8";
  $res = mysql_query($query);
  if(!$res) {
    MySQLError($query);
    exit;
  }
  
  /* Update column users inactiveusers in table HB_counters */
  $counteruser = mysql_query("UPDATE HB_counters SET users=(users+1),inactiveusers=(inactiveusers-1)");

  include phpa_include("template_confirmed_php.html");
}

if ($_SERVER['REQUEST_METHOD']=="POST" && $_POST['action'] == $MSG_250) {
  //-- User doesn't want to confirm hid/her registration
  $query = "DELETE FROM HB_users where id=".intval($_POST['id']);
  $res = mysql_query($query);
  if(!$res) {
    MySQLError($query);
    exit;
  }
  /* Update column inactiveusers in table HB_counters */
  $counteruser = mysql_query("UPDATE HB_counters SET inactiveusers=(inactiveusers-1)");
  include phpa_include("template_confirmed_refused_php.html");
}


include "footer.php";

$TPL_err=0;
$TPL_errmsg="";
?>
