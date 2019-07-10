<?
if(!defined('INCLUDED')) exit("Access denied");


	$to 		= $EMAIL;
	$from 	= "From: $SETTINGS[sitename] <$SETTINGS[adminmail]>\n";
	$subject	= "Your new password";
	$message = "Hi $TPL_username,
As you requested, we have created a new password for your account.
It is: $NEWPASSWD
Use it to login to $SITE_NAME and remember to change it to the one you prefer.
";
?>