<?php


include "../includes/config.inc.php";
include "loggedin.inc.php";
include "../includes/countries.inc.php";
$username = $_REQUEST["name"];
$userid = $_REQUEST["userid"];
if (empty($userid))
{
	header("Location: listusers.php");
	exit();
}
$query = "SELECT * FROM HB_usersettings";
$res_s = mysql_query($query);
if (!$res_s)
{
	mysqlerror($query);
	exit();
}
 else 
{
	$REQUESTED_FIELDS = unserialize(mysql_result($res_s, 0, "requested_fields"));
	$MANDATORY_FIELDS = unserialize(mysql_result($res_s, 0, "mandatory_fields"));
}
if ($_POST["action"] == "update" && strstr(basename($_SERVER["HTTP_REFERER"]), basename($_SERVER["PHP_SELF"])))
{
	if ($_POST["name"] && $_POST["email"])
	{
		$DATE = explode("/", $_POST["birthdate"]);
		if ($SETTINGS[datesformat] == "USA")
		{
			$birth_day = $DATE[1];
			$birth_month = $DATE[0];
			$birth_year = $DATE[2];
		}
		 else 
		{
			$birth_day = $DATE[0];
			$birth_month = $DATE[1];
			$birth_year = $DATE[2];
		}
		if (strlen($birth_year) == 2)
		{
			$birth_year = "19" . $birth_year;
		}
		$credit = isset($_POST["credit"]) ? (double)$_POST["credit"] : "0";
		if ($_POST["password"] != $_POST["repeat_password"])
		{
			$ERR = "ERR_006";
		}
		 else 
		{
			if (strlen($_POST["email"]) < 5)
			{
				$ERR = "ERR_110";
			}
			 else 
			{
				if (!(eregi('' . "^[_a-z0-9-]+(\\.[_a-z0-9-]+)*@[a-z0-9-]+([\\.][a-z0-9-]+)+\$", $_POST["email"])))
				{
					$ERR = "ERR_008";
				}
				 else 
				{
					if (!(ereg('' . "^[0-9]{2}/[0-9]{2}/[0-9]{4}\$", $_POST["birthdate"])) && !(ereg('' . "^[0-9]{2}/[0-9]{2}/[0-9]{2}\$", $_POST["birthdate"])) && $MANDATORY_FIELDS["birthdate"] == "y" && $REQUESTED_FIELDS["birthdate"] == "y")
					{
						$ERR = "ERR_043";
					}
					 else 
					{
						if (strlen($_POST["zip"]) < 4 && $MANDATORY_FIELDS["zip"] == "y" && $REQUESTED_FIELDS["zip"] == "y")
						{
							$ERR = "ERR_616";
						}
						 else 
						{
							$birthdate = '' . $birth_year . ('' . $birth_month) . ('' . $birth_day);
							$sql = "UPDATE HB_users SET 
                  name=\"" . addslashes($_POST["name"]) . "\", email=\"" . addslashes($_POST["email"]) . "\", address=\"" . addslashes($_POST["address"]) . "\", city=\"" . addslashes($_POST["city"]) . "\", prov=\"" . addslashes($_POST["prov"]) . "\", country=\"" . addslashes($_POST["country"]) . "\", zip=\"" . addslashes($_POST["zip"]) . "\", phone=\"" . addslashes($_POST["phone"]) . "\", verified=\"" . addslashes($_POST["verified"]) . "\", a_wins=\"" . addslashes($_POST["a_wins"]) . "\", a_packs=\"" . addslashes($_POST["a_packs"]) . "\", a_feedback=\"" . addslashes($_POST["a_feedback"]) . "\", a_poser=\"" . addslashes($_POST["a_poser"]) . "\", a_tweet=\"" . addslashes($_POST["a_tweet"]) . "\", a_faceb=\"" . addslashes($_POST["a_faceb"]) . "\", a_25coins=\"" . addslashes($_POST["a_25coins"]) . "\", a_50coins=\"" . addslashes($_POST["a_50coins"]) . "\", a_100coins=\"" . addslashes($_POST["a_100coins"]) . "\", a_200coins=\"" . addslashes($_POST["a_200coins"]) . "\", a_survey=\"" . addslashes($_POST["a_survey"]) . "\", a_2coin=\"" . addslashes($_POST["a_2coin"]) . "\", a_3coin=\"" . addslashes($_POST["a_3coin"]) . "\", a_5coin=\"" . addslashes($_POST["a_5coin"]) . "\", a_daylight=\"" . addslashes($_POST["a_daylight"]) . "\", a_bargain=\"" . addslashes($_POST["a_bargain"]) . "\", a_lightning=\"" . addslashes($_POST["a_lightning"]) . "\", a33=\"" . addslashes($_POST["a33"]) . "\", birthdate=\"" . addslashes($birthdate) . "\", reg_date=reg_date, balance=balance+" . $credit . " ";
							if (strlen($_POST["password"]) > 0)
							{
								$sql .= ", password=\"" . md5($MD5_PREFIX . addslashes($_POST["password"])) . "\"";
							}
							$sql .= ",reg_date=reg_date WHERE id='" . addslashes($userid) . "'";
							$res = mysql_query($sql);
							$updated = 1;
							$URL = $_SESSION["RETURN_LIST"] . "?PAGE=" . $_SESSION["RETURN_LIST_PAGE"];
							unset($_SESSION["RETURN_LIST"]);
							header('' . "Location: " . $URL);
							exit();
						}
					}
				}
			}
		}
	}
	 else 
	{
		$ERR = "ERR_112";
	}
}
if (!$_POST["action"] || $_POST["action"] && $updated)
{
	$query = '' . "select * from HB_users where id=\"" . $userid . "\"";
	$result = mysql_query($query);
	if (!$result)
	{
		print "Database access error: abnormal termination" . mysql_error();
		exit();
	}
	$username = mysql_result($result, 0, "name");
	$nick = mysql_result($result, 0, "nick");
	$password = mysql_result($result, 0, "password");
	$email = mysql_result($result, 0, "email");
	$address = mysql_result($result, 0, "address");
	$city = mysql_result($result, 0, "city");
	$prov = mysql_result($result, 0, "prov");
	$phone = mysql_result($result, 0, "phone");
	$verified = mysql_result($result, $i, "verified");
	$suspended = mysql_result($result, 0, "suspended");
	$balance = mysql_result($result, 0, "balance");
	$offers = mysql_result($result, 0, "offers");
	$a_wins = mysql_result($result, $i, "a_wins");
	$a_packs = mysql_result($result, $i, "a_packs");
	$a_feedback = mysql_result($result, $i, "a_feedback");
	$a_poser = mysql_result($result, $i, "a_poser");
	$a_tweet = mysql_result($result, $i, "a_tweet");
	$a_faceb = mysql_result($result, $i, "a_faceb");
	$a_25coins = mysql_result($result, $i, "a_25coins");
	$a_50coins = mysql_result($result, $i, "a_50coins");
	$a_100coins = mysql_result($result, $i, "a_100coins");
	$a_200coins = mysql_result($result, $i, "a_200coins");
	$a_survey = mysql_result($result, $i, "a_survey");
	$a_2coin = mysql_result($result, $i, "a_2coin");
	$a_3coin = mysql_result($result, $i, "a_3coin");
	$a_5coin = mysql_result($result, $i, "a_5coin");
	$a_daylight = mysql_result($result, $i, "a_daylight");
	$a_bargain = mysql_result($result, $i, "a_bargain");
	$a_lightning = mysql_result($result, $i, "a_lightning");
	$a33 = mysql_result($result, $i, "a33");
	$country = mysql_result($result, 0, "country");
	$connected = mysql_result($result, $i, "oauth_provider");
	$country_list = "";

	$prov = mysql_result($result, 0, "prov");
	$zip = mysql_result($result, 0, "zip");
	$birthdate = mysql_result($result, 0, "birthdate");
	$birth_day = substr($birthdate, 6, 2);
	$birth_month = substr($birthdate, 4, 2);
	$birth_year = substr($birthdate, 0, 4);
	$birthdate = $SETTINGS[datesformat] == "USA" ? '' . $birth_month . "/" . $birth_day . "/" . $birth_year : '' . $birth_day . "/" . $birth_month . "/" . $birth_year;
	$rate_sum = mysql_result($result, 0, "rate_sum");
	if ($rate_num = mysql_result($result, 0, "rate_num"))
	{
		$rate = round($rate_sum / $rate_num);
	}
	 else 
	{
		$rate = 0;
	}
}
echo "<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
";
echo "<S";
echo "TYLE TYPE=\"text/css\">
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
<body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#0066FF\" vlink=\"#666666\" alink=\"#000066\" leftmargin=\"0\" topmargin=\"0\" margin";
echo "width=\"0\" marginheight=\"0\">
<div class=admintitle>Edit User: "; echo $nick; echo "</div>
<table width=\"50%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=margin-top:10px>
  <tr> 
    <td align=\"center\" valign=\"middle\">
      <table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" BGCOLOR=\"#3399CC\" align=\"center\">
        <tr>
          <td align=center colspan=5><table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" BGCOLOR=\"#3399CC\" align=\"center\">";
echo "
              <tr>
                <td><table width=\"100%\" border=\"0\" cellpadding=\"4\" align=\"center\" cellspacing=\"0\">
              ";
if (!$ERR || $updated)
{
	print "<TR BGCOLOR=#ffffff><TD></TD><TD WIDTH=486>";
	if (${$ERR})
	{
		print ${$ERR};
	}
	if ($updated)
	{
		print "Users data updated";
	}
	print "</TD>
                </TR>";
}
echo "            <form name=details action=\"edituser.php\" method=\"POST\">
              <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle> ";
print '' . $MSG_302 . "";
echo " </td>
                <td width=\"486\"><input type=text name=name size=40 maxlength=255 class=adminfield value=\"";
print $username;
echo "\">
                </td>
              </tr>
              <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle> ";
print '' . $MSG_003 . "";
echo " </td>
                <td width=\"486\"> <b> ";
echo $nick;
echo " </b> ";
			if ($connected == facebook)
			{
				print '' . $MSG_connected_1;
			}
			else
			{
				print '' . $MSG_connected_0;
			}
			print "</td>
              </tr>
              <tr>
                <td width=\"204\" valign=\"middle\" bgcolor=\"#F4F4F4\" >&nbsp;</td>
                <td width=\"486\" bgcolor=\"#F4F4F4\">Enter both to change,  otherwise leave blank.</td>
              </tr>
              <tr>
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle bgcolor=\"#F4F4F4\"> ";
print '' . " " . $MSG_004 . "";
echo " </td>
                <td width=\"486\" bgcolor=\"#F4F4F4\"><input type=text name=password size=20 maxlength=20 class=adminfield>
                </td>
              </tr>
              <tr>
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle bgcolor=\"#F4F4F4\"> ";
print '' . " " . $MSG_004 . "";
echo " </td>
                <td width=\"486\" bgcolor=\"#F4F4F4\"><input type=text name=repeat_password size=20 maxlength=20 class=adminfield>
                </td>
              </tr>
              <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\"  valign=\"middle\" align=\"right\" class=edittitle> ";
print '' . $MSG_303 . "";
echo " </td>
                <td width=\"486\"><input type=text name=email size=40 maxlength=50 class=adminfield value=\"";
echo $email;
echo "\">
                </td>
              </tr>
              <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle> ";
print '' . $MSG_009 . "";
echo " </td>
                <td width=\"486\"><input type=text name=address size=40 maxlength=255 class=adminfield value=\"";
echo $address;
echo "\">
                </td>
              </tr>
              <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle> ";
print '' . $MSG_010 . "";
echo " </td>
                <td width=\"486\"><input type=text name=city size=40 maxlength=255 class=adminfield value=\"";
echo $city;
echo "\">
                </td>
              </tr>
              <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle> ";
print '' . $MSG_012 . "";
echo " </td>
                <td width=\"486\"><input type=text name=zip size=15 maxlength=15 class=adminfield value=\"";
echo $zip;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle> ";
print '' . $MSG_013 . "";
echo " </td>
                <td width=\"486\"><input type=text name=phone size=15 maxlength=15 class=adminfield value=\"";
echo $phone;
echo "\"><div style=\"margin-top: 9px;margin-left: 2px;display: inline-block;width: 17px;position: absolute;\">
";
			if ($verified == 1)
			{
				print '' . $MSG_verified_1;
			}
			if ($verified == 0)
			{
				print '' . $MSG_verified_0;
			}
			print "
			</div>
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Verified</td>
                <td width=\"486\"><input type=text name=verified size=15 maxlength=15 class=adminfield value=\"";
echo $verified;
echo "\">
                </td>
              </tr>
              <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Suspended</td>
                <td width=\"486\" class=adminfield style=border:0>";
if ($suspended == 0)
{
	print '' . $MSG_029;
}
 else 
{
	print '' . $MSG_030;
}
echo "                </td>
              </tr>
              <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle> ";
print '' . $MSG_435;
echo " </td>
                <td width=\"486\" class=adminfield style=border:0>";
echo $balance;
echo "</td>
              </tr>
              <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Add Coins</td>
                <td width=\"486\"><input type=text name='credit' size=10 maxlength=5 class=adminfield value=\"\"></td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle><strong>Achievements</strong></td>
				<td>&nbsp;</td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Wins</td>
                <td width=\"486\"><input type=text name=a_wins size=1 maxlength=1 class=adminfield value=\"";
echo $a_wins;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Packs Bought</td>
                <td width=\"486\"><input type=text name=a_packs size=1 maxlength=1 class=adminfield value=\"";
echo $a_packs;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Feedback</td>
                <td width=\"486\"><input type=text name=a_feedback size=1 maxlength=1 class=adminfield value=\"";
echo $a_feedback;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Poser</td>
                <td width=\"486\"><input type=text name=a_poser size=1 maxlength=1 class=adminfield value=\"";
echo $a_poser;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Tweet</td>
                <td width=\"486\"><input type=text name=a_tweet size=1 maxlength=1 class=adminfield value=\"";
echo $a_tweet;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Facebook Share</td>
                <td width=\"486\"><input type=text name=a_faceb size=1 maxlength=1 class=adminfield value=\"";
echo $a_faceb;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>25 Coin Pack</td>
                <td width=\"486\"><input type=text name=a_25coins size=1 maxlength=1 class=adminfield value=\"";
echo $a_25coins;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>50 Coin Pack</td>
                <td width=\"486\"><input type=text name=a_50coins size=1 maxlength=1 class=adminfield value=\"";
echo $a_50coins;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>100 Coin Pack</td>
                <td width=\"486\"><input type=text name=a_100coins size=1 maxlength=1 class=adminfield value=\"";
echo $a_100coins;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>200 Coin Pack</td>
                <td width=\"486\"><input type=text name=a_200coins size=1 maxlength=1 class=adminfield value=\"";
echo $a_200coins;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Survey</td>
                <td width=\"486\"><input type=text name=a_survey size=1 maxlength=1 class=adminfield value=\"";
echo $a_survey;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>2 Coin Auction</td>
                <td width=\"486\"><input type=text name=a_2coin size=1 maxlength=1 class=adminfield value=\"";
echo $a_2coin;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>3 Coin Auction</td>
                <td width=\"486\"><input type=text name=a_3coin size=1 maxlength=1 class=adminfield value=\"";
echo $a_3coin;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>5 Coin Auction</td>
                <td width=\"486\"><input type=text name=a_5coin size=1 maxlength=1 class=adminfield value=\"";
echo $a_5coin;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Daylight Robbery</td>
                <td width=\"486\"><input type=text name=a_daylight size=1 maxlength=1 class=adminfield value=\"";
echo $a_daylight;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Bargain</td>
                <td width=\"486\"><input type=text name=a_bargain size=1 maxlength=1 class=adminfield value=\"";
echo $a_bargain;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Lightning</td>
                <td width=\"486\"><input type=text name=a_lightning size=1 maxlength=1 class=adminfield value=\"";
echo $a_lightning;
echo "\">
                </td>
              </tr>
			  <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\" valign=\"middle\" align=\"right\" class=edittitle>Bids Placed</td>
                <td width=\"486\"><input type=text name=a33 size=1 maxlength=1 class=adminfield value=\"";
echo $a33;
echo "\">
                </td>
              </tr>
              <tr bgcolor=\"#FFFFFF\">
                <td width=\"204\">&nbsp;</td>
                <td width=\"486\">
       ";
echo "           <input TYPE=\"submit\" NAME=\"act\" class=\"buttonadminblue\" value=\"";
print $MSG_089;
echo "\">
                </td>
              </tr>
              <input type=\"hidden\" name=\"userid\" value=\"";
echo $_GET[userid];
echo "\">
              <input type=\"hidden\" name=\"offset\" value=\"";
echo $_GET[offset];
echo "\">
             <input type=\"hidden\" name=\"idhidden\" value=\"";
echo $_GET["userid"] ? $_GET["userid"] : $_POST["idhidden"];
echo "\">
             <input type=\"hidden\" name=\"action\" value=\"update\">
            </form>
          </table></TD>
      </TR>
    </TABLE>
    </TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>";
