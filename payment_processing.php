<?
	//session_start();

	include "./includes/config.inc.php";	
	include $include_path."countries.inc.php";
	include $include_path."checkage.inc.php";
	include $include_path."cc.inc.php";
	include $include_path."banemails.inc.php";

	require("includes/ipn_cls.php");
	$custom = isset($_POST["custom"]) ? $_POST["custom"] : array();
	//$custom='add_funds====4==';
	$custom_splitted = split("==", $custom);
	$SESSION['payment_type'] = $custom_splitted[0];
	$SESSION['auction_id'] = $custom_splitted[1];
	$SESSION['TPL_id_hidden'] = $custom_splitted[2];
	$SESSION['pre_registration'] = $custom_splitted[3];

	/*echo"<pre>";
	print_r($SESSION);
	echo"</pre>";
	exit;*/
	
	$paypal_info = $_REQUEST;
	$paypal_ipn = new paypal_ipn($paypal_info);
	$status = $paypal_ipn->get_payment_status();
	if (trim($status) == "")  $status = isset($_REQUEST['st']) ? $_REQUEST['st'] : "";
    //$status='Completed';
	switch ($status)

	{
		case 'Pending':
			
			$pending_reason=$paypal_ipn->paypal_post_vars['pending_reason'];
			if ($pending_reason!="intl") {
				$msg = "Pending Payment - $pending_reason";
				//$paypal_ipn->error_out("Pending Payment - $pending_reason", $em_headers);
				break;
			}	
	
		case 'Completed':							

				$bonus = 0;
				$offers = 0;
				$amount = floatval($paypal_ipn->paypal_post_vars['mc_gross']);
				//$amount=60;
				if(isset($SESSION['payment_type']) && ($SESSION['payment_type'] == "add_funds_revolution")){
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
					$auction_id = isset($SESSION['auction_id']) ? $SESSION['auction_id'] : "0"; 
					// add offers to user's balance
					$query = "SELECT * FROM HB_auctions_signed WHERE auction_id = ".intval($auction_id)." AND user_id = ".intval($SESSION['TPL_id_hidden'])."";
					$result = mysql_query($query);
					if($row = mysql_fetch_assoc($result)){
						$query = "UPDATE HB_auctions_signed SET offers = offers + ".intval($offers)." WHERE auction_id = ".intval($auction_id)." AND user_id = ".intval($SESSION['TPL_id_hidden'])."";
						@mysql_query($query);
					}else{						
						$query = "INSERT INTO
							HB_auctions_signed(
								id, auction_id, user_id, offers
							) VALUES (
								NULL,
								".intval($auction_id).",
								".intval($SESSION['TPL_id_hidden']).",
								".intval($offers)."
							)";
						@mysql_query($query);
					}					
					if(@mysql_affected_rows()){
						$msg = str_replace("_OFFERS_", $offers, $MSG_31_0042); // was registred
						// add to history table
						add_to_history($amount, "PayPal", "Adding offers: ".$offers."");
					}						
				}else{
				# //////////////////////////////////////////////////////////
				# Add funds on registration or add funds for Classic auction
					
					if(isset($SESSION['payment_type']) && ($SESSION['payment_type'] != "add_funds")){
					// add funds after login						
						/*if(($amount > 0) && ($amount < 20)){					
							$bonus = 2;
							$offers = 0;
						}else if($amount < 50){
							$bonus = 10;
							$offers = 0;
						}else if($amount >= 50){
							$bonus = 20;
							$offers = 0;
						}*/
					}					
					
					// add funds to user's balance					
					$query = "UPDATE HB_users SET balance = (balance + ".number_format($amount, 2, '.', '')." + ".number_format($bonus, 2, '.', '')."), offers = ".$offers." WHERE id =".intval($SESSION['TPL_id_hidden']);
					@mysql_query($query);
					if(@mysql_affected_rows()){
						
						if(isset($SESSION['payment_type']) && ($SESSION['payment_type'] == "add_funds")){
							// add funds after login
							//$msg = $MSG_31_0044; // thanks
							$msg = "Il tuo pagamento egrave; stato registrato, clicca qui per tornare al tuo account.";
							$query = "SELECT id, email, name FROM HB_users WHERE id =".intval($SESSION['TPL_id_hidden']);
							$result = mysql_query($query);
							/*if($row = mysql_fetch_assoc($result)){
								send_email($row['email'], $row['name']);	
							}*/
							// add to history table
							add_to_history($amount,  "PayPal", "Adding funds to account");
						}else{
							// add funds on registration
							$query = "UPDATE HB_users SET suspended = 0 WHERE id =".intval($SESSION['TPL_id_hidden']);
							@mysql_query($query);
							if(@mysql_affected_rows()){
								$msg = $MSG_31_0044; // thanks
								$query = "SELECT id, email, name FROM HB_users WHERE id =".intval($SESSION['TPL_id_hidden']);
								$result = mysql_query($query);
								/*if($row = mysql_fetch_assoc($result)){
									send_email($row['email'], $row['name']);	
								}*/
								// add to history table
								add_to_history($amount,  "PayPal", "Adding funds on registration");								
							}else{
								$msg = $MSG_31_0043; // error
							}											
						}
						
					}else{
						$msg = $MSG_31_0043; // error
					}
					
				}

			break;

		case 'Updated':
			// updated already
			$msg = "Thank you for your payment!<br><br>";
		break;
			
		case 'Failed':
			// this will only happen in case of echeck.
			$msg = "Failed Payment";			
		break;
	
		case 'Denied':
			// denied payment by us
		break;
	
		case 'Refunded':
			// payment refunded by us
			$msg = "Refunded Payment";			
		break;
	
		case 'Canceled':
			// reversal cancelled
			// mark the payment as dispute cancelled
			$msg = "Cancelled reversal";			
		break;
	
		default:
			// order is not good
			$msg = "Unknown Payment Status - please contact site administrator.";// . $paypal_ipn->get_payment_status();
		break;
	
	}

//nclude phpa_include("template_registered_php.html");
    
	if(isset($SESSION['pre_registration']) && ($SESSION['pre_registration'] != "")){
		$_REQUEST['pre_registration'] = $SESSION['pre_registration'];
	}else{
		$_REQUEST['pre_registration'] = "";		
	}

	function add_to_history($amount,$payment_type, $description){
		global $SESSION;
		$query = "INSERT INTO HB_payments (
				user_id, amount, payment_date, payment_type, description
				) VALUES (
					".intval($SESSION['TPL_id_hidden']).",
					".floatval($amount).",
					'".date("Y-m-d h:i:s")."',
					'".$payment_type."',
					'".$description."'					
				)							
			";
		//echo $query;	
		$result = mysql_query($query);									
	}
	
	function send_email($user_email, $user_name){
		if(isset($_COOKIE['USERLANGUAGE'])) {
		  $USERLANG = $_COOKIE['USERLANGUAGE'];
		} else {
		  $USERLANG = $SETTINGS['defaultlanguage'];
		}
		$include_path = "includes/";
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
		
		//mail($user_email,"$MSG_098",$message,"From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET");
		My_SendMail($user_email, $MSG_098, $message);
	}

	function My_SendMail($mail_to, $msg_title, $message){	
		global $SETTINGS;
		$CHARSET = "utf-8";
		$headers = "From: $SETTINGS[sitename] <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET";
		mail($mail_to, $msg_title, $message, $headers);
	}


	
?>