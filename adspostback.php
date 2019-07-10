<?php

include "./includes/config.inc.php";

$f=fopen("pb_log.txt","a+");
fputs($f,"\n\nAdscend postback called successfully\n");
fclose($f);

$mysql_where = $DbHost;
$mysql_username = $DbUser;
$mysql_password = $DbPassword;
$mysql_database = $DbDatabase;
				

mysql_connect($mysql_where, $mysql_username, $mysql_password);
mysql_select_db($mysql_database);

$ip = $_SERVER['REMOTE_ADDR'];

// IP RESTRICTIONS - HOW TO DISABLE IP RESTRICTION
// Comment out the line below to disable IP check for testing postback. Scroll down for other code to comment out. 
// To comment out a line, simply add two forward slashes like this //

// Number of bids a user gets from their referral
$refer_bids = $SETTINGS['refer_bids'];

if($SETTINGS[adscend_test]=="1")
{
//if(($ip == "72.52.162.102") || ($ip == "199.59.164.3") ||($ip == "199.59.164.5")){
    //grab and sanitize gets
    $cid    = $_GET['campid'];
    $name   = $_GET['name'];
    $rate   = $_GET['rate'];//payout - $1 = 5.00 bids - round up
    $subid  = $_GET['sid'];//subid
    $status = $_GET['status'];//1=good,2=bad
    $p_ip   = $_GET['ip'];

    $f=fopen("pb_log.txt","a+");
    fputs($f,"IP check successful\n");
    fclose($f);   
				
    //round calculate ticket amount
    $r = round($rate);
    $final_rate =floor($rate * 5);
    if($final_rate <=0){$final_rate=1;}

    if($status == "1"){
        $pdtshow = $final_rate;
        //referer check
        $query_checkRef = mysql_query("SELECT referrer from HB_users WHERE nick='".$subid."'") or die(mysql_error());
        foreach(mysql_fetch_array($query_checkRef) as $ref_id_user){
            if ($ref_id_user>=1){
                mysql_query("UPDATE HB_users SET balance=balance+".$pdtshow." WHERE nick='".$subid."'");
                mysql_query("UPDATE HB_users SET balance=balance+".$refer_bids." WHERE id='".$ref_id_user."'");
                mysql_close();
				
		$f=fopen("pb_log.txt","a+");
		fputs($f,"Success: ".$subid." earned ".$pdtshow." bids and is referred by user ID: ".$ref_id_user."\n\n");
		fclose($f);
				
                echo "Success: ".$subid." earned ".$pdtshow." bids and is referred by ".$ref_id_user;
                exit;
            }else{
                mysql_query("UPDATE HB_users SET balance=balance+".$pdtshow." WHERE nick='".$subid."'");
                mysql_close();
		$f=fopen("pb_log.txt","a+");
		fputs($f,"Success: ".$subid." earned ".$pdtshow." bids and is referred by nobody"."\n\n");
		fclose($f);
                echo "Success: ".$subid." earned ".$pdtshow." bids and is referred by nobody";
                exit;
            }
        }
    }else{
        

	$f=fopen("pb_log.txt","a+");
        fputs($f,'#The lead was revoked by AdscendMedia. ');
        fclose($f);
        echo '#The lead was revoked by AdscendMedia.';


        exit;
    }
// IP RESTRICTIONS - HOW TO DISABLE IP RESTRICTION
// comment out the next 7 lines for testing with no IP only.
     
// }else{
//   $f=fopen("pb_log.txt","a+");
//   fputs($f,'IP address not from AdscendMedia. To test, remove IP check in adspostback.php for help look for IP RESTRICTIONS');
//   fclose($f);
//   echo 'IP address not from AdscendMedia. To test, remove IP check in adspostback.php for help look for IP RESTRICTIONS';
//   exit;
//}
}else{
  if(($ip == "72.52.162.102") || ($ip == "199.59.164.3") ||($ip == "199.59.164.5")){
    //grab and sanitize gets
    $cid    = $_GET['campid'];
    $name   = $_GET['name'];
    $rate   = $_GET['rate'];//payout - $1 = 5.00 bids - round up
    $subid  = $_GET['sid'];//subid
    $status = $_GET['status'];//1=good,2=bad
    $p_ip   = $_GET['ip'];

    $f=fopen("pb_log.txt","a+");
    fputs($f,"IP check successful\n");
    fclose($f);   
				
    //round calculate ticket amount
    $r = round($rate);
    $final_rate =floor($rate * 5);
    if($final_rate <=0){$final_rate=1;}

    // Number of bids a user gets from their referral
    $refer_bids = 1;

    if($status == "1"){
        $pdtshow = $final_rate;
        //referer check
        $query_checkRef = mysql_query("SELECT referrer from HB_users WHERE nick='".$subid."'") or die(mysql_error());
        foreach(mysql_fetch_array($query_checkRef) as $ref_id_user){
            if ($ref_id_user>=1){
                mysql_query("UPDATE HB_users SET balance=balance+".$pdtshow." WHERE nick='".$subid."'");
                mysql_query("UPDATE HB_users SET balance=balance+".$refer_bids." WHERE id='".$ref_id_user."'");
                mysql_close();
				
		$f=fopen("pb_log.txt","a+");
		fputs($f,"Success: ".$subid." earned ".$pdtshow." bids and is referred by user ID: ".$ref_id_user."\n\n");
		fclose($f);
				
                echo "Success: ".$subid." earned ".$pdtshow." bids\n and is referred by ".$ref_id_user;
                exit;
            }else{
                mysql_query("UPDATE HB_users SET balance=balance+".$pdtshow." WHERE nick='".$subid."'");
                mysql_close();
		$f=fopen("pb_log.txt","a+");
		fputs($f,"Success: ".$subid." earned ".$pdtshow." bids and is referred by nobody"."\n\n");
		fclose($f);
                echo "Success: ".$subid." earned ".$pdtshow." bids and is referred by nobody";
                exit;
            }
        }
    }else{
        

	$f=fopen("pb_log.txt","a+");
        fputs($f,'#The lead was revoked by AdscendMedia. ');
        fclose($f);
        echo '#The lead was revoked by AdscendMedia.';


        exit;
    }
     
 }else{
   $f=fopen("pb_log.txt","a+");
   fputs($f,'IP address not from AdscendMedia. Enable test mode in General Settings if testing.');
   fclose($f);
   echo 'IP address not from AdscendMedia. Enable test mode in General Settings if testing.';
   exit;
}
}


// Do not comment out anything below this
?>