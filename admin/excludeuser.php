<?

include "../includes/config.inc.php";
include "loggedin.inc.php";
include $include_path."countries.inc.php";

$username = $name;
//-- Data check

if(!$_REQUEST['id']){
    header("Location: listusers.php");
    exit;
}

if($_POST['action']=='Delete'){
    if($_POST['mode'] == "activate") {
        $sql="update HB_users set suspended=0,reg_date=reg_date WHERE id='$_POST[idhidden]'";
        /* Update column users in table HB_counters */
        $counteruser = mysql_query("UPDATE HB_counters SET inactiveusers=(inactiveusers-1), users=(users+1)");
    } else {
        $sql="update HB_users set suspended=1,reg_date=reg_date WHERE id='$_POST[idhidden]'";

        /* Update column users in table HB_counters */
        $counteruser = mysql_query("UPDATE HB_counters SET inactiveusers=(inactiveusers+1), users=(users-1)");
    }
    $res=mysql_query ($sql);
    
    Header("Location: listusers.php");
    exit;
}

if(!$action || ($action && $updated)) {
    
    $query = "select * from HB_users where id='".$_GET['id']."'";
    $result = mysql_query($query);
    if(!$result){
        print "Database access error: abnormal termination".mysql_error();
        exit;
    }

    $username = mysql_result($result,0,"name");
    $nick = mysql_result($result,0,"nick");
    $password = mysql_result($result,0,"password");
    $email = mysql_result($result,0,"email");
    $address = mysql_result($result,0,"address");
    $country = mysql_result($result,0,"country");
    $country_list="";
    while (list ($code, $descr) = each ($countries)) {
        $country_list .= "<option value=\"$descr\"";
        if ($descr == $country) {
            $country_list .= " selected";
        }
        $country_list .= ">$descr</option>\n";
    }
    
    $prov = mysql_result($result,0,"prov");
    $zip = mysql_result($result,0,"zip");
    $birthdate = mysql_result($result,0,"birthdate");
    $birth_day = substr($birthdate,6,2);
    $birth_month = substr($birthdate,4,2);
    $birth_year = substr($birthdate,0,4);
    $birthdate = "$birth_day/$birth_month/$birth_year";
    $phone = mysql_result($result,0,"phone");
    $suspended = mysql_result($result,0,"suspended");
    $rate_num = mysql_result($result,0,"rate_num");
    $rate_sum = mysql_result($result,0,"rate_sum");
    if ($rate_num) {
        $rate = round($rate_sum / $rate_num);
    } else {
        $rate=0;
    }
}
?>
<HTML> 
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<STYLE TYPE="text/css">
body {
scrollbar-face-color: #aaaaaa;
scrollbar-shadow-color: #666666;
scrollbar-highlight-color: #aaaaaa;
scrollbar-3dlight-color: #dddddd;
scrollbar-darkshadow-color: #444444;
scrollbar-track-color: #cccccc;
scrollbar-arrow-color: #ffffff;
}</STYLE>
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
<BR>
<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#546f95" align="CENTER">
        <tr>
          <td align=CENTER class=title>
            <?
            if($suspended > 0) {
                print $MSG_306;
            } else {
                print $MSG_305;
            }
        ?>
            </b></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">
                <table width=100% celpadding=4 cellspacing=5 border=0 bgcolor="#FFFFFF">
                    
                      <?
                      if($updated){
                          print "<TR><TD></TD><TD WIDTH=486>";
                          if($updated) print "Users data updated";
                          print "</TD>
                    </TR>";
                      }
?>
                      <tr>
                        <td width="204" valign="top" align="right"><? print "$MSG_302"; ?> </td>
                        <td width="486"><?print $username; ?> </td>
                      </tr>
                      <tr>
                        <td width="204" valign="top" align="right"><? print "$MSG_003"; ?> </td>
                        <td width="486"><? print $nick; ?> </td>
                      </tr>
 
                      <tr>
                        <td width="204"  valign="top" align="right"><? print "$MSG_303"; ?> </td>
                        <td width="486"><? print $email; ?> </td>
                      </tr>
                      <tr>
                        <td width="204" valign="top" align="right"><? print "$MSG_009"; ?> </td>
                        <td width="486"><? print $address; ?> </td>
                      </tr>
                      <tr>
                        <td width="204" valign="top" align="right"><? print "$MSG_014"; ?> </td>
                        <td width="486"><? print $country; ?> </td>
                      </tr>
                      <tr>
                        <td width="204" valign="top" align="right"><? print "$MSG_012"; ?> </td>
                        <td width="486"><? print $zip; ?> </td>
                      </tr>

                      <tr>
                        <td width="204" valign="top" align="right"><? print "$MSG_222"; ?> </td>
                        <td width="486"><? if(!$rate) $rate=0; ?>
                          <img src="../images/estrella_<? echo $rate; ?>.gif"> </td>
                      </tr>
                      <tr>
                        <td width="204" valign="top" align="right">
                          <?
                          if($suspended > 0) {
                              print $MSG_310;
                          } else {
                              print $MSG_300;
                          }
                          ?>
                        </td>
                        <td width="486">
                        <?
                          if($suspended == 0)
                          print "$MSG_029";
                          else
                          print "$MSG_030";
                        ?>
                        </td>
                      </tr>
                      <tr>
                        <td width="204">&nbsp;</td>
                        <td width="486">
                          <?
                          if($suspended > 0) {
                              print $MSG_309;
                              $mode = "activate";
                          } else {
                              print $MSG_308;
                              $mode = "suspend";
                          }
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td width="204">&nbsp;</td>
                        <td width="486"><form name=details action="excludeuser.php" method="POST">
                            <input type="hidden" name="id" value="<? echo $_GET['id']; ?>">
                            <input type="hidden" name="offset" value="<? echo $_GET['offset']; ?>">
                            <input type="hidden" name="action" value="Delete">
                            <input type="hidden" name="idhidden" value="<?=$_GET['id']?>">
                            <input type="hidden" name="mode" value="<? print $mode; ?>">
                            <input TYPE="submit" NAME="act" value="<? print $MSG_030; ?>">
                          </form></td>
                      </tr>
                    </table>
                 
                  
        </td>
        </tr>
      </table>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>