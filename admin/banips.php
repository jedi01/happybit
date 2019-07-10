<?

require('../includes/config.inc.php');
include "loggedin.inc.php";

if($_POST[action] == "update" && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF']))
{
	if(!empty($_POST['ip']))
	{
		$query = "INSERT INTO HB_usersips VALUES(
					  NULL,
					  'NOUSER',
					  '".$_POST['ip']."',
					  'next',
					  'deny')";
		$res = @mysql_query($query);
	}
	
	if(is_array($_POST['delete']))
	{
		while(list($k,$v) = each($_POST['delete']))
		{
			@mysql_query("DELETE FROM HB_usersips WHERE id=$k");
		}
	}
	if(is_array($_POST['accept']))
	{
		while(list($k,$v) = each($_POST['accept']))
		{
			@mysql_query("UPDATE HB_usersips SET action='accept' WHERE id=$k");
		}
	}
	if(is_array($_POST['deny']))
	{
		while(list($k,$v) = each($_POST['deny']))
		{
			@mysql_query("UPDATE HB_usersips SET action='deny' WHERE id=$k");
		}
	}
}

$query = "SELECT * FROM HB_usersips WHERE user='NOUSER'";
$res = @mysql_query($query);
if(!$res)
{
	print "Error: $query<BR>".mysql_error();
	exit;
}
elseif(mysql_num_rows($res) > 0)
{
	while($row = mysql_fetch_array($res))
	{
		$NEXT[$row['id']] = $row;
	}
}
?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td background="images/bac_barint.gif">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr> 
          <td width="30"><img src="images/i_use.gif" ></td>
          <td class=white><?=$MSG_25_0010?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_2_0017?></td>
        </tr>
      	</table>
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr> 
  <td align="center" valign="middle">
	<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#546f95" ALIGN="CENTER">
	<TR>
		<TD ALIGN=CENTER class=title>
			<? print $MSG_2_0020; ?>
		</TD>
	</TR>
	<TR>
	<TD>
	<FORM NAME=banform ACTION=<?=basename($_SERVER['PHP_SELF'])?> METHOD=POST>
      <TABLE WIDTH=100% CELPADDING=0 CELLSPACING=1 BORDER=0 ALIGN="CENTER" CELLPADDING="3">
        <TR BGCOLOR=#FFFFFF ALIGN=CENTER>
          <TD>
		  
              <table width="100%" border="0" cellspacing="0" cellpadding="4" bgcolor="#CCCCCC">
                <tr>
                  <td bgcolor="#FFFF66">
                    <?=$MSG_2_0021?>
                    <input type="text" name="ip">
                    <input type="submit" name="Submit2" value="&gt;&gt;">
                    <?=$MSG_2_0024?>
                     </td>
                </tr>
              </table>
              <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCCC">
                <tr>
                  <td width="29%" bgcolor="#eeeeee">
                    <div align="center"><b>
                      <? print $MSG_2_0008; ?>
                      </b></div>
                  </td>
                  <td width="25%" bgcolor="#eeeeee">
                    <div align="center"><b>
                      <? print $MSG_2_0009; ?>
                      </b></div>
                  </td>
                  <td width="19%" bgcolor="#eeeeee">
                    <div align="center"><b>
                      <? print $MSG_2_0010; ?>
                      </b></div>
                  </td>
                  <td width="18%" bgcolor="#eeeeee">
                    <div align="center"><b>
                      <? print $MSG_2_0011; ?>
                      </b></div>
                  </td>
                  <td width="9%" bgcolor="#eeeeee">
                    <div align="center"><b>
                      <? print $MSG_2_0022; ?>
                      </b></div>
                  </td>
                </tr>
                <?
                if(is_array($NEXT))
                {
                	while(list($k,$v) = each($NEXT))
                	{
				?>
                <tr bgcolor="#FFFFFF">
                  <td width="29%"> 
                    <?=$MSG_2_0025?>
                     </td>
                  <td width="25%" align=center> 
                    <?=$v['ip']?>
                     </td>
                  <td width="19%" align=center> 
                    <?
                    if($v['action'] == 'accept')
                    {
                    	print $MSG_2_0012;
                    }
                    else
                    {
                    	print $MSG_2_0013;
                    }
				  ?>
                     </td>
                  <td width="18%"> 
                    <?
                    if($v['action'] == 'accept')
                    {
					?>
                    <input type="checkbox" name="deny[<?=$v['id']?>]22" value="<?=$v['id']?>">
                    <?
                    print "&nbsp;".$MSG_30_0161;
                    }
                    else
                    {
					?>
                    <input type="checkbox" name="accept[<?=$v['id']?>]22" value="<?=$v['id']?>">
                    <?
                    print "&nbsp;".$MSG_2_0007;
                    }
				  ?>
                     </td>
                  <td width="9%">
                    <div align="center">
                      <input type="checkbox" name="delete[<?=$v['id']?>]" value="<?=$v['id']?>">
                    </div>
                  </td>
                  <?
                	}
                }
				?>
                </tr>
              </table>
              <p>&nbsp;</p>
              <p>
                <input type="submit" name="Submit" value="<?=$MSG_2_0015?>">
                <INPUT TYPE=hidden NAME=action VALUE=update>
                <INPUT TYPE=hidden NAME=id VALUE=<?=$id?>>
              </p>
			  </TD>
        	</TR>
			</table>
            </FORM>
          </TD>
        </TR></table>
</TD></TR></TABLE>
</BODY>
</HTML>