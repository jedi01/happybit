<?

#// ==============================================================
#// By default the expiration time is 900 seconds (15 minutes)
#// Change the value below if you need a different time interval
$DURATION = 900;
#// ==============================================================

#// You shouldn't edit the code below unless you know what you are doing

$s=session_id();
$uxtime=date("U");
$sqluni="SELECT * from HB_online where SESSION='$s'";
$res=@mysql_query($sqluni);
if(!$res) {
	$cretab="CREATE TABLE HB_online (
  				ID bigint(21) NOT NULL auto_increment,
  				SESSION varchar(255) NOT NULL default '',
  				time bigint(21) NOT NULL default '0',
  				PRIMARY KEY  (ID)
			)";
	@mysql_query($cretab);
}
$row=@mysql_fetch_array($res);
if(!$row) {
	$insess="INSERT into HB_online (SESSION, time) values('$s','$uxtime')";
	@mysql_query($insess);

} else {
	$updtime="update HB_online set time='$uxtime' where ID='$row[ID]'";
	@mysql_query($updtime);

}
$deltime=$uxtime-$DURATION;
$removeold="DELETE from HB_online where time<'$deltime'";
@mysql_query($removeold);
$sql="SELECT * from HB_online";
$res=@mysql_query($sql);
$count15min=@mysql_num_rows($res);

print "&nbsp;&nbsp;<B>".$count15min."</B>&nbsp;".$MGS_2__0064;
//print "There have been $count15min users in the last 15 minutes";

?>