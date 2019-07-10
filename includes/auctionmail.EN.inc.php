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

Dear <#c_name#>,<BR>
<BR>
Your auction has been posted at <#c_sitename#>.<BR>
<BR>
Auction ID: <#a_id#><BR>
Auction type: <#a_type#><BR>
Product: <#a_title#><BR>
Quantity: <#a_qty#><BR>
Description: <#a_description#><BR>
Starting bid: <#a_minbid#><BR>
Reserve price: <#a_resprice#><BR>
Bids increment: <#a_customincrement#><BR><BR>
Auction URL: <a href="<#a_url#>"><#a_url#></a><BR>
Auction ends: <#a_ends#><BR>
<BR>
<#a_altfeedue#><BR>
<BR>
If you have received this message in error, please reply to this email or<BR>
write to <#c_adminemail#>.<BR>
<BR>
Thank you for visiting <#c_sitename#> at <#c_siteurl#>.