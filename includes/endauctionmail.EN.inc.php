<?
if(!defined('INCLUDED')) exit("Access denied");


$END_AUCTION_NO_WINNER = "Dear $name,<br>
The auction you created has ended.<br>
<br>
Auction data<br>
------------------------------------<br>
Product: $title <br>
Auction ID: $id <br>
Auction started: $starting_date <br>
Auction ended: $ending_date <br>
Auction URL: $auction_url <br>
<br>
We inform you that there's not a winner for this auction.";

$END_AUCTION_WINNER = "Dear $name,<br>
The auction you created has ended.<br>
<br>
Auction data<br>
------------------------------------<br>
Product: $title <br>
Auction ID: $id <br>
Auction started: $starting_date <br>
Auction ended: $ending_date <br>
Auction URL: $auction_url <br>
<br>
The winner of the auction is: $bidder_name.<br>
Contact the winner at this e-mail address: $bidder_email";


$END_AUCTION_WINNER_CONFIRMATION = "Dear $bidder_name,<br>
Congratulations!!<br>
<br>
You are the winner of this auction <br>
<br>
Auction data<br>
------------------------------------<br>
Product: $title <br>
Auction ID: $id <br>
Auction started: $starting_date <br>
Auction ended: $ending_date <br>
Auction URL: $auction_url <br>
<br>
The seller will contact you.<br>
Anyway this is his/her e-mail address :$email.<br>
<br>
Thanks";

?>