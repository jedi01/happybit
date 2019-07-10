#
# --Confirmation e-mail file
# 
# 			This file contains the message your customers
# 			will receive as a confirmation for the posted
#			auction.
#			Lines starting with # will be skipped.
#			Blank lines will be maintained.
#
#			Change the message below as needed using the 
#			following tags to reflect your customer's personal data:
#
#        --------------------------------------------------------
#			TAG SYNTAX				EFFECT
#        --------------------------------------------------------
#
#			<#c_name#>				customer name
#			<#c_nick#>				nick
#			<#c_email#> 			e-mail address
#			<#c_address#> 			street address
#			<#c_city#>   			city
#			<#c_country#> 			country
#			<#c_zip#> 			    zip
#			<#a_title#>				auction title
#			<#a_id#>				auction ID
#			<#a_description#>		description
#			<#a_picturl#>			picture url
#			<#a_minbid#>   			minimum bid
#			<#a_resprice#>			reserve price (if set)
#			<#a_duration#>			duration (in days)
#			<#a_location#>			item location
#			<#a_zip#>				item location zip
#			<#a_shipping#>			shipping terms
#			<#c_type#>   			auction type
#			<#c_qty#>   			auction type
#			<#a_intern#>			international shipping terms
#										. will ship internationally
#										. will NOT ship internationally
#			<#a_payment#>			selected payment methods (one per line)
#			<#a_ends#>				closing date and time
#			<#a_url#>				the URL of the page
#           <#c_sitename#>          site name
#           <#c_siteurl#>           site URL
#           <#c_adminemail#>        site administrator email address
#        --------------------------------------------------------
#
#			USAGE:
#			Insert the above tags in the text of your message			
#			where you want each value to appear.			
#			Modify the message to reflect your needs.
#		
# 
#

Dear <#b_name#>,<br>
<br>
This message is automatically sent to you from <#c_sitename#> to notify you<br>
have been invited by <#c_nick#> to partecipate in the following auction:<br>
<br>
Auction ID: <#a_id#><br>
Auction type: <#a_type#><br>
Product: <#a_title#><br>
Quantity: <#a_qty#><br>
Description: <#a_description#><br>
<br>
Starting bid: <#a_minbid#><br>
Reserve price: <#a_resprice#><br>
Bids increment: <#a_customincrement#><br>
<br>
Auction URL: <#a_url#><br>
<br>
Auction ends: <#a_ends#><br>
<br>
If you have received this message in error, please reply to this email or<br>
write to <#c_adminemail#>.