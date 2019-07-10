<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/tr/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"
 dir=ltr><head>
<title>HAPPYBID </title>
<style type="text/css">
<!--
.errfont {font-family:Verdana, Arial, Helvetica;font-size:small;color:#FF9900;font-weight: bold;}
.smlfont {font-family:Verdana, Arial, Helvetica;font-size:xx-small;color:#000000;}
.stdfont {font-family:Verdana, Arial, Helvetica;font-size:x-small;color:#000000}
body { background:url(themes/default/back3.jpg);background-repeat:;font-family:Verdana, Arial, Helvetica;font-size:x-small;color:#000000}
#container{ width:99%;background-color:#ffffff}
.tltfont {font-family:Tahoma, Verdana, Arial;font-size:medium;color:#3300CC;font-weight: bold;}
.titTable2 {font-family:Tahoma, Verdana, Arial;font-size:medium;color:#3300CC;font-weight: bold;;border-color:#3300CC }
.navfont {font-family:Verdana, Arial, Helvetica;font-size:small;color:#3366CC;font-weight: bold;}
th {background-color : #6666FF;}
#barSec {background-color : #6666FF;}
.titTable1 {background-color : #6666FF;}
a:link,a:visited {
	color : #3399CC;
}
-->
</style><link rel='stylesheet' type='text/css' href='themes/default/style.css' /><script type="text/javascript" language="Javascript">

function window_open(pagina,titulo,ancho,largo,x,y){
  var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
  open(pagina,titulo,Ventana);
}
</script>






<style>
#topNavTable td{
    text-align:center;
    height:27px; width: 100px;
    background-repeat:no-repeat;    
}

#topNavTable td a{
  font-family: arial; font-size: 11px; font-weight: bold; color:#1f1f1f;
}

#topNavTable td.active a{
  font-family: arial; font-size: 11px; font-weight: bold; color:#1f1f1f;
}

#topNavTable td.active{
    text-align:center;
    height:27px; width: 100px;
    
    background-repeat:no-repeat;    
}
</style>



<script>
function checkSubmition(){
    
    if(!document.getElementById("accept_conditions").checked){
        alert("Please check the terms of service box to procced!");
        return false;        
    }
    return true;
}
</script>
<style type="text/css">
<!--
.Stile2 {color: #000000}
.Stile4 {font-weight: bold}
.bordo {
	font-family: Arial, Helvetica, sans-serif;
	border: 1px solid #000000;
	font-size: 12px;
	margin: 3px;
	padding: 3px;
	font-weight: bold;
	color: #000000;
	background-color: #C2D7EB;
}
-->
</style>




</head>
<body>


<div class="content">
    <div class="tableContent2">
        <div class="titTable2">
            User registration
        </div>
        <?
        if(!empty($TPL_errmsg)) {
        ?>
        
        <? if($TPL_errmsg != "")  echo "<p><div class=errfont>".$TPL_errmsg."</div></p>"; ?>
        
        <?
        }
		?>
        <div class="table2">
            <form name=registration action="register.php" method="POST" >

                <table width="100%" border="0" cellpadding="4" cellspacing=0>
                    <?
                    if($SETTINGS['accounttype'] == 'sellerbuyer') {
					?>
                    <tr>
                        <td width="40%" valign="top" align="right"><b><? print $MSG_25_0133; ?></b></td>
                        <td valign="top">
                            <!--<input type=radio name=accounttype value='seller' <?if($_POST['accounttype'] == 'seller') print " checked=true";?> />-->
                            <?//=$MSG_25_0134?>
                            <?
                            //if($SETTINGS['sbsignupconfirmation'] == 's' || $SETTINGS['sbsignupconfirmation'] == 'sb') {
                            //	print "<P class=errfont>$MSG_25_0136</p>";
                            //}
							?>
                            <!--<input type=radio name=accounttype value='buyer' <?if($_POST['accounttype'] == 'buyer') print " checked=true";?> />-->
                            <input type=hidden name=accounttype value='buyer' />
                            	Register as a user of the site and starts to play!
                            <?
                            if($SETTINGS['sbsignupconfirmation'] == 'b' || $SETTINGS['sbsignupconfirmation'] == 'sb') {
                            	print "<P class=errfont>$MSG_25_0136</p>";
                            }
							?>
                        </td>
                        <td rowspan="16">
                            
                                <p align="center"><span class="Stile6"> <br>
                                    </span><span class="Stile7"><img src="<?=$SETTINGS['siteurl']?>themes/default/img/r.gif" height="94" width="126"><br>
                                    <br>
                                    <span class="Stile21 Stile2"><strong>Welcome </strong></span><span class="Stile2"><strong>in the registration page to HAPPYBID<br>
                                    	
										From this page you can register to the site to participate in auctions to the bottom!      </strong></span></span></p>
                            
                                  <p align="center"><span class="Stile7 Stile2"><strong class="Stile4" align="center">	
											FOR THE FIRST 100 MEMBERS WHO MAKE A MAJOR RECHARGE OF 20 EURO IN THE EXCLUSIVE TRIBUTE <br> 
                                    </strong></span></p>
<p align="center"><br>  
                                  <img src="<?=$SETTINGS['siteurl']?>themes/default/img/omaggio.gif" height="224" width="224"></p>
                                  <div align="center" class="bordo">
                                    <div align="center"><span class="Stile2">Recharges from <strong>2 to 20 Euro</strong><br />
                                          <strong>1 Offer value <br />
                                             2 euro free </strong> </span> </div>
                                  </div>
                          <br>
                            
                                  <table align="center" border="0" cellpadding="0" cellspacing="0" width="86%">
                                    <tbody><tr>
                                      <td bgcolor="#c2d7eb"><div align="center" class="bordo">
                                        <div align="center"><span class="Stile7 Stile2"><strong>Charges from 21 to 50 Euro <br>
                                          Keychain + 5 bids worth 2 euro</strong></span></div>
                                      </div></td>
                                    </tr>
                                  </tbody></table>
                                  <br>
                            
                                  <table width="87%" border="0" align="center" cellpadding="0" cellspacing="0" class="bordo">
                                    <tbody><tr>
                                      <td bgcolor="#c2d7eb"><div align="center"><span class="Stile7">Recharges from <strong>51 Euro e oltre</strong><br>
                                          <span class="Stile22"><strong>Keychain 10 + deals worth 2 euro</strong></span></span></div></td>
                                    </tr>
                                  </tbody></table>
                                  <p align="center"><br>
                                  </p>
                  <!--
                                  <p class="Stile7">Inserisci  correttamente tutti i tuoi dati, clicca sul pulsante registra e  rispondi all'email di conferma registrazione per attivare il tuo  account. </p>
                                  <p class="Stile7">Ricorda di inserire i dati correttamente altrimenti avrai problemi nel ricevere gli oggetti che vincerai. </p>
                                    -->
                                  
                            
                        </td>
                    </tr>
                    <?
                    }
					?>
                    <tr>
                        <td width="40%" valign="top" align="right"><b> Your name  </b> </td>
                        <td width="60%">
                            <input type=text name=TPL_name size=40 maxlength=255 value="<?=$_POST[TPL_name]?>" />
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" valign="top" align="right"><b> Username  </b> </td>
                        <td width="60%">
                            <input type=text name=TPL_nick size=20 maxlength=20  value="<?=$_POST[TPL_nick]?>" />
                            <? print $MSG_050; ?> </td>
                    </tr>
                    <tr>
                        <td width="40%" valign="top" align="right"><b> Password  </b> </td>
                        <td width="60%">
                            <input type=password name=TPL_password size=20 maxlength=20 value="" />
                            <? print $MSG_050; ?> </td>
                    </tr>
                    <tr>
                        <td width="40%" valign="top" align="right"><b>Retype password  </b> </td>
                        <td width="60%">
                            <input type=password name=TPL_repeat_password size=20 maxlength=20 value="" />
                        </td>
                    </tr>
                    <tr>
                        <td width="40%"  valign="top" align="right"><b>E-mail </b> </td>
                        <td width="60%">
                            <input type=text name=TPL_email size=50 maxlength=50 value="<?=$_POST[TPL_email]?>" />
					<?
						if(!empty($TPL_domains_alert)){
							print "<BR />".$TPL_domains_alert;
						}
					?>
                        </td>
                    </tr>
					
                    <tr>
                        <td width="40%" valign="top" align="right"><b>Date of Birth </b> </td>
                        <td width="60%">
                            <input type=text name=TPL_birthdate size=10 maxlength=10 value="<?=$_POST[TPL_birthdate]?>" />
                            <?
                            if($SETTINGS[datesformat] == "USA") {
                            	print $MSG_382;
                            } else {
                            	print $MSG_383;
                            }
  							?>
                        </td>
                    </tr>
					
                    <tr>
                        <td width="40%" valign="top" align="right"><b>Address</b></td>
                        <td width="60%">
                            <input type=text name=TPL_address size=40 maxlength=255 value="<?=$_POST[TPL_address]?>" />
                        </td>
                    </tr>
					
                    <tr>
                        <td width="40%" valign="top" align="right"><b> City </b> </td>
                        <td width="60%">
                            <input type=text name=TPL_city size=25 maxlength=25 value="<?=$_POST[TPL_city]?>" />
                        </td>
                    </tr>
					
                    <tr>
                        <td width="40%" valign="top" align="right"><b> State / Province </b> </td>
                        <td width="60%">
                            <input type=text name=TPL_prov size=10 maxlength=10 value="<?=$_POST[TPL_prov]?>" />
                        </td>
                    </tr>
					
                    <tr>
                        <td width="40%" valign="top" align="right"><b> Country  </b> </td>
                        <td width="60%">
                            <select name=TPL_country>
                                <option value=""> <? print $MSG_251; ?> </option>
                                <?=$country?>
                            </select>
                        </td>
                    </tr>
					
                    <tr>
                        <td width="40%" valign="top" align="right"><b> ZIP  </b> </td>
                        <td width="60%">
                            <input type=text name=TPL_zip size=8 value="<?=$_POST[TPL_zip]?>" />
                        </td>
                    </tr>
					
                    <tr>
                        <td width="40%" valign="top" align="right"><b>
                            Telephone 
                            </b> </td>
                        <td width="60%">
                            <input type=text name=TPL_phone size=40 maxlength=40 value="<?=$_POST[TPL_phone]?>" />
                        </td>
                    </tr>
					<?
                    if($SETTINGS[userscreditcard] == 'y' && $HTTPS == 'on') {
					?>
                    <tr bgcolor="<?=$SETTINGS[headercolor]?>">
                        <td width="40%" valign="top" align="left"><b>
                            
                            </b> </td>
                        <td width="60%">
                            <?=$MSG_5273?>
                            <br />
                            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                <tr>
                                    <td width="25%"><b>
                                        <?=$MSG_5285?>
                                        </b></td>
                                    <td width="75%">
                                        <input type=text name=TPL_cc size=16 maxlength=16 value="<?=$_POST[TPL_cc]?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="25%"><b>
                                        <?=$MSG_5286?>
                                        </b></td>
                                    <td width="75%">
                                        <input type="text" name="TPL_exp_month" size="2" value="<?=$_POST[TPL_exp_month]?>" />
                                        /
                                        <input type="text" name="TPL_exp_year" size="2" value="<?=$_POST[TPL_exp_year]?>" />
                                        <?=$MSG_5288?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="25%"><b>
                                        <?=$MSG_5287?>
                                        </b></td>
                                    <td width="75%">
                                        <input type="text" name="TPL_card_owner" value="<?=$_POST[TPL_card_owner]?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="25%"><b>
                                        <?=$MSG_5301?>
                                        </b></td>
                                    <td width="75%">
                                        <input type="text" size=10 name="TPL_card_zip" value="<?=$_POST[TPL_card_zip]?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?
                    }
					?>

                    <?
                    //if($SETTINGS[newsletter] == 1) {
                    if("1"=="1"){
					?>
                    <tr>
                        <td width="40%" align=right><b>I want to receive your newsletter</b></td>
                        <td width="60%">
                            <input type="radio" name="TPL_nletter" value="1"<? if($_POST[TPL_nletter] == 1 || empty($_POST[TPL_nletter])) print " checked=true";?> />
                            Yes
                            <input type="radio" name="TPL_nletter" value="2"<? if($_POST[TPL_nletter] == 2) print " checked=true";?> />
                            No
                        </td>
                    </tr>
                    
                    <?
                    }
					?>
                    
                    <!--
                    CONDITION & TERMS
                    -->
                    <tr>                        
                        <td colspan="2" valign="top" align="right" style="padding:45px;">
                            <p>Terms and conditions to access the service *:</p>
                            <p>
                            <label>
                            <textarea name="condizioni" id="condizioni" cols="55" rows="7">	TERMS OF USE
                                These General Conditions define the conditions, requirements and limits for the registration and use of services offered by Revolution Team srl with registered office at 07100 Sassari (SS), the Way, through the website HAPPYBID
                                
                                1) TERMS and DEFINITIONS:
                                 - Team srl revolution: a company that operates the site  and providing the services offered
                                 - Site: content under the domain name 
                                 - Auction downward system of sale of goods through offers, and culminating in the award of a good man who has made over the period of the auction, the lowest unique bid
                                 - Lot: movable, mobile recorded sold by auction to the bottom
                                 - Participant: natural or legal person, registered on the site that offers formula
                                 - Period Auctions: temporal space within which participants can take part in the auction for the award of a particular product and which is indicated by a countdown timer expressed in "days - hours - minutes - seconds"
                                 - Offer unique price offered by one participant to take part in the award of a particular
                                 - Offer unique lowest: lowest price offered by one participant at the end of the period of tender, all the bids received
                                 - Offer multiple type of offer that allows the participant to submit more bids in an auction by specifying a range of prices
                                 - Information: Information provided to each participant upon his tender and at each bid by other participants about its potential for the award of the lot
                                 - Contractor provisional: participant in the auction that auction has made the lowest unique bid, or, if no offer single participant who has made the first offer made by the lower number of participants and to the nearest lowest
                                 - Contractor Final participant declared the winner in advance, which then paid the price in time and manner established
                                 - Prepaid Accounts: deposit of money the participant made in the registration at the site. The opening of the account and any subsequent payment may be made by credit card through PayPal certified. Both the first filing as the subsequent payments must have a cut of at least EUR 5.00
                                 - Credit: the amount withdrawn from the eJabe account prepaid participant at each offer and to receive information regarding the progress of their bids until the end of an adopted. In case of insufficiency of funds offering, even the lowest one, will not be taken into account.
		
                            </textarea>
                            </label>
                            <br>
                            </p>
                          
                            <p>
                              	
											I accept terms and conditions
                              <input name="accept_conditions" type="checkbox" value="accept" id="accept_conditions" />
                              <br>
                            </p>

                            <p><br></p>
                            <p>
                              <textarea name="privacy" id="privacy" cols="55" rows="7">
The data will be processed in paper form, information technology and telematics to allow the registration and subsequent access to the services offered as well as for the proper performance of administrative and fiscal obligations required by law, for the duration of the contractual relationship and, subsequently, in accordance with the legal obligations.
                               Therefore, the provision of such data and mandatory and essential in order to carry the relationship so that their failure to grant it makes impossible to provide the writing services.
                               Personal data will be used also for sending commercial or advertising material in the context of ongoing relationships.
                               In the case of consent to such use, remember that at any moment and free to object to processing by sending an e-mail to:                              </textarea>
                            </p>
                            <p>Accetto termini e condizioni <br>
                              art. 13 del D.Lgs. 196/2003 sulla privacy
                              <input name="accettoprivacy" type="checkbox" value="accept" id="accettoprivacy" />
                            </p>

                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" nowrap height="5px">&nbsp;</td>
                        <td></td>
                    <tr>
                    
                </table>
                <div style="text-align:center">
                    <?
                    //if($SETTINGS[showacceptancetext] == 1) {
					?>
                    <p>
                        <?//=nl2br(stripslashes($SETTINGS[acceptancetext]))?>
                    </p>
                    <?
                    //}
					?>
                    <input type=hidden name="action" value="first" />
                    <input type=hidden name="pre_registration" value="1" />
                    <input type="hidden" name="TPL_id_hidden" value="<?=$_POST[TPL_id_hidden]?>" />
                    <input type="hidden" name="TPL_nick_hidden" value="<?=$_POST[TPL_nick_hidden]?>" />
                    <input type="hidden" name="TPL_password_hidden" value="<?=$_POST[TPL_password_hidden]?>" />
                    <input type="hidden" name="TPL_name_hidden" value="<?=$_POST[TPL_name_hidden]?>" />
                    <input type="hidden" name="TPL_email_hidden" value="<?=$_POST[TPL_email_hidden]?>" />
                    <input type=submit name="" value="Registrati" class=button onclick="return checkSubmition();" />
                    <input type=reset name="" value="Annulla" class=button />
                              
                </div>
            </form>
        </div>
    </div>
</div>


</body>

</html>
