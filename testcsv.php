<?php

$amounts1=array("50"=>"£9.99","100"=>"£19.99","200"=>"£39.99","500"=>"£99.99");


$defaultlist = array (
    array('Date', 'Time', 'User ID', 'Coins Purchased','Paid','Paypal Email')
);


$date=date('d-m-y');
$time=date('h:i', time());
$userid="sdf";
$coinsPurchased="sdf";
$paid="sdf";
$paypalEmaild="sdf";

$newlist=array (array ($date,$time,$userid,$coinsPurchased,$paid,$paypalEmaild));


if(file_exists ('../private/file.csv' )) {
$fp = fopen('../private/log_file.csv', 'a');
foreach ($newlist as $fields) {
    fputcsv($fp, $fields);
}
fclose($fp);
}
else {
$fp = fopen('../private/log_file.csv', 'w');
foreach ($defaultlist as $fields) {
    fputcsv($fp, $fields);
}
fclose($fp);
}
?>