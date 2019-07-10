<?php
include "./includes/config.inc.php";

$YOURWIDGETPASSWORD = $SETTINGS['cpalead_pwd'];  

$f=fopen("pb_log.txt","a+");
fputs($f,"\nCPAlead postback called successfully\n");
fclose($f);

$mysql_where = $DbHost;
$mysql_username = $DbUser;
$mysql_password = $DbPassword;
$mysql_database = $DbDatabase;

$password = $_REQUEST['password'];
if ($password != $YOURWIDGETPASSWORD) {
    echo "Access Denied";
    exit;
}

mysql_connect($mysql_where, $mysql_username, $mysql_password);
mysql_select_db($mysql_database);

$subid = $_REQUEST['subid'];
$survey = $_REQUEST['survey'];
$earn = $_REQUEST['earn'];
$pdtshow = $_REQUEST['pdtshow'];
$refer_bids = 0; //number of bids a referred user get for each bid earned by a friend

$query_checkRef = mysql_query("SELECT referrer from HB_users WHERE nick='".$subid."'") or die(mysql_error());
foreach(mysql_fetch_array($query_checkRef) as $ref_id_user);
if ($ref_id_user>=1)
{
mysql_query("UPDATE HB_users SET balance=balance+".$pdtshow." WHERE nick='".$subid."'");
mysql_query("UPDATE HB_users SET balance=balance+".$refer_bids." WHERE id='".$ref_id_user."'");
mysql_close();
$f=fopen("pb_log.txt","a+");
		fputs($f,"Success: ".$subid." earned ".$pdtshow." bids and is referred by user ID: ".$ref_id_user."\n\n");
		fclose($f);

echo "Success: ".$subid." earned ".$pdtshow." bids\n and is referred by user: ".$ref_id_user;
} 

else {
mysql_query("UPDATE HB_users SET balance=balance+".$pdtshow." WHERE nick='".$subid."'");
mysql_close();
$f=fopen("pb_log.txt","a+");
		fputs($f,"Success: ".$subid." earned ".$pdtshow." bids and is referred by nobody"."\n\n");
		fclose($f);

echo "Success: ".$subid." earned ".$pdtshow." bids\n and is referred by nobody";
}
?>