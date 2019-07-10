<?

require('../includes/config.inc.php');
include "loggedin.inc.php";

#// Return if empty search
if($_POST['keyword'] == "") {
    Header("Location: listusers.php");
    exit;
}
?>
<link rel='stylesheet' type='text/css' href='style.css' />
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066">
		<div class=admintitle>User Management</div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px">
    <tr> 
    <td align="center" valign="middle">

<table width="95%" border="4" cellspacing="0" cellpadding="2" BGCOLOR="#FFFFFF" align="center" bordercolor="#3399CC">
            <TR>
            <TD>
                <TABLE WIDTH=100% CELPADDING=4 CELLSPACING=0 BORDER=0 ALIGN="CENTER" CELLPADDING="3" BGCOLOR="#ffffff">
    <FORM NAME=search ACTION=userssearch.php METHOD=POST>
    <tr>
      <td bgcolor="#eeeeee"> 
        <BR>
        <?=$MSG_5022?> <INPUT TYPE=text NAME=keyword SIZE=25>
        <input type=SUBMIT name=SUBMIT value="<?=$MSG_5023?>">
        <?=$MSG_5024?>
        <BR><BR>
      </td>
    </tr>
    </FORM>
  </table>
  </TD>
</TR>
<TR>
  <TD><TABLE WIDTH=100% CELPADDING=4 CELLSPACING=1 BORDER=0 ALIGN="CENTER">
      <?
        $query = "select count(id) as users from HB_users
                        WHERE name like '%$_POST[keyword]%' OR nick like '%$_POST[keyword]%' OR email like '%$_POST[keyword]%'";
        $result = mysql_query($query);
        if(!$result) {
            print "$ERR_001<BR>$query<BR>".mysql_error();
            exit;
        }
        $num_usrs = mysql_result($result,0,"users");
        print "<TR BGCOLOR=#FFFFFF cellspacing=0 cellpadding=0 border=0><TD COLSPAN=9><B>
                $num_usrs $MSG_301</B></TD></TR>";
        ?>
      <TR BGCOLOR="#FFCC00">
        <TD ALIGN=LEFT width=\"10%\"> <B> Username </B>  </TD>
                    <TD ALIGN=LEFT width=\"18%\"> <B> Real Name </B>  </TD>
                    <TD ALIGN=LEFT width=\"8%\"> <B> Balance </B>  </TD>
                    <TD ALIGN=LEFT width=\"10%\"> <B> Email </B>  </TD>
                    <TD ALIGN=LEFT width=\"10%\"> <B> Last Login </B>  </TD>
                    <TD ALIGN=LEFT width=\"5%\"> <B> Phone </B>  </TD>
                    <TD ALIGN=center width=\"5%\"> <B> Verified </B>  </TD>
					<TD ALIGN=center width=\"5%\"> <B> Connected </B>  </TD>
                    <TD ALIGN=LEFT width=\"45px\"> <B> Actions </B>  </TD>
      </TR>
        <?
        $query = "select * from HB_users
                        WHERE name like '%$_POST[keyword]%' || nick like '%$_POST[keyword]%' || email like '%$_POST[keyword]%'
                        order by nick";
        $result = mysql_query($query);
        //print $query;
        if(!$result){
            print "Database access error: abnormal termination<BR>$query<BR>".mysql_error();
            exit;
        }
        $num_users = mysql_num_rows($result);
        $i = 0;
        $bgcolor = "#FFFFFF";
        while($i < $num_users) {            
            if($bgcolor == "#FFFFFF") {
                $bgcolor = "#EEEEEE";
            } else {
                $bgcolor = "#FFFFFF";
            }            
            $id = mysql_result($result,$i,"id");
			$balance = mysql_result($result, $i, "balance");
            $nick = mysql_result($result,$i,"nick");
            $name = mysql_result($result,$i,"name");
            $country = mysql_result($result,$i,"country");
            $email = mysql_result($result,$i,"email");
            $suspended = mysql_result($result,$i,"suspended");
            $newsletter = mysql_result($result,$i,"nletter");
			$lastlogin = mysql_result($result, $i, "lastlogin");
			$verified = mysql_result($result, $i, "verified");
			$connected = mysql_result($result, $i, "oauth_provider");
			$phone = mysql_result($result, $i, "phone");
            print '' . "<TR BGCOLOR=" . $bgcolor . ">
                    <TD>" . $nick . "</TD>
                    <TD>" . $name . "</TD>
					<TD>" . $balance . " coins</TD>
                    <TD><A HREF=\"mailto:" . $email . "\" title='" . $email . "'>" . substr($email, 0, 14) . "...</A></TD>
                    <TD>" . $lastlogin . "</TD>
					<TD>" . $phone . "</TD>
					<TD align=center>";
			if ($verified == 1)
			{
				print '' . $MSG_verified_1;
			}
			if ($verified == 0)
			{
				print '' . $MSG_verified_0;
			}
			print "</TD><TD align=center>";
			if ($connected == facebook)
			{
				print '' . $MSG_connected_1;
			}
			else
			{
				print '' . $MSG_connected_0;
			}
			print "</TD>";
			print '' . "<TD ALIGN=LEFT>
                    <A HREF=\"edituser.php?userid=" . $id . "&offset=" . $offset . "\" class=\"buttonadminblue\">" . $MSG_298 . "</A>
                    <A HREF=\"deleteuser.php?id=" . $id . "&offset=" . $offset . "\" class=\"buttonadminblue\">" . $MSG_299 . "</A>
                    <A HREF=\"excludeuser.php?id=" . $id . "&offset=" . $offset . "\" class=\"buttonadminblue\">";
			if ($suspended == 0)
			{
				print $MSG_300;
			}
			 else 
			{
				print $MSG_310;
			}
			print '' . "</A>
                    <A HREF=\"viewuserips.php?id=" . $id . "&offset=" . $offset . "\" class=\"buttonadminblue\">" . $MSG_2_0004 . "</A>
                   
                    </TD>
                    </TR>";
			$i++;
        }        
        print "</TABLE>";
        print "</TD></TR></TABLE>";
      ?>
    </TABLE>
</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>
