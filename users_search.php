<?

include "includes/config.inc.php";
include $include_path."messages.inc.php";
#//
if($_POST[action] == "search" && strlen($_POST['searchkey']) >= 4) {

	$query = "SELECT id,name,nick,email FROM HB_users WHERE
				  (name like'%".addslashes($_POST[searchkey])."%' OR
				  email like'%".addslashes($_POST[searchkey])."%' OR
				  nick like'%".addslashes($_POST[searchkey])."%') AND
				  suspended=0 AND
				  id<>'$_SESSION[HAPPYBID_LOGGED_IN]'";
	$res_ = @mysql_query($query);
	if(!$res_) {
		print "Error: $query<BR>".mysql_error();
		exit;
	}
	$NUMUSERS = mysql_num_rows($res_);
	while($row = mysql_fetch_array($res_)) {
		$USERS[$row[id]] = $row[nick];
		$USERSNAME[$row[id]] = $row[name];
		$USERSEMAIL[$row[id]] = $row[email];
	}
}

?>
<Script language=javascript>
<!--
function PopulateField(VAL)
{
	window.opener.document.newuserform.newuser.value = VAL;
}
//-->
</SCRIPT>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='<?=phpa_include("style.css")?>' />
  <TITLE><?=$SETTINGS[sitename]?></TITLE>
</HEAD>
<BODY>
<form name=SEARCH action=<?=basename($_SERVER["PHP_SELF"])?> METHOD=POST>
  <TABLE WIDTH="100%" CELLSPACING="0" BORDER="0" CELLPADDING="4">
    <TR BGCOLOR="#eeeeee">
      <TD WIDTH="100%" bgcolor="#eeeeee">
        <?=$MSG_5182?>
        <input type="text" name="searchkey" size="15" />
		<BR><?=$MSG_30_0062?><BR>
        <input type="hidden" name="action" value="search" />
        <input type="submit" name="Submit" value="Search &gt;&gt;" />
      </TD>
      <TD align=right WIDTH="15%" bgcolor="#eeeeee">
        <a href="Javascript:window.close()">
        <?=$MSG_678?>
        </a></TD>
    </TR>
	<?
	if(isset($NUMUSERS))
	{
	?>
    <TR>
      <TD colspan="2"><?="$NUMUSERS $MSG_5183"?></TD>
    </TR>
	<?
	}

	if($NUMUSERS > 0)
	{
  	?>
    <TR ALIGN="center">
      <TD colspan="2">
        <TABLE WIDTH="100%" CELLSPACING="1" BORDER="0" CELLPADDING="2" bgcolor="#eeeeee">
          <TR BGCOLOR="#dddddd">
            <TD WIDTH="25%">
              <?=$MSG_293?>
            </TD>
            <TD WIDTH="30%">
              <?=$MSG_294?>
            </TD>
            <!--<TD WIDTH="35%">
              <?=$MSG_296?>
            </TD>-->
            <TD WIDTH="10%" align=center>
				<?=$MSG_5184?>
			</TD>
          </TR>
          <?
          while(list($k,$v) = each($USERS))
          {
		  ?>
          <TR bgcolor="#FFFFFF">
            <TD WIDTH="25%" valign="top"><?=$USERS[$k]?></TD>
            <TD WIDTH="30%" valign="top"><?=$USERSNAME[$k]?></TD>
            <!--<TD WIDTH="35%" valign="top"><?=$USERSEMAIL[$k]?>--></TD>
            <TD WIDTH="10%" align=center><A HREF="javascript:PopulateField('<?=$USERS[$k]?>');window.close();"><img BORDER=0 src="images/select.gif" width="14" height="14"></a></TD>
          </TR>
          <?
          }
		  ?>
        </TABLE>
      </TD>
    </TR>
    <?
	}
	?>
    <TR ALIGN="center">
      <TD colspan="2"><BR>
        <BR>
      </TD>
    </TR>
  </TABLE>
</FORM>
</BODY>
</HTML>
