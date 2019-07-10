<?

require('./includes/config.inc.php');

#// ################################################
#// Is the seller logged in?
if(!isset($_SESSION["HAPPYBID_LOGGED_IN"])) {
  $_SESSION["REDIRECT_AFTER_LOGIN"]="select_category.php";
  Header("Location: user_login.php");
  exit;
}
#// ################################################

if(!isset($_POST['action'])) //already closed auctions
{
  #// Get Closed auctions data
  unset($_SESSION["sessionVars"]);
  unset($sessionVars);
  unset($_SESSION['RELISTEDAUCTION']);
  unset($RELISTEDAUCTION);
  unset($FEATURED);
  unset($_SESSION["UPLOADED_PICTURES"]);
  unset($_SESSION["UPLOADED_PICTURES_SIZE"]);
  unset($_SESSION["GALLERY_UPDATED"]);
  unset($UPLOADED_PICTURES);
  unset($UPLOADED_PICTURES_SIZE);
  unset($GALLERY_UPDATED);
  $query="SELECT * FROM HB_auctions WHERE id=".intval($_GET['id'])." AND user='".$_SESSION["HAPPYBID_LOGGED_IN"]."'";

  $RELISTEDAUCTION = mysql_fetch_array(@mysql_query($query));
  
  $_SESSION['RELISTEDAUCTION'] = $RELISTEDAUCTION;
  $sessionVars=array();
  $sessionVars["SELL_auction_id_old"]   = $RELISTEDAUCTION['id'];
  $sessionVars["SELL_starts"] = date("YmdHis",time()+$SETTINGS['timecorrection']*3600);

  $sessionVars["SELL_title"]         = $RELISTEDAUCTION['title'];
  $sessionVars["SELL_description"]     = $RELISTEDAUCTION['description'];
  $sessionVars["SELL_atype"]         = $RELISTEDAUCTION['auction_type'];
  $sessionVars["SELL_iquantity"]      = $RELISTEDAUCTION['quantity'];
  
  $sessionVars["SELL_minimum_bid"]     = $RELISTEDAUCTION['minimum_bid'];
  if(doubleval($RELISTEDAUCTION['reserve_price']) > 0)
  {
    $sessionVars["SELL_reserve_price"]   = $RELISTEDAUCTION['reserve_price'];
    $sessionVars["SELL_with_reserve"]  = 'yes';
  }
  else
  {
    $sessionVars["SELL_reserve_price"]   = '';
    $sessionVars["SELL_with_reserve"]  = 'no';
  }
  
  $_SESSION["sellcat"]           = $RELISTEDAUCTION['category'];
  $sessionVars["SELL_sellcat"]      = $RELISTEDAUCTION['category'];
  if(doubleval($RELISTEDAUCTION['buy_now']) > 0)
  {
    $sessionVars["SELL_buy_now_price"]   = $RELISTEDAUCTION['buy_now'];
    $sessionVars["SELL_with_buy_now"]  = 'yes';
  }
  else
  {
    $sessionVars["SELL_buy_now_price"]   = '';
    $sessionVars["SELL_with_buy_now"]  = 'no';
  }
  $sessionVars["SELL_duration"]       = $RELISTEDAUCTION['duration'];
  $sessionVars["SELL_relist"]       = $RELISTEDAUCTION['relist'];
  if(doubleval($RELISTEDAUCTION['increment']) > 0)
  {
    $sessionVars["SELL_increment"]       = "2";
    $sessionVars["SELL_customincrement"]   = $RELISTEDAUCTION['increment'];
  }
  else
  {
    $sessionVars["SELL_increment"]       = "1";
    $sessionVars["SELL_customincrement"]   = '';
  }
  $sessionVars["SELL_country"]       = $RELISTEDAUCTION['location'];
  $sessionVars["SELL_location_zip"]     = $RELISTEDAUCTION['location_zip'];
  $sessionVars["SELL_shipping"]       = $RELISTEDAUCTION['shipping'];
  $sessionVars["SELL_shipping_terms"]    = $RELISTEDAUCTION['shipping_terms'];
  $sessionVars["SELL_payment"]       = explode("\n",$RELISTEDAUCTION['payment']);    
  $sessionVars["SELL_international"]     = $RELISTEDAUCTION['international'];
  $sessionVars["SELL_imgtype"]       = $RELISTEDAUCTION['imgtype'];
  $sessionVars["SELL_file_uploaded"]     = $RELISTEDAUCTION['photo_uploaded'];
  $sessionVars["SELL_pict_url"]       = $RELISTEDAUCTION['pict_url'];
  $sessionVars["SELL_sendemail"]       = $RELISTEDAUCTION['sendemail'];

  $_SESSION["sessionVars"]=$sessionVars;
  header("Location: sell.php?mode=recall");
}

?>
