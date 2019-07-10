#
# --Send winner email address to seller
# 
# 			This file contains the message your customers
# 			will receive when someone sends them an auction.
#			Lines starting with # will be skipped.
#			Blank lines will be maintained.
#
#			Change the message below as needed considering the 
#			following tags to reflect your customer's personal data:
#
#        --------------------------------------------------------
#			TAG SYNTAX				EFFECT
#        --------------------------------------------------------
#
#			<#s_name#>              Seller Name
#			<#s_nick#>              Seller Nickname
#			<#s_email#>             Seller email
#			<#s_address#>           Seller Address
#			<#s_city#>              Seller City
#			<#s_prov#>              Seller State/Province
#			<#s_country#>           Seller Country
#			<#s_zip#>               Seller Zip Code
#			<#s_phone#>             Seller Phone
#			<#i_title#>             auction item title 
#			<#i_description#>       auction item description 
#			<#i_url#>               URL to view auction 
#			<#i_ends#>              Auction End date/time
#			<#i_qty#>              Auction End date/time
#           <#w_report#>            Winner report/list
#           <#c_sitename#>          Auction Site Name
#           <#c_siteurl#>           main URL of auction site
#           <#c_adminemail#>        email address of Auction site webmaster
#        --------------------------------------------------------
#
#			USAGE:
#			Insert the above tags in the text of your message			
#			where you want each value to appear.			
#			Modify the message to reflect your needs.
#			Change [...] with to your correct data.
#
# 
#

Dear <#s_name#>,<br>
<br>
The auction you created at <a href="<#c_sitename#>"><#c_sitename#></a> has closed.<br>
Unfortunately, your account does not have enough credits to pay the Final Value<br>
Fee that is charged for all auctions closing with winner(s).<br>
<br>
The auction's information is below:<br>
<br>
Title: <#i_title#><br>
Item: <#i_description#> <br>
Quantity: <#i_qty#><br>
End Date: <#i_ends#><br>
Winning Bid: <#i_currentbid#><br>
<br>
Please access <a href="<#c_siteurl#>"><#c_siteurl#></a> and login to add credits to your<br>
account to receive the winner's contact information.<br>
<br>
If you have received this message in error, please reply to this email,<br>
write to <a href="mailto:<#c_adminemail#>"><#c_adminemail#></a>, or visit <#c_sitename#> at <a href="<#c_siteurl#>"><#c_siteurl#></a>.
