<?
require('./includes/config.inc.php');
if(isset($_GET['zigzag']) && $_GET['zigzag'] == '5f7uy998') {
	$amounts1=array("10"=>"2.99","25"=>"4.99","50"=>"9.99","110"=>"19.99","230"=>"39.99","600"=>"99.99");

	$logedUser=$_SESSION["HAPPYBID_LOGGED_IN"];
	if($_SESSION['PIZ'] && $_SESSION['PIZ'] > 0) {
		$total_Coin=trim($_SESSION['PIZ']);
		$getrecords=mysql_query("select * from HB_users where id='$logedUser'");
		$row11=mysql_fetch_array($getrecords);

		$currentBalance=$row11['balance'];
	
		$currentBalance=$currentBalance+$total_Coin;

		mysql_query("update HB_users set balance='$currentBalance' where id='$logedUser'");
		// appending log detail into log file

		$defaultlist = array (
		    array('Date', 'Time', 'User ID', 'Coins','Paid','Account Email')
		);

		$date=date('d-m-y');
		$time=date('H:i:s', time());
		$userid=$row11['nick'];
		$coinsPurchased=$total_Coin;
		$paid=$amounts1[$total_Coin];
		$paypalEmaild=$row11['email'];

		$newlist=array (
			array ($date,$time,$userid,$coinsPurchased,$paid,$paypalEmaild)
		);

		$logfile = dirname($_SERVER['DOCUMENT_ROOT']).'/private/log_file.csv';

		if(file_exists ($logfile )) {
			$fp = fopen($logfile, 'a');
			foreach ($newlist as $fields) {
			    fputcsv($fp, $fields);
			}
			fclose($fp);
		} else {
			$fp = fopen($logfile, 'w');
			foreach ($defaultlist as $fields) {
			    fputcsv($fp, $fields);
			}
			fclose($fp);
		}

	}
	unset($_SESSION['PIZ']);
	$_SESSION['FIN_DONE']="Thankyou! Your Coins Have Been Updated.<br> Total:".$currentBalance;
	
	header("Location: http://happybid.co.uk/thankyou.php?complete");
	exit;
}


if (isset($_GET['complete'])) {
	require("header.php");
?>

<div class="content">
<div id="aph">
<?php
if($_SESSION['FIN_DONE']) {
echo $_SESSION['FIN_DONE'];
}
?>
<div style="margin-top:20px; margin-bottom:20px;"><a class="buttonbid" href="/index.php" target="_self" style="color:#FFFFFF;">Start Bidding!</a></div>
</div>
</div>
<script type="text/javascript">
var fb_param = {};
fb_param.pixel_id = '6006059240850';
fb_param.value = '0.00';
(function(){
  var fpw = document.createElement('script');
  fpw.async = true;
  fpw.src = '//connect.facebook.net/en_US/fp.js';
  var ref = document.getElementsByTagName('script')[0];
  ref.parentNode.insertBefore(fpw, ref);
})();
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6006059240850&amp;value=0" /></noscript>

<!-- Google Code for Coin Purchase Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1028770816;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "FO0wCNjVuwUQgJjH6gM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1028770816/?value=0&amp;label=FO0wCNjVuwUQgJjH6gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<?
include phpa_include("template_thankyou_php.html");
include "./footer.php";
}
?>