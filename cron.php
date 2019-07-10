<?


if(!isset($_SERVER['SCRIPT_NAME'])) $_SERVER['SCRIPT_NAME'] = 'cron.php';
include "./includes/config.inc.php";
include $include_path."auction_types.inc.php";
include $include_path."converter.inc.php";
include $include_path."dates.inc.php";

//$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
//$NOW = date("YmdHis",$TIME);
//$NOWB = date("Ymd",$TIME);
//$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
//$NOW = date("YmdHis",$TIME);
//$NOWB = date("Ymd",$TIME);

function MySendMail($mail_to, $user_name, $auc_title, $auction_id, $file){
	global $include_path;
	global $SETTINGS;
	global $TIME;
	$now = date("Y/m/d H:i:s",$TIME);
	$CHARSET = "iso-8859-1";	
	include_once($include_path.$file);	
}
	

function openLogFile () {
	global $logFileHandle, $logFileName;
	global $cronScriptHTMLOutput;

	$logFileHandle = @fopen ($logFileName, "a");
	if ($cronScriptHTMLOutput == true)
		print "<PRE>\n";
}

function closeLogFile () {
	global $logFileHandle;
	global $cronScriptHTMLOutput;

	if ($logFileHandle)
		fclose ($logFileHandle);
	if ($cronScriptHTMLOutput)
		print "</PRE>\n";
}

function printLog ($str) {
	global $logFileHandle;
	global $cronScriptHTMLOutput;

	if ($logFileHandle) {
		if (substr($str, strlen($str)-1, 1) != "\n") $str .= "\n";
		fwrite ($logFileHandle, $str);
		if ($cronScriptHTMLOutput) print "" . $str;
	}
}

function printLogL ($str, $level) {
	for($i = 1;$i <= $level;++$i)
		$str = "\t" . $str;
	printLog($str);
}

function errorLog ($str) {
	global $logFileHandle, $adminEmail;

	printLog ($str);
	/**
	* mail (
	* $adminEmail,
	* "An cron script error has occured",
	* $str,
	* "From: $adminEmail\n".
	* "Content-type: text/plain\n"
	* );
	*/
	closeLogFile();
	exit;
}

function errorLogSQL () {
	global $query;
	errorLog ("SQL query error: $query\n" . "Error: " . mysql_error());
}

function constructCategories() {
	$query = "SELECT cat_id, parent_id, sub_counter, counter
	         FROM HB_categories ORDER BY cat_id";
	$res = mysql_query($query);
	while ($row = mysql_fetch_array($res)) {
		$row['updated']=false;
		$categories[$row['cat_id']]=$row;
	}
	return $categories;
}

// initialize cron script
openLogFile();
printLog("=============== STARTING CRON SCRIPT: " . date("F d, Y H:i:s"));

//$categories=constructCategories();


//**************************************************
// check all auctions if there is a winner - and send him an email
//***************************************************
function check_winner($auction_id, $include_path)
{
	//echo $auction_id;
	global $NOW;
	global $SETTINGS;
	$winner_present = false;
	// Find minimum unique bid
	$check = "SELECT b.bid, b.bidder, u.nick, u.email, a.title, COUNT(b.bid) AS bid_count
			  FROM HB_bids b
			  INNER JOIN HB_users u ON b.bidder=u.id
			  INNER JOIN HB_auctions a ON b.auction=a.id
			  WHERE b.auction=".$auction_id." GROUP BY b.bid ORDER BY b.bid DESC ";		
	$check_result = mysql_query($check);
	if(!$check_result)return;
	$winner_bid = 0;
	$winner_bid_count = 0;
	$winner_id = 0;
	$winner_nick = "";
	$winner_email = "";
	$auc_title = "";
	
	if($check_row = mysql_fetch_array($check_result))
	{
		$winner_bid = $check_row['bid'];
		$winner_bid_count = $check_row['bid_count'];
		if($winner_bid_count == 1)
			$winner_id = $check_row['bidder'];
	}    		
	while($check_row = mysql_fetch_array($check_result))
	{
		if($check_row['bid_count']==1 && $check_row['bid']<$winner_bid)
		{        
			$winner_id = $check_row['bidder'];
			$winner_bid = $check_row['bid'];
			$winner_nick = $check_row['nick'];
			$winner_email = $check_row['email'];
			$auc_title = $check_row['title'];
		}
	}
	
	if($winner_id != 0)
	{
		$winner_present = true;
	}
	if ($winner_present)
	{
		// Add winner's data to "winners" table
		$query = "INSERT INTO HB_winners VALUES (NULL," . $auction_id . ",0," . $winner_id . "," . $winner_bid . ",'$NOW',0)";
		mysql_query($query);

		// Send email to winner - to notify him
		MySendMail($winner_email,$winner_nick,$auc_title,$auction_id,"mail_youarewinner.EN.inc.php");

		// Send email to admin
		MySendMail($SETTINGS['adminmail'],$winner_nick,$auc_title,$auction_id,"mail_thereiswinner.EN.inc.php");
	}
}

################################################################################
## Close Classic Auctions (1-st type)
################################################################################

$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
$NOW = date("YmdHis",$TIME);
$NOWB = date("Ymd",$TIME);

$query = "SELECT * FROM HB_auctions 
         WHERE closed='0' AND suspended=0";

printLog ($query);
$result = mysql_query($query);

if (!$result){
	errorLogSQL();
}else
{
	$num = mysql_num_rows($result);
	printLog($num . " auctions to close");	
	$resultAUCTIONS = $result;
	while ($row = mysql_fetch_array($resultAUCTIONS)) {
		// Check if there is a winner when closing the auction
		
		$sql="SELECT COUNT(*) AS count_bids FROM HB_bids WHERE auction='".$row['id']."'";
		$result_bids_count=mysql_query($sql);
		$row_bids=mysql_fetch_array($result_bids_count);
		
		if ($row_bids['count_bids']>=$row['number_of_bids']) {
			check_winner($row['id'], $include_path);
			$query = "UPDATE HB_auctions SET closed='1' WHERE id=".$row['id']." ";
			if (!mysql_query($query)) errorLogSQL();
			printLogL($query, 1);
		}
	}	
}

##################################################################################
/*
* Purging thumbnails cache and not more used images
*/
if(!file_exists($image_upload_path."cache"))
	mkdir($image_upload_path."cache",0777);
if(!file_exists($image_upload_path."cache/purge"))
	@touch($image_upload_path."cache/purge");	
$purggecachetime=filectime($image_upload_path."cache/purge");
if((time()-$purgecachetime)>86400) {
	$dir=$image_upload_path."cache";
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if($file!="purge" && !is_dir("$dir/$file") && (time()-filectime("$dir/$file"))>86400)
				unlink("$dir/$file");
		}
		closedir($dh);
	}

	// starting all site images purge
	$imgarray[]=$SETTINGS['logo'];
	$imgarray[]=$SETTINGS['background'];
	$result = mysql_query("SELECT pict_url from HB_auctions where photo_uploaded='1'");
	while($row=mysql_fetch_array($result, MYSQL_NUM))
		$imgarray[]=$row[0];
	$result = mysql_query("SELECT id from HB_auctions");
	$imgdir=array();
	while($row=mysql_fetch_array($result, MYSQL_NUM)) {
		if(is_dir($uploaded_path.$row[0]))
			$imgdir[]=$row[0];
	}

	// Ordinary images purge
	$dir=$image_upload_path;
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if($file!="purge" &&
			        !is_dir($dir.$file) &&
			        (time()-filectime($dir.$file))>86400 &&
			        !in_array($file,$imgarray))
				unlink($dir.$file);
		}
		closedir($dh);
	}

	//galleries dirs and files purge
	if (is_array($imgdir) && ($dh = opendir($dir))) {
		while (($file = readdir($dh)) !== false) {
			if($file!="banners" &&
			        $file!=".." &&
			        $file!="." &&
			        $file!="CVS" &&
			        is_dir("$dir.$file") &&
			        (time()-filectime($dir.$file))>86400 &&
			        !in_array($file,$imgdir))
				$ddel=$dir.$file;
			if ($ddh = @opendir($ddel)) {
				while (($fdel = readdir($ddh)) !== false) {
					if(!is_dir("$ddel/$fdel"))
						unlink("$ddel/$fdel");
				}
				closedir($ddh);
				rmdir($ddel);
			}
		}
		closedir($dh);
	}

	//Banners purge
	$result = mysql_query("SELECT name from HB_banners");
	while($row=mysql_fetch_array($result, MYSQL_NUM)) {
		$imgarray[]="banners/".$result[0];
	}
	$dir=$image_upload_path."banners/";
	if(is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if($file!="purge" &&
				        !is_dir($dir.$file) &&
				        (time()-filectime($dir.$file))>86400 &&
				        !in_array("banners/".$file,$imgarray))
					unlink($dir.$file);
			}
			closedir($dh);
		}
	}
	@@touch($image_upload_path."cache/purge");
}

// // Update counters
include $include_path."updatecounters.inc.php";

// finish cron script
printLog ("=========================== ENDING CRON: ". date("F d, Y H:i:s"));
closeLogFile();

?>