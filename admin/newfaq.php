<?

require('../includes/config.inc.php');
include "loggedin.inc.php";

#//Default for error message (blank)
$ERR = "&nbsp;";

#// Insert new message
if($_POST[action] == "update" && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF'])){
	if(strlen($_POST[question]) == 0 && strlen($_POST[answer]) == 0){
		$ERR = "Required fields missing (all fields are required).";
		$settings = $_POST;
	}else{
		$query = "INSERT into HB_faqs values(NULL,
			   '".addslashes($_POST['question'][$SETTINGS['defaultlanguage']])."',
			   '".addslashes($_POST['answer'][$SETTINGS['defaultlanguage']])."',
			   $_POST[category])";
		$res = @mysql_query($query);
		if(!$res){
			print "Error: $query<BR>".mysql_error();
			exit;
		}else{
			$id=mysql_insert_id();
			#// Insert into translation table.
			reset($LANGUAGES);
			while(list($k,$v) = each($LANGUAGES)){
				$query = "INSERT INTO HB_faqs_translated VALUES(
						$id,
						'$k',
						'".addslashes($_POST['question'][$k])."',
						'".addslashes($_POST['answer'][$k])."')";
				$res = @mysql_query($query);
			}
			Header("Location: faqs.php");
			exit;
		}
	}
}

if($_POST[action] != "update")
{
	#// Get data from the database
	$query = "select * from HB_faqscategories";
	$res_c = @mysql_query($query);
	if(!$res_c)
	{
		print "Error: $query<BR>".mysql_error();
		exit;
	}
}

?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<script type="text/javascript" src="scripts/wysiwyg.js" ></script>
<script type="text/javascript">
function updateTextAreas()
{
  updateTextArea('answer[<?=$SETTINGS['defaultlanguage']?>]');
  <?php
      reset($LANGUAGES);
      while(list($k,$v) = each($LANGUAGES)){
        if($k!=$SETTINGS['defaultlanguage']) print "updateTextArea('answer[$k]');";
      }
  ?>
}
</script>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr> 
          <td width="30"><img src="images/i_con.gif" ></td>
          <td class=white><?=$MSG_25_0018?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_5231?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
    <tr> 
    <td align="center" valign="middle"><FORM NAME="faq" METHOD="post" ACTION="<?=basename($_SERVER['PHP_SELF'])?>">
	<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" ALIGN="CENTER" BGCOLOR="#546f95">
		<TR align=center>
			<TD BGCOLOR=#ffffff>&nbsp;</TD>
		</TR>
		<TR>
			<TD>
				<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="4" ALIGN="CENTER">
					<TR>
						<TD COLSPAN="2" BGCOLOR="#546f95" align=center class=title>
							<?=$MSG_5231?>
						</TD>
					</TR>
					<TR BGCOLOR="#FFFFFF">
						<TD WIDTH="23%" CLASS=link HEIGHT="27" VALIGN="top">
							<?=$MSG_5238?> </TD>
						<TD WIDTH="77%" CLASS=link HEIGHT="27">
						<SELECT NAME="category">
							<?
							while($row = mysql_fetch_array($res_c))
							{
								$row[category]=stripslashes($row[category]);
								print "<OPTION VALUE=\"$row[id]\"";
								if($_POST[category] == $row[category]) print " SELECTED";
								print ">$row[category]</OPTION>\n";
							}
						?>
						</SELECT>
						</TD>
					</TR>
					<TR BGCOLOR="#FFFFFF">
						<TD WIDTH="23%" CLASS=link HEIGHT="27" VALIGN="top">
						<?=$MSG_5239?></TD>
						<TD WIDTH="77%" CLASS=link HEIGHT="27">
							<IMG SRC="../includes/flags/<?=$SETTINGS['defaultlanguage']?>.gif">&nbsp;<INPUT TYPE="text" NAME="question[<?=$SETTINGS['defaultlanguage']?>]" SIZE="35" MAXLENGTH="200">
							<?
								reset($LANGUAGES);
								while(list($k,$v) = each($LANGUAGES)){
									if($k!=$SETTINGS['defaultlanguage']) print "<BR><IMG SRC=../includes/flags/".$k.".gif>&nbsp;<INPUT TYPE=text NAME=question[$k] SIZE=35 MAXLENGTH=200>";
								}
							?>
						</TD>
					</TR>
					<TR BGCOLOR="#FFFFFF">
						<TD WIDTH="23%" CLASS=link HEIGHT="27" VALIGN="top">
						<?=$MSG_5240?></TD>
						<TD WIDTH="77%" CLASS=link HEIGHT="27">
							<IMG SRC="../includes/flags/<?=$SETTINGS['defaultlanguage']?>.gif"><BR /><TEXTAREA NAME="answer[<?=$SETTINGS['defaultlanguage']?>]" COLS="40" ROWS="15"></TEXTAREA><script>generate_wysiwyg('answer[<?=$SETTINGS['defaultlanguage']?>]');</script>
							<?
								reset($LANGUAGES);
								while(list($k,$v) = each($LANGUAGES)){
									if($k!=$SETTINGS['defaultlanguage']) print "<BR><IMG SRC=../includes/flags/".$k.".gif><BR /><TEXTAREA NAME=answer[$k] COLS=40 ROWS=15></TEXTAREA><script>generate_wysiwyg('answer[$k]');</script>";
								}
							?>
						</TD>
					</TR>
					<TR>
						<TD WIDTH="23%" BGCOLOR="#FFFFFF">
							<INPUT TYPE="hidden" NAME="action" VALUE="update">
						</TD>
						<TD WIDTH="77%" BGCOLOR="#FFFFFF">
							<INPUT TYPE="submit" NAME="Submit" VALUE="INSERT FAQ" onclick="updateTextAreas();">
						</TD>
					</TR>
				</TABLE>
			</TD>
		</TR>
	</TABLE>
</FORM>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>