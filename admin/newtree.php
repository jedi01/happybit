<?
require('../includes/config.inc.php');
include "loggedin.inc.php";



if($_POST['action'] == "start" && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF'])) {
	if(!file_exists("categories.txt")) {
		$ERR = $ERR_118;
	} else {
		Header("Location: populate_categories.php");
	}
}

#// Check if there are existing auctions
$AUCTIONS = mysql_num_rows(@mysql_query("SELECT id FROM HB_auctions"));


?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<SCRIPT Language=Javascript>
function window_open(pagina,titulo,ancho,largo,x,y){
	var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
	open(pagina,titulo,Ventana);
	
}
</SCRIPT>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td width="30"><img src="images/i_set.gif" width="21" height="19"></td>
          <td class=white><?=$MSG_25_0007?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_369?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle"><TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
        <TR>
          <TD ALIGN=CENTER><BR>
            <FORM NAME=conf ACTION=<?=basename($_SERVER['PHP_SELF'])?> METHOD=POST>
              <TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#546f95">
                <TR>
                  <TD ALIGN=CENTER class=title><? print $MSG_369; ?></TD>
                </TR>
                <TR>
                  <TD><TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
                      <TR>
                        <TD WIDTH=50 HEIGHT="21"></TD>
                        <TD COLSPAN=4 HEIGHT="21"> <FONT COLOR=red>
                          <?=$ERR?>
                           <BR>
                          <BR>
                          <?=$MSG_644; ?>
                          </TD>
                      </TR>
                      <TR>
                        <TD WIDTH=50></TD>
                        <TD WIDTH="302">
                          <? 
                          if($AUCTIONS == 0) {
                          	print $MSG_405;
                          	if($$ERR) {
                          		print "<FONT COLOR=red><BR><BR>".$$ERR;
                          	} else {
                          		if($$MSG) {
                          			print "<FONT COLOR=red><BR><BR>".$$MSG;
                          		} else {
                          			print "<BR><BR>";
                          		}
                          	}
                          } else {
                          	print $MGS_2__0011;
                          }
						  ?>
                          </TD>
                      </TR>
                      <TR>
                        <TD COLSPAN="2" HEIGHT="22" ALIGN=CENTER>
                        <?
                        if($AUCTIONS == 0) {
						?>
                          <CENTER>
                            <INPUT TYPE=hidden NAME=action VALUE=start>
                            <INPUT TYPE="submit" NAME="Submit" VALUE="<?=$MSG_406?>">
                          </CENTER>
                          <?
                        } else {
                        	print "<BR><BR>".$MGS_2__0071;
                        }
						?>
                        </TD>
                      </TR>
                      <TR>
                        <TD WIDTH=50></TD>
                        <TD WIDTH="302"></TD>
                      </TR>
                    </TABLE></TD>
                </TR>
              </TABLE>
            </FORM><br></TD>
        </TR>
      </TABLE></TD>
  </TR>
</TABLE>
</BODY>
</HTML>
