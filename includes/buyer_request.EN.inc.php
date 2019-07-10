<?
if(!defined("INCLUDED")) exit("Access denied");

$MSG = "User ".$_SESSION["HAPPYBID_LOGGED_IN_USERNAME"]." (".$_SESSION["HAPPYBID_LOGGED_NAME"]."),
owner of a buyer account asked to switch to a seller account.

User's details:
---------------
User ID: ".$_SESSION["HAPPYBID_LOGGED_IN"]."
User Name: ".$_SESSION["HAPPYBID_LOGGED_NAME"]."
User Nick: ".$_SESSION["HAPPYBID_LOGGED_IN_USERNAME"]."
User E-mail: ".$_SESSION["HAPPYBID_LOGGED_EMAIL"];

mail($SETTINGS['adminmail'],"Account change request",$MSG,"From: ".$_SESSION["HAPPYBID_LOGGED_NAME"]." <".$_SESSION["HAPPYBID_LOGGED_EMAIL"].">\n");
?>
