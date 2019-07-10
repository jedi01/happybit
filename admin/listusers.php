<?php


		include "../includes/config.inc.php";
		include "loggedin.inc.php";
		if ($_GET["usersfilter"] == "all")
		{
			unset($_SESSION["usersfilter"]);
			unset($Q);
		}
		 else 
		{
			if (isset($_GET["usersfilter"]))
			{
				switch ($_GET["usersfilter"])
				{
					case "active":
					{
						$Q = 0;
						break;
					}
					case "admin":
					{
						$Q = 1;
						break;
					}
					case "confirmed":
					{
						$Q = 8;
						break;
					}
					case "fee":
					{
						$Q = 9;
						break;
					}
					case "sellers":
					{
						$account = "seller";
						break;
					}
					case "buyers":
					{
						$account = "buyer";
					}
				}
				$usersfilter = $_GET["usersfilter"];
				$_SESSION["usersfilter"] = $usersfilter;
			}
			 else 
			{
				if (!(isset($_GET["usersfilter"])) && isset($_SESSION["usersfilter"]))
				{
					switch ($_SESSION["usersfilter"])
					{
						case "active":
						{
							$Q = 0;
							break;
						}
						case "admin":
						{
							$Q = 1;
							break;
						}
						case "confirmed":
						{
							$Q = 8;
							break;
						}
						case "fee":
						{
							$Q = 9;
							break;
						}
						case "sellers":
						{
							$account = "seller";
							break;
						}
						case "buyers":
						{
							$account = "buyer";
						}
					}
				}
				 else 
				{
					unset($_SESSION["usersfilter"]);
					unset($Q);
				}
			}
		}
		if (isset($Q))
		{
			$TOTALUSERS = mysql_result(mysql_query('' . "select count(id) as COUNT from HB_users WHERE suspended=" . $Q), 0, "COUNT");
		}
		 else 
		{
			if (isset($account))
			{
				$TOTALUSERS = mysql_result(mysql_query('' . "select count(id) as COUNT from HB_users WHERE accounttype='" . $account . "'"), 0, "COUNT");
			}
			 else 
			{
				$TOTALUSERS = mysql_result(mysql_query("select count(id) as COUNT from HB_users"), 0, "COUNT");
			}
		}
		$LIMIT = 400;
		if (!$offset)
		{
			$offset = 0;
		}
		if (!(isset($_GET[PAGE])) || $_GET[PAGE] == 1 || !$_GET[PAGE])
		{
			$OFFSET = 0;
			$PAGE = 1;
		}
		 else 
		{
			$PAGE = $_GET[PAGE];
			$OFFSET = $_GET[PAGE] - 1 * $LIMIT;
		}
		$PAGES = ceil($TOTALUSERS / $LIMIT);
		$_SESSION["RETURN_LIST"] = "listusers.php";
		$_SESSION["RETURN_LIST_PAGE"] = intval($PAGE);
		echo "<HTML>
<HEAD>
";
		echo "<S";
		echo "CRIPT Language=Javascript>
<!--
function SubmitFilter()
{
    document.filter.submit();
}
//-->
</SCRIPT>
<link rel='stylesheet' type='text/css' href='style.css' />
<link rel='stylesheet' type='text/css' href='/themes/default/styles/tooltips_main.css'/>
<link rel='stylesheet' type='text/css' href='/themes/default/styles/tooltips_styles.css'/>
";
		echo "<S";
		echo "CRIPT Language=Javascript>
function window_open(pagina,titulo,ancho,largo,x,y){
    
    var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
    open(pagina,titulo,Ventana);
    
}
</SCRIPT>
</HEAD>
<body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#0066FF\" vlink=\"#666666\" alink=\"#000066\" leftmargin=\"0\" to";
		echo "pmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">
		<div class=admintitle>User Management</div>
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=margin-top:10px>
  <tr> 
    <td align=\"center\" valign=\"middle\">
      <table width=\"95%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" BGCOLOR=\"#3399CC\" align=\"center\">
            <TR>
            <TD>
                <TABLE WIDTH=100% CELPADDING=4 CELLSPACING=1 BORDER=0 ALIGN=\"CENTER\" CELLPADDING=\"3\" BGCOLOR=#ffffff>
                <TR>
                <TD COLSPAN=9>
                    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"right\">
                    <FORM NAME=search ACTION=userssearch.php METHOD=POST>
         ";
		echo "           <tr>
                    <td bgcolor=\"#eeeeee\"> 
                    <BR>
                    ";
		echo $MSG_5022;
		echo " <INPUT TYPE=text NAME=keyword SIZE=25>
                    <input type=SUBMIT name=SUBMIT value=\"";
		echo $MSG_5023;
		echo "\">
                    ";
		echo $MSG_5024;
		echo "                    </td>
                    </tr>
                    </FORM>
                    </table>
                </TD>
                </TR>
                <TR BGCOLOR=#FFFFFF>
                <TD COLSPAN=9>
                <TABLE WIDTH=100% CELLPADDING=1 CELLSPACING=0 BORDER=0>
    			  <FORM NAME=\"filter\" ACTION=\"";
		echo basename($_SERVER["PHP_SELF"]);
		echo "\">
                  <TR>
                    <TD WIDTH=30% style=font-size:14px;color:#444444;> <B>
                    ";
		echo $TOTALUSERS . " " . $MSG_301;
		echo "                    </B> </TD>
                    <TD WIDTH=20% valign=\"center\">
                    <TD WIDTH=50% align=right>
                    ";
		echo $MSG_5295;
		echo "                    ";
		echo "<S";
		echo "ELECT NAME=usersfilter onChange=\"SubmitFilter()\">
                    <OPTION VALUE=all>
                    ";
		echo $MSG_5296;
		echo "                    </OPTION>
                    <OPTION VALUE=active ";
		if ($_SESSION["usersfilter"] == "active")
		{
			print " selected";
		}
		echo ">
                    ";
		echo $MSG_5291;
		echo "                    </OPTION>
                    <OPTION VALUE=admin ";
		if ($_SESSION["usersfilter"] == "admin")
		{
			print " selected";
		}
		echo ">
                    ";
		echo $MSG_5294;
		echo "                    </OPTION>
                    
                    
                    </SELECT>
                    </TD>
                  </TR>
                  </FORM>
                  </TABLE>
                </TD>
                </TR>
                <TR BGCOLOR=\"#FFCC00\">
                    <!--<TD ALIGN=CENTER width=\"5%\"> <B> ";
		echo " </B>  </TD>-->
                    <TD ALIGN=LEFT width=\"10%\"> <B> Username </B>  </TD>
                    <TD ALIGN=LEFT width=\"12%\"> <B> Real Name </B>  </TD>
                    <TD ALIGN=LEFT width=\"8%\"> <B> Balance </B>  </TD>
                    <TD ALIGN=LEFT width=\"10%\"> <B> Email </B>  </TD>
                    <TD ALIGN=LEFT width=\"12%\"> <B> Last Login </B>  </TD>
                    <TD ALIGN=LEFT width=\"5%\"> <B> Phone </B>  </TD>
                    <TD ALIGN=center width=\"5%\"> <B> Verified </B>  </TD>
					<TD ALIGN=center width=\"5%\"> <B> Connected </B>  </TD>
                    <TD ALIGN=LEFT width=\"45px\"> <B> Actions </B>  </TD>
                </tr>
                ";
		if (isset($Q))
		{
			$query = '' . "select * from HB_users WHERE suspended=" . $Q . " order by lastlogin DESC limit " . $OFFSET . ", " . $LIMIT;
		}
		 else 
		{
			if (isset($account))
			{
				$query = '' . "select * from HB_users WHERE accounttype='" . $account . "' order by lastlogin DESC limit " . $OFFSET . ", " . $LIMIT;
			}
			 else 
			{
				$query = '' . "select * from HB_users order by lastlogin DESC limit " . $OFFSET . ", " . $LIMIT;
			}
		}
		$result = mysql_query($query);
		if (!$result)
		{
			print '' . "Database access error: abnormal termination<BR>" . $query . "<BR>" . mysql_error();
			exit();
		}
		$num_users = mysql_num_rows($result);
		$i = 0;
		$bgcolor = "#FFFFFF";
		while ($num_users > $i)
		{
			if ($bgcolor == "#FFFFFF")
			{
				$bgcolor = "#EEEEEE";
			}
			 else 
			{
				$bgcolor = "#FFFFFF";
			}
			$id = mysql_result($result, $i, "id");
			$balance = mysql_result($result, $i, "balance");
			$nick = mysql_result($result, $i, "nick");
			$name = mysql_result($result, $i, "name");
			$country = mysql_result($result, $i, "country");
			$email = mysql_result($result, $i, "email");
			$creditcard = mysql_result($result, $i, "creditcard");
			$suspended = mysql_result($result, $i, "suspended");
			$newsletter = mysql_result($result, $i, "nletter");
			$lastlogin = mysql_result($result, $i, "lastlogin");
			$verified = mysql_result($result, $i, "verified");
			$connected = mysql_result($result, $i, "oauth_provider");
			$phone = mysql_result($result, $i, "phone");
			print '' . "<TR BGCOLOR=" . $bgcolor . ">
                    <TD>" . $nick . "</TD>
                    <TD>" . $name . "</TD>
					<TD>" . $balance . " coins</TD>
                    <TD><A HREF=\"mailto:" . $email . "\" class='qlabs_tooltip_top qlabs_tooltip_style_1'><span>" . $email . "</span>" . substr($email, 0, 14) . "...</A></TD>
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
                    <A HREF=\"viewuserips.php?id=" . $id . "&offset=" . $offset . "\" class=\"buttonadminblue\">User IPs</A>
                   
                    </TD>
                    </TR>";
			$i++;
			continue;
		}
		echo "                </TABLE>
                <center class=white>
                ";
		echo $MSG_5117;
		echo "                &nbsp;&nbsp;
                ";
		echo $PAGE;
		echo "                ";
		echo $MSG_5118;
		echo "                &nbsp;&nbsp;
                ";
		echo $PAGES;
		echo "                <BR>
                ";
		$PREV = intval($PAGE - 1);
		$NEXT = intval($PAGE + 1);
		echo "                ";
		if ($PAGES > 1)
		{
			if ($PAGE > 1)
			{
				echo "    		  	<A HREF=\"";
				echo basename($_SERVER[PHP_SELF]);
				echo "?PAGE=";
				echo $PREV;
				echo "\"><U>";
				echo "<S";
				echo "PAN CLASS=white>
                ";
				echo $MSG_5119;
				echo "                </SPAN></U></a> &nbsp;&nbsp;
                ";
			}
			echo "                ";
			$LOW = $PAGE - 5;
			if ($LOW <= 0)
			{
				$LOW = 1;
			}
			$COUNTER = $LOW;
			while ($COUNTER <= $PAGES && $COUNTER < $PAGE + 6)
			{
				if ($PAGE == $COUNTER)
				{
					print '' . "<B>" . $COUNTER . "</B>&nbsp;&nbsp;";
				}
				 else 
				{
					print "<A HREF=\"" . basename($_SERVER[PHP_SELF]) . ('' . "?PAGE=" . $COUNTER . "\"><U><SPAN CLASS=white>" . $COUNTER . "</SPAN></U></A>&nbsp;&nbsp;");
				}
				$COUNTER++;
				continue;
			}
			echo "                &nbsp;&nbsp;
                ";
			if ($PAGES > $PAGE)
			{
				echo "      			<A HREF=\"";
				echo basename($_SERVER[PHP_SELF]);
				echo "?PAGE=";
				echo $NEXT;
				echo "\"><U>";
				echo "<S";
				echo "PAN CLASS=white>
                  ";
				echo $MSG_5120;
				echo "                  </SPAN></U></A> 
                ";
			}
		}
		echo "                </center>
                </TD>
              </TR>
            </TABLE>
            <BR>
          </TD>
        </TR>
      </TABLE>
    </td>
  </tr>
</table>
</BODY>
</HTML>

";
echo "
";
