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
The auction "<#i_title#>" you created at <a href="<#c_sitename#>"><#c_sitename#></a> has closed.<br>
To get the winner(s) information you have to pay the Final Value Fee.<br>
Please login at <a href="<#c_siteurl#>"><#c_siteurl#></a> and access the "Winners contact info" section in your<br>
Control Panel to proceed to the payment.<br>
<br>
If you have received this message in error, please reply to this email,<br>
write to <a href="mailto:<#c_adminemail#>"><#c_adminemail#></a>, or visit <a href="<#c_sitename#>"><#c_sitename#></a> at <a href="<#c_siteurl#>"><#c_siteurl#></a>.<br>
