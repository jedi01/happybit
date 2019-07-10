<?

require('./includes/config.inc.php');

#// If user is not logged in redirect to login page
if(!isset($_SESSION["HAPPYBID_LOGGED_IN"])) {
  Header("Location: user_login.php");
  exit;
}

require("header.php");

// Auction id is present, now update table
if (($_GET['add']) && (!$_GET['add']=="")) {
  // Check if this item is not already added

  $query = "SELECT item_watch from HB_users where nick='".addslashes($_SESSION[HAPPYBID_LOGGED_IN_USERNAME])."'";
  $result = @mysql_query("$query");
  if(!$result) {
    MySQLError($query);
    exit;
  }
  $items = trim(mysql_result ($result,0,"item_watch"));
  if ($items!="disabled") {
    $match = strstr($items, $_GET['add']);
    $items = $items;
  } else { 
    $items = ""; 
  }

  if (!$match) {
    $item_watch = trim("$items ".$_GET['add']);
    $item_watch_new = trim($item_watch);
    $query = "UPDATE HB_users set item_watch='".addslashes($item_watch_new)."',reg_date=reg_date where nick='".addslashes($_SESSION[HAPPYBID_LOGGED_IN_USERNAME])."' ";
    $result = @mysql_query("$query");
    if(!$result) {
      MySQLError($query);
      exit;
    }
  }

  // Show results

  $query = "SELECT item_watch from HB_users where nick='".addslashes($_SESSION[HAPPYBID_LOGGED_IN_USERNAME])."' ";
  $result = @mysql_query("$query");
  if(!$result) {
    MySQLError($query);
    exit;
  }
  $items = trim(mysql_result ($result,0,"item_watch"));
  if(@mysql_num_rows($result) > 0) $HasResults = TRUE;
  if($HasResults) $TPL_item_watch.= "<TABLE width=95% cellpadding=4 cellspacing=1 border=0 ALIGN=center><TR><TH>$MSG_168</TH><TH>$MSG_299</TH></TR>";
  if (($items=="disabled") || ($items=="") || ($items=="NULL") ) { } else {
    $item = split(" ",$items);
    for ($j=0; $j < count($item); $j++)
    {
      if(!($j%2)) $BGCOLOR = "BGCOLOR=#FFFFFF"; else $BGCOLOR = "BGCOLOR=#EEEEEE";
      $query = "SELECT title from HB_auctions where id='".intval($item[$j])."' ";
      $result = @mysql_query("$query");
      if(!$result) {
        MySQLError($query);
        exit;
      } elseif(mysql_num_rows($result) > 0){
        $title = mysql_result ($result,0,"title");
        $TPL_item_watch.="<tr $BGCOLOR><td><a href='item.php?id=$item[$j]'> $title</a></td><td ALIGN=LEFT>
      <a href='item_watch.php?delete=$item[$j]'><IMG SRC=\"./images/trash.gif\" BORDER=0></a>
      </td></tr>";

      }
    }
  }
  if($HasResults) $TPL_item_watch.= "<TR><TD COLSPAN=2>&nbsp;</TD></TR></TABLE>";
}

// Delete item form item watch
if ($_GET['delete']) {
  $query = "SELECT item_watch from HB_users where nick='".addslashes($_SESSION[HAPPYBID_LOGGED_IN_USERNAME])."' ";
  $result = @mysql_query("$query");
  if(!$result) {
    MySQLError($query);
    exit;
  }
  $items = trim(mysql_result ($result,0,"item_watch"));

  $auc_id = split(" ",$items);
  for ($j=0; $j < count($auc_id); $j++) {
    $match = strstr($auc_id[$j],$_GET['delete']);
    if ($match) { 
      $item_watch = $item_watch; 
    } else {
      $item_watch = "$auc_id[$j] $item_watch";
    } 
  }
  $item_watch_new = trim($item_watch);
  if (($item_watch_new=="") || ($item_watch_new==" ")) { $item_watch_new="disabled"; }
  $query = "UPDATE HB_users set item_watch='$item_watch_new',reg_date=reg_date where nick='".addslashes($_SESSION[HAPPYBID_LOGGED_IN_USERNAME])."' ";
  $result = @mysql_query("$query");
  if(!$result) {
    MySQLError($query);
    exit;
  }

  // Show results

  $query = "SELECT item_watch from HB_users where nick='".addslashes($_SESSION[HAPPYBID_LOGGED_IN_USERNAME])."' ";
  $result = @mysql_query("$query");
  if(!$result) {
    MySQLError($query);
    exit;
  }
  $items = trim(mysql_result ($result,0,"item_watch"));
  if(@mysql_num_rows($result) > 0) $HasResults = TRUE;
  if($HasResults) $TPL_item_watch.= "<TABLE width=95% cellpadding=4 cellspacing=1 border=0 ALIGN=center><TR><TH>$MSG_168</TH><TH>$MSG_299</TH></TR>";

  if (!(($items=="disabled") || ($items=="") || ($items=="NULL"))) {
    $item = split(" ",$items);
    for ($j=0; $j < count($item); $j++) {
      if(!($j%2)) $BGCOLOR = "BGCOLOR=#FFFFFF"; else $BGCOLOR = "BGCOLOR=#EEEEEE";
      $query = "SELECT title from HB_auctions where id=".intval($item[$j]);
      $result = @mysql_query("$query");
      if(!$result) {
        MySQLError($query);
        exit;
      }
      $title = mysql_result ($result,0,"title");
      $TPL_item_watch.="<tr $BGCOLOR><td><a href='item.php?id=$item[$j]'> $title</a></td><td ALIGN=LEFT>
      <a href='item_watch.php?delete=$item[$j]'><IMG SRC=\"./images/trash.gif\" BORDER=0></a>
      </td></tr>";
    }
  }
  if($HasResults) $TPL_item_watch.= "<TR><TD COLSPAN=2>&nbsp;</TD></TR></TABLE>";
}

// Show results if nothing changed
if ((!$_GET['add']) && (!$_GET['delete'])) {
  $query = "SELECT item_watch from HB_users where nick='".addslashes($_SESSION[HAPPYBID_LOGGED_IN_USERNAME])."' ";
  $result = @mysql_query("$query");
  if(!$result) {
    MySQLError($query);
    exit;
  }
  $items = trim(mysql_result ($result,0,"item_watch"));
  if(@mysql_num_rows($result) > 0) $HasResults = TRUE;
  if($HasResults) $TPL_item_watch.= "<TABLE width=95% cellpadding=4 cellspacing=1 border=0 ALIGN=center><TR><td colspan=2>No auctions currently being watched</td></tr>";

  if (($items=="disabled") || ($items=="") || ($items=="NULL")) {
  } else {
    $item = split(" ",$items);
    for ($j=0; $j < count($item); $j++) {
        if(!($j%2)) $BGCOLOR = "BGCOLOR=#FFFFFF"; else $BGCOLOR = "BGCOLOR=#EEEEEE";
      $query = "SELECT title from HB_auctions where id='$item[$j]' ";
      $result = @mysql_query("$query");
      if(!$result)
      {
        MySQLError($query);
        exit;
      }
      elseif(mysql_num_rows($result) > 0)
      {
        $title = mysql_result ($result,0,"title");
        $TPL_item_watch.="<tr $BGCOLOR><td><a href='item.php?id=$item[$j]'> $title</a></td><td ALIGN=LEFT>
              <a href='item_watch.php?delete=$item[$j]'><IMG SRC=\"./images/trash.gif\" BORDER=0></a>
              </td></tr>";
      }
    }
  }
  if($HasResults) $TPL_item_watch.= "<TR><TD COLSPAN=2>&nbsp;</TD></TR></TABLE>";
}

include phpa_include("template_item_watch_php.html");
include "./footer.php";

?>