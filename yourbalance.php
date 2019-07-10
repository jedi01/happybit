<?

require('./includes/config.inc.php');


#// If user is not logged in redirect to login page
if(!isset($_SESSION["HAPPYBID_LOGGED_IN"])) {
	Header("Location: user_login.php");
	exit;
}

$query = "select * from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
$result = @mysql_query($query);
if(!$result) {
	MySQLError($query);
	exit;
} else {
	$USER = mysql_fetch_array($result);
	$TPL_nick 		= $USER['nick'];
	$TPL_id 		= $USER['id'];
	$TPL_balance 	= $USER['balance'];
	$TPL_offers 	= $USER['offers'];
	
	// save data for payment redirection
	$_SESSION['MSG_001'] = $MSG_001;
	$_SESSION['MSG_016'] = $MSG_016;
	$_SESSION['TPL_email_hidden'] = $USER['email'];
	$_SESSION['TPL_id_hidden'] = $USER['id'];
	$_SESSION['payment_type'] = "add_funds";	
}

include "header.php";
include phpa_include("template_user_menu_header.html");
?>

	<script>
	function showPayments(el_id){
		document.getElementById("nopayment_tr").style.display ="none";
		document.getElementById("paypal_tr").style.display ="none";
	   
		document.getElementById("bank_tr").style.display ="none";
		document.getElementById(el_id).style.display ="";    
	}
	</script>
	<style type="text/css">
<!--
.style1 {font-family: Arial, Helvetica, sans-serif}
.style2 {font-weight: bold}
-->
    </style>
    
<table width="100%" width='100%' cellpadding="0" cellspacing="0" border="0" id="page_wrapper">
<tr>
	<td>
		
	<div style='text-align:center; font-size:15px; font-weight:bold; margin-left:15px;margin-right:15px;padding:2px; background-color: #cccccc;'>
		<div><?=$MSG_31_0002;?>: <?=$TPL_balance;?></div>
	</div>
		
		
    <table border="0" cellpadding="4" align="center" >
      <tr>
   <td align="center">
   <br>
   <a href="#" onclick="startGateway('MzYzNTM%3D');"><img src="images/get_free_bids.png" border="0"></a>
   &nbsp;&nbsp;
   <a href="#" onclick="startGateway('Mzc1Mjc%3D');"><img src="images/buy_bids.png" border="0"></a>
   </td>
    </tr>
 
	</table>

	
	</td>
</tr>
</table>
	
<? include phpa_include("template_user_menu_footer.html"); ?>      
