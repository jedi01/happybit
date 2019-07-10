<?php
session_start();
if(isset($_REQUEST['idpay_ten'])) {
$_SESSION['PIZ']="10";
}

if(isset($_REQUEST['idpay_twentyfive'])) {
$_SESSION['PIZ']="25";
}

if(isset($_REQUEST['idpay_fifty'])) {
$_SESSION['PIZ']="50";
}

if(isset($_REQUEST['idpay_hundred'])) {
$_SESSION['PIZ']="110";
}


if(isset($_REQUEST['idpay_twohundred'])) {
$_SESSION['PIZ']="230";
}

if(isset($_REQUEST['idpay_fivehundred'])) {
$_SESSION['PIZ']="600";
}
?>