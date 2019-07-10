<?
if(!defined('INCLUDED')) exit("Access denied");
$SUBJECT_TO_SELLER = "You received a private message at $HTTP_SESSION_VARS[CURRENTAUCTIONTITLE]";
$SUBJECT_TO_POSTER = "Your question was responded at the auction $HTTP_SESSION_VARS[CURRENTAUCTIONTITLE]";
$FROM = "From: ".$SETTINGS[sitename]." < ".$SETTINGS[adminmail]." >\n"."Content-Type: text/html; charset=$CHARSET";
$POSTER_MSG = "Dear $POSTERNICK,<br>
<br>
Your question has been replied of your the your auction:<br>
$HTTP_SESSION_VARS[CURRENTAUCTIONTITLE]<br>
<br>
The message it is:<br>
<br>
$MSG_ <br>
<br>
Remember that you can ask a question at:<br>
".$SETTINGS[siteurl]."item.php?id=".$_SESSION["CURRENT_ITEM"]; 

$USER_MSG = "Dear $USERNICK,<br>
<br>
$POSTERNICK, has posted a question in your following auction at:<br>
$HTTP_SESSION_VARS[CURRENTAUCTIONTITLE]<br>
<br>
The message is reported below:<br>
<br>
$MSG_ <br>
<br>
Remember you can answer the message from the message board at:<br>
".$SETTINGS[siteurl]."item.php?id=".$_SESSION['CURRENT_ITEM']; 

$USER_PUBLIC_MSG = "Dear $USERNICK,<br>
<br>
$POSTERNICK, has posted a question in your following auction at:<br>
$HTTP_SESSION_VARS[CURRENTAUCTIONTITLE]<br>
<br>
The message it is:<br>
<br>
$MSG_ <br>
<br>
Remember that you can answer this request at:<br>
".$SETTINGS[siteurl]."item.php?id=".$_SESSION['CURRENT_ITEM']; 

?>