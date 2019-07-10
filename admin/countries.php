<?

require('../includes/config.inc.php');
include "loggedin.inc.php";



$DBGSTR = "DBGSTR: ". count($delete). "-" .
count($old_countries) . " <br><br>\n";
include "./rebuild_html.php";

/*
* When the submit button is pressed (below on the page) on
* the first call to countires.php it calls countires.php
* again but with a form variable named "act" being sent as true
* (see the submit input in the HTML below).  This causes the execution
* of the below code.
*/
if ($_POST[act] && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF'])) {
  $delete = $_POST['delete'];
  $new_countries = $_POST['new_countries'];
  $old_countries = $_POST['old_countries'];
  /*
  *  For a description of how the arrays (delete[], new_countries[],
  *  old_countries[]) are set up see the body of the HTML below.
  */
  
  // we use a single SQL query to quickly do ALL our deletes
  $sqlstr = "DELETE FROM HB_countries WHERE ";
  /*
  * Delete anything marked for deletion in the delete[]
  * array.
  */
  // if this is the first country being deleted it don't
  // precede it with an " or " in the SQL string
  $first = 1;
  for ($i = 0; $i < count ($delete); $i++) {
    $DBGSTR .= "Deleting[" . $i ."] " . $delete[$i] . "<br>\n";
    if ( ! $first )  {
      $sqlstr .= " or ";
    } else {
      $first = 0;
    }
    $sqlstr .= "country = \"" . $old_countries[$delete[$i]] . "\"";
  }
  $DBGSTR .= $sqlstr;
  
  // If the delete array is > 0 in size
  if ( count($delete) ) {
    $result = mysql_query($sqlstr);
    if ( !$result ) {
      $TPL_info_err = $ERR_001;
    } else {
      $TPL_info_err = "";
    }
  }
  /*
  * Now we update all the countries where old_countries
  * isn't the same as new_countries (saving ourselves a
  * lot of queries.
  */
  for ( $i = 0; $i < count($_POST[old_countries]); $i++) {
    if ( "hey" != "hey")
    $DBGSTR .= "hey != hey";
    if ( $old_countries[$i] != $new_countries[$i]) {
      $sqlstr = "UPDATE HB_countries SET country = \"" .
      $new_countries[$i] . "\" WHERE country = \"" .
      $old_countries[$i] . "\"";
      $DBGSTR .= "<br>" . $sqlstr;
      $result = mysql_query($sqlstr);
    }
  }
  
  /* If a new country was added, insert it into database */
  if ( $new_countries[(count($new_countries) - 1)] ) {
    $sqlstr = "INSERT INTO HB_countries (country) VALUES ('";
    $sqlstr .= $new_countries[(count($new_countries) - 1)] . "');";
    $result = mysql_query($sqlstr);
    if (!$result) {
      $TPL_info_err = $ERR_001;
    }
  }
  rebuild_html_file("countries");
}

include $include_path."countries.inc.php";

?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<SCRIPT Language=javascript>
function selectAll(formObj, isInverse) 
{
   for (var i=0;i < formObj.length;i++) 
   {
      fldObj = formObj.elements[i];
      if (fldObj.type == 'checkbox' && fldObj.name.substring(0,6)=='delete')
      { 
         if(isInverse)
            fldObj.checked = (fldObj.checked) ? false : true;
         else fldObj.checked = true; 
       }
   }
}
</SCRIPT>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? print $TPL_info_err . ""?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td width="30"><img src="images/i_set.gif" width="21" height="19"></td>
          <td class=white><?=$MSG_25_0007?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_083?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle"><TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
        <TR>
          <TD><CENTER>
              <BR>
            </CENTER>
            <FORM NAME=conf action="<?=basename($_SERVER['PHP_SELF'])?>" METHOD=POST>
              <TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#546f95" ALIGN="CENTER">
                <TR>
                  <TD ALIGN=CENTER class=title><? print $MSG_083; ?></TD>
                </TR>
                <TR>
                  <TD><TABLE WIDTH=100% CELLPADDING=2 BGCOLOR="#FFFFFF">
                      <TR>
                        <TD WIDTH=50></TD>
                        <TD><p>
                            <? 
                            print $MSG_094;
                            if($$ERR) {
                            	print "<FONT COLOR=red><BR><BR>".$$ERR;
                            } else {
                            	if($$MSG) {
                            		print "<FONT COLOR=red><BR><BR>".$$MSG;
                            	} else {
                            		print "<BR><BR>";
                            	}
                            }
							?>
                            </p>
                          <p><img src="../images/nodelete.gif" width="20" height="21"> 
                            <?=$MGS_2__0030?>
                             </p></TD>
                      </TR>
                      <TR>
                        <TD WIDTH=50></TD>
                        <TD BGCOLOR="#EEEEEE"><B> <? print $MSG_087; ?> </B> </TD>
                        <TD BGCOLOR="#EEEEEE" align=center><B> <? print $MSG_088; ?> </B> </TD>
                      </TR>
                      <?
                      
                      $i = 1;
                      while ($i < count($countries)) {
                      	$j = $i - 1;
                      	
                      	#// Check if this country has been selected for an auction or
                      	#// if some user has registered selecting it
                      	#// If one of the above conditions is true the country cannot be deleted
                      	$USEDINAUCTIONS = mysql_num_rows(mysql_query("SELECT id FROM HB_auctions WHERE location=\"".$countries[$i]."\""));
                      	$USEDINUSERS = mysql_num_rows(mysql_query("SELECT id FROM HB_users WHERE country=\"".$countries[$i]."\""));
                      	
                      	print "
                      <TR>
						 <TD WIDTH=50></TD>
						 <TD>
						 <INPUT TYPE=hidden NAME=old_countries[] VALUE=\"".$countries[$i]."\" SIZE=25>
						 <INPUT TYPE=text NAME=new_countries[] VALUE=\"".$countries[$i]."\" SIZE=45>
						 </TD>
						 <TD align=center>";
                      	if($USEDINAUCTIONS == 0 && $USEDINUSERS == 0) {
                      		print "<INPUT TYPE=checkbox NAME=delete[] VALUE=\"$j\">";
                      	} else {
                      		print "<IMG SRC=\"../images/nodelete.gif\" ALT=\"You cannot delete this category\">";
                      	}
                      	print "
                      	</TD>
					</TR>";
                      	$i++;
                      }
                      ?>
                    <TR>
						<TD WIDTH=50> Add</TD>
						<TD>
						<INPUT TYPE=text NAME=new_countries[] SIZE=25>
						</TD>
						 <TD align=center>
						 <a href="javascript: void(0)" onclick="selectAll(document.forms[0],1)"><?=$MSG_30_0102?></A>
						 </TD>
					</TR>                  
                      <TR>
                        <TD WIDTH=50></TD>
                        <TD><INPUT TYPE="submit" NAME="act" VALUE="<? print $MSG_089; ?>">
                        </TD>
                      </TR>
                      <TR>
                        <TD WIDTH=50></TD>
                        <TD></TD>
                      </TR>
                    </TABLE></TD>
                </TR>
              </TABLE>
            </FORM></TD>
        </TR>
      </TABLE></TD>
  </TR>
</TABLE>
</BODY>
</HTML>