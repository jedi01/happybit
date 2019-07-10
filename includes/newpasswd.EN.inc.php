<?
if(!defined('INCLUDED')) exit("Access denied");

$to 		= $EMAIL;
$from 	= "From: $SETTINGS[sitename] <$SETTINGS[adminmail]>\n"."Content-Type: text/html; charset=$CHARSET";
$subject	= "Your new password";
$message = "Hi
<br><br>
As per your request, we've created a new password for your account.
<br>
<br>
Password: $NEWPASSWD<br>
<br>
Use this new password to log in to $SETTINGS[sitename].<br><br>
Happy bidding!"
?>