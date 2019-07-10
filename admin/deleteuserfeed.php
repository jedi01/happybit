<?

require('../includes/config.inc.php');
include "loggedin.inc.php";
if ($id){
	$user = @mysql_result(@mysql_query("SELECT rated_user_id FROM HB_feedbacks WHERE id='$id'"),0,"rated_user_id");
	$sql="DELETE FROM HB_feedbacks WHERE id='".$id."'";
	$res=mysql_query ($sql);
	if (!$res){
?>
	<TABLE WIDTH="100%" BGCOLOR="#FFFFFF" BORDER=0 CELLPADDING="0" CELLSPACING="0">
	<TR>
	<TD>
	<BR>
	<CENTER>
	<BR>
	<? print $tlt_font; ?>
	<B><? print $MSG_207; ?></B>
	</FONT>
	<BR>
	
	<?
		echo $err_font.$ERR_066;
	?>
	</FONT>
<?
	} else {
		#// Update user's record
		$query = "SELECT SUM(rate) as FSUM,count(feedback) as FNUM FROM HB_feedbacks
				  WHERE rated_user_id='$user'";
		$res = mysql_query($query);
		if(!$res) {
			print "Error: $query<BR>".mysql_error();
			exit;
		} else {
			$SUM = mysql_result($res,0,"FSUM");
			$NUM = mysql_result($res,0,"FNUM");
			
			@mysql_query("UPDATE HB_users SET rate_sum=$SUM, rate_num=$NUM,reg_date=reg_date WHERE id='$user'");
		}
	}			
}
?>
<script language="JavaScript">
window.location="userfeedback.php?id=<?=$user?>";
</script>
