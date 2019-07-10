<?

require('../includes/config.inc.php');
include "loggedin.inc.php";

$id = $_REQUEST[id];
$offset = $_REQUEST[offset];
if($_POST[action] == "update")
{
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

#//
$query = "SELECT nick,email,lastlogin FROM HB_users WHERE id='".$id."'";
$res = @mysql_query($query);
if(!$res)
{
	print "Error: $query<BR>".mysql_error();
	exit;
}
elseif(mysql_num_rows($res) > 0)
{
	$USER = mysql_fetch_array($res);
}

#//
$query = "SELECT * FROM HB_usersips WHERE user='$id' AND type='first'";
$res = @mysql_query($query);
if(!$res)
{
	print "Error: $query<BR>".mysql_error();
	exit;
}
elseif(mysql_num_rows($res) > 0)
{
	$FIRST = mysql_fetch_array($res);
}

$query = "SELECT * FROM HB_usersips WHERE user='$id' AND type<>'first'";
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
    <td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr> 
          <td width="30"><img src="images/i_use.gif" ></td>
          <td class=white><?=$MSG_25_0010?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_045?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
    <tr> 
    <td align="center" valign="middle">
<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#546f95" ALIGN="CENTER">
	<TR>
		<TD ALIGN=CENTER class=title>
			<? print $MSG_2_0004; ?>
		</TD>
	</TR>
	<TR>
		<TD>

      <TABLE WIDTH=100% CELPADDING=0 CELLSPACING=1 BORDER=0 ALIGN="CENTER" CELLPADDING="3">
        <TR BGCOLOR=#FFFFFF ALIGN=CENTER>
          <TD colspan=7>
		  <FORM NAME=banform ACTION=<?=basename($_SERVER['PHP_SELF'])?> METHOD=POST>
              <table width="90%" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFFF">
                <tr>
                  <td bgcolor="#ffffff">
                    <b>
                      <? print $MSG_2_0016; ?></b>
                      <?=$USER['nick']?>
					  (<A HREF=<?=$USER['email']?>><?=$USER['email']?></A>)
                    </td>
					<TD ALIGN=right>
					<?=$MSG_559.":".$USER['lastlogin']?>
                </tr>
              </table>
              <table width="90%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCCC">
                <tr>
                  <td width="35%" bgcolor="#eeeeee">
                    <div align="center"><b>
                      <? print $MSG_2_0008; ?>
                      </b></div>
                  </td>
                  <td width="27%" bgcolor="#eeeeee">
                    <div align="center"><b>
                      <? print $MSG_2_0009; ?>
                      </b></div>
                  </td>
                  <td width="21%" bgcolor="#eeeeee">
                    <div align="center"><b>
                      <? print $MSG_2_0010; ?>
                      </b></div>
                  </td>
                  <td width="17%" bgcolor="#eeeeee">
                    <div align="center"><b>
                      <? print $MSG_2_0011; ?>
                      </b></div>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="35%"> <b>
                    <? print $MSG_2_0005; ?>
                    </b></td>
                  <td width="27%">
                    <div align="center"><b>
                      <? print $FIRST['ip']; ?>
                      </b></div>
                  </td>
                  <td width="21%" align=center> 
                    <?
                    if($FIRST['action'] == 'accept')
                    {
                    	print $MSG_2_0012;
                    }
                    else
                    {
                    	print $MSG_2_0013;
                    }
				  ?>
                     </td>
                  <td width="17%"> 
                    <?
                    if($FIRST['action'] == 'accept')
                    {
					?>
                    <input type="checkbox" name="deny[<?=$FIRST['id']?>]2" value="<?=$FIRST['id']?>">
                    <?
                    print "&nbsp;".$MSG_25_0014;
                    }
                    else
                    {
					?>
                    <input type="checkbox" name="accept[<?=$FIRST['id']?>]2" value="<?=$FIRST['id']?>">
                    <?
                    print "&nbsp;".$MSG_2_0007;
                    }
				  ?>
                     </td>
                </tr>
                <?
                if(is_array($NEXT))
                {
                	while(list($k,$v) = each($NEXT))
                	{
				?>
                <tr bgcolor="#FFFFFF">
                  <td width="35%"> 
                    <?=$MSG_2_0014?>
                     </td>
                  <td width="27%" align=center> 
                    <?=$v['ip']?>
                     </td>
                  <td width="21%" align=center> 
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
                  <td width="17%"> 
                    <?
                    if($v['action'] == 'accept')
                    {
					?>
                    <input type="checkbox" name="deny[<?=$v['id']?>]2" value="<?=$v['id']?>">
                    <?
                    print "&nbsp;".$MSG_25_0014;
                    }
                    else
                    {
					?>
                    <input type="checkbox" name="accept[<?=$v['id']?>]2" value="<?=$v['id']?>">
                    <?
                    print "&nbsp;".$MSG_2_0007;
                    }
				  ?>
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
            </FORM>
          </TD>
        </TR>

      </TABLE>
</TD></TR></TABLE>

</TD>
</TR>
</TABLE>
</BODY>
</HTML>
