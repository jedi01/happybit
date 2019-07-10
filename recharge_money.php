<?
    require('./includes/config.inc.php');
    
    #// Run cron according to SETTINGS
    if($SETTINGS['cron'] == 2) { include_once "cron.php"; }
    
    $auction_id = isset($_SESSION['auction_id']) ? $_SESSION['auction_id'] : "0"; 
    
    #// If user is not logged in redirect to login page
    if(!isset($_SESSION["HAPPYBID_LOGGED_IN"])) {
        Header("Location: user_login.php");
        exit;
    }
    
    $auction_is_closed = false;    
    $query = "select auction_type, closed from HB_auctions where ID=".intval($auction_id)."";
    $result = @mysql_query($query);
    if(!$result) {
        MySQLError($query);
        exit;
    } else {
        $AUCTION = mysql_fetch_array($result);
        $auction_type 	= $AUCTION['auction_type'];
        $closed 	    = $AUCTION['closed'];
        if(($auction_type == 1) && ($closed == "1")){
            $auction_is_closed = true;
        }else if((($auction_type == 2) || ($auction_type == 3)) && ($closed == "2")){
            $auction_is_closed = true;
        }        
    }

    $msg = $MSG_31_0045;    
    if(!$auction_is_closed){
        
		$bonus = 0;
		$offers = 0;
        $amount = isset($_POST['amount']) ? $_POST['amount'] : "0";         

        if(isset($_SESSION['payment_type']) && ($_SESSION['payment_type'] == "add_funds_revolution")){
            # //////////////////////////////////////////////////////////
            # buy bids (offers) for Revolution and RevolutionRebuy auctions
            switch($amount){
                case   "5.00": $offers = 10; break;
                case  "10.00": $offers = 20; break;
                case  "15.00": $offers = 30; break;
                case  "20.00": $offers = 40; break;
                case  "30.00": $offers = 65; break;
                case  "40.00": $offers = 90; break;
                case  "50.00": $offers = 110; break;
                case  "75.00": $offers = 170; break;							
                case "100.00": $offers = 250; break;														
                default: $offers = 10; break;
            }
            $auction_id = isset($_SESSION['auction_id']) ? $_SESSION['auction_id'] : "0"; 

            $query = "select balance from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
            $result = mysql_query($query);
            $current_balance = "0";
            if($row = mysql_fetch_assoc($result)){
                $current_balance = $row['balance'];
            }
            
            
            if(intval($current_balance) < intval($amount) || ($current_balance == "0")){
                $msg = $MSG_31_0041; // have no enough money
            }else{
                // add offers to user's balance
                $query = "SELECT * FROM HB_auctions_signed WHERE auction_id = ".intval($auction_id)." AND user_id = ".intval($_SESSION['TPL_id_hidden'])."";
                $result = mysql_query($query);
                if($row = mysql_fetch_assoc($result)){
                    $query = "UPDATE HB_auctions_signed SET offers = offers + ".intval($offers)." WHERE auction_id = ".intval($auction_id)." AND user_id = ".intval($_SESSION['TPL_id_hidden'])."";
                    @mysql_query($query);
                }else{						
                    $query = "INSERT INTO
                        HB_auctions_signed(
                            id, auction_id, user_id, offers
                        ) VALUES (
                            NULL,
                            ".intval($auction_id).",
                            ".intval($_SESSION['TPL_id_hidden']).",
                            ".intval($offers)."
                        )";
                    @mysql_query($query);
                }
                
                ;

                if(@mysql_affected_rows()){                    
                    // take funds from user's balance
                    $query = "UPDATE HB_users SET balance = (balance - ".number_format($amount, 2, '.', '').") WHERE id =".intval($_SESSION['TPL_id_hidden']);
                    @mysql_query($query);
                    // add to history table
                    add_to_history($amount, "0", "Account", "Recharged offers: ".$offers."");
                    $msg = str_replace("_OFFERS_", $offers, $MSG_31_0042); // was registered

					// send email to user
                    /*$query = "select nick, email from HB_users WHERE id =".intval($_SESSION['TPL_id_hidden']);
                    $res = mysql_query($query);
					if($res){
						$r2 = mysql_fetch_array($res);
						send_email($r2['email'],$r2['nick']);
					}*/
					
                }else{
                    $msg = $MSG_31_0043; // error
                }                
            }
        }        
    }else{
        $msg = $MSG_31_0023; // was closed
    }


    $query = "select * from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
    $result = @mysql_query($query);
    if(!$result) {
        MySQLError($query);
        exit;
    } else {
        $USER = mysql_fetch_array($result);
        $TPL_nick 		= $USER['nick'];
        $TPL_id 		= $USER['id'];			// auction ID
        $TPL_balance 	= $USER['balance'];
        $TPL_offers 	= $USER['offers'];
    }

    include "header.php";
    include phpa_include("template_user_menu_header.html");

?>

    <br />
    <table border="0" cellpadding="4" align="center">
    <tr>
        <td colspan="4">&nbsp;</td>
        <td>
            <table border="0" bgcolor="#E8E8E8" class="border">
            <tr>
                <td width="536" height="22px" valign="middle" style="">
                    <?=$msg;?>
                </td>
            </tr>
            </table>		
        </td>
    </tr>
    </table>


<?
 include phpa_include("template_user_menu_footer.html");  


	function add_to_history($amount, $bonus, $payment_type, $description){
		$query = "INSERT INTO HB_payments (
					id, user_id, amount, bonus, payment_date, payment_type, description
				) VALUES (
					NULL,
					".intval($_SESSION['TPL_id_hidden']).",
					".floatval($amount).",
					".floatval($bonus).",
					'".date("Y-m-d h:i:s")."',
					'".$payment_type."',
					'".$description."'					
				)							
			";
		$result = mysql_query($query);									
	}
	
	function send_email($user_email, $user_name){
		if(isset($_COOKIE['USERLANGUAGE'])) {
		  $USERLANG = $_COOKIE['USERLANGUAGE'];
		} else {
		  $USERLANG = $SETTINGS['defaultlanguage'];
		}
		$include_path = "./includes/";
		include $include_path."messages.EN.inc.php";
		$buffer = file($include_path."usermail_approved.EN.inc.php");
		$i = 0;
		$j = 0;
		while($i < count($buffer)) {
		  if(!ereg("^#(.)*$",$buffer[$i])){
			$skipped_buffer[$j] = $buffer[$i];
			$j++;
		  }
		  $i++;
		}
		
		//--Retrieve message
		$message = implode($skipped_buffer,"");
		$message = ereg_replace("<#c_name#>",$user_name,$message);
		$message = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$message);
		$message = ereg_replace("<#c_adminemail#>",$SETTINGS[adminmail],$message);
		//echo $user_email;
		//mail($user_email,"$MSG_098",$message,"From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET");
		My_SendMail($user_email, $MSG_098, $message);
	}

function My_SendMail($mail_to, $msg_title, $message){	
	//global $include_path;
	global $SETTINGS;
	//global $TIME;
	//$now = date("Y/m/d H:i:s",$TIME);
	$CHARSET = "utf-8";
	$headers = "From: $SETTINGS[sitename] <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET";
	//$headers = "From: AAa \r\n" . "Reply-To: admin@admin.com\r\n" . "Return-path:admin@admin.com\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET";
	mail($mail_to, $msg_title, $message, $headers);
}
//function My_SendMail($mail_to, $msg_title, $message){
//	//global $include_path;
//	global $SETTINGS;
//	//global $TIME;
//	//$now = date("Y/m/d H:i:s",$TIME);
//	$CHARSET = "iso-8859-1";
//	$headers = "From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET";
//	mail($mail_to, $msg_title, $message, $headers);
//}

    $_SESSION['MSG_001'] = "";
    $_SESSION['MSG_016'] = "";
    $_SESSION['TPL_email_hidden'] = "";
	$_SESSION['pre_registration'] = "";
	$_SESSION['TPL_id_hidden'] = "";
	$_SESSION['mc_gross'] = "";
	$_SESSION['payment_type'] = "";
	$_SESSION['auction_type'] = "";
	$_SESSION['auction_id'] = "";
	
?>
