<?
if(!defined('INCLUDED')) exit("Access denied");

$NOW = date("YmdHis",mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y")));

#// Retrieve current counters
$query = "SELECT * FROM HB_counters";
$res = @mysql_query($query);
if(mysql_num_rows($res) > 0)
{
	$COUNTERS = mysql_fetch_array($res);
}

$query = "SELECT count(id) as COUNTER from HB_users WHERE suspended=0";
$res = @mysql_query($query);
$USERS = mysql_result($res,0,"COUNTER");

#// Update counters table
$query = "UPDATE HB_counters set users=$USERS";
$res_ = @mysql_query($query);


$query = "SELECT count(id) as COUNTER from HB_users WHERE suspended<>0";
$res = @mysql_query($query);
$USERS = mysql_result($res,0,"COUNTER");

#// Update counters table
$query = "UPDATE HB_counters set inactiveusers=$USERS";
$res_ = @mysql_query($query);


$query = "SELECT count(id) as COUNTER from HB_auctions WHERE closed=0 and suspended=0 AND private='n' AND starts<=".$NOW;
$res = @mysql_query($query);

$AUCTIONS = mysql_result($res,0,"COUNTER");

#// Update counters table
$query = "UPDATE HB_counters set auctions=$AUCTIONS";
$res_ = @mysql_query($query);


$query = "SELECT count(id) as COUNTER from HB_auctions WHERE closed<>0 AND private='n'";
$res = @mysql_query($query);
$AUCTIONS = mysql_result($res,0,"COUNTER");

#// Update counters table
$query = "UPDATE HB_counters set closedauctions=$AUCTIONS";
$res_ = @mysql_query($query);


$query = "SELECT count(id) as COUNTER from HB_auctions WHERE closed=0 and suspended<>0 AND private='n'";
$res = @mysql_query($query);
$AUCTIONS = mysql_result($res,0,"COUNTER");

#// Update counters table
$query = "UPDATE HB_counters set suspendedauction=$AUCTIONS";
$res_ = @mysql_query($query);

$query = "SELECT
		  a.id,
		  a.auction,
		  b.id
		  FROM
		  HB_bids a, HB_auctions b
		  WHERE
		  a.auction=b.id AND
		  b.closed=0 AND b.suspended=0 AND private='n'";
$res = @mysql_query($query);
$BIDS = mysql_num_rows($res);

#// Update counters table
$query = "UPDATE HB_counters set bids=$BIDS";
$res_ = @mysql_query($query);

@mysql_query("UPDATE HB_categories set counter=0, sub_counter=0");
$query = "SELECT cat_id, parent_id, sub_counter, counter FROM HB_categories ORDER BY cat_id";
$res = mysql_query($query);
while ($row = mysql_fetch_array($res)) {
	$row['updated']=false;
	$categories[$row['cat_id']]=$row;
}

$query = "SELECT category FROM HB_auctions WHERE closed=0 AND suspended=0 AND starts<=".$NOW." AND private='n'";
$res = @mysql_query($query);
while($row = mysql_fetch_array($res))
{
	$cat_id = $row["category"];
	$root_cat = $cat_id;
	do {
		// update counter for this category
		$categories[$cat_id]['sub_counter']++;
		if ($cat_id == $root_cat)
		++$categories[$cat_id]['counter'];
		$categories[$cat_id]['updated']=true;
		$cat_id = $categories[$cat_id]['parent_id'];
	} while ($cat_id != 0 && isset($categories[$cat_id]));
}
foreach($categories as $cat_id=>$category) {
	if($category['updated']) {
		$query = "UPDATE HB_categories SET
						counter=$category[counter],
						sub_counter=$category[sub_counter]
						WHERE cat_id=$cat_id";
		$res = mysql_query($query);
		$category['updated']=false;
	}
}
@mysql_query("UPDATE HB_categories set counter=0, sub_counter=0");
$query = "SELECT cat_id, parent_id, sub_counter, counter FROM HB_categories ORDER BY cat_id";
$res = mysql_query($query);
while ($row = mysql_fetch_array($res)) {
	$row['updated']=false;
	$categories[$row['cat_id']]=$row;
}
@mysql_query("UPDATE HB_categories set counter=0, sub_counter=0");
$query = "SELECT cat_id, parent_id, sub_counter, counter
			FROM HB_categories ORDER BY cat_id";
$res = mysql_query($query);
while ($row = mysql_fetch_array($res)) {
	$row['updated']=false;
	$categories[$row['cat_id']]=$row;
}
$query = "SELECT category FROM HB_auctions WHERE closed=0 AND suspended=0 AND starts<=".$NOW." AND private='n'";
$res = @mysql_query($query);
while($row = mysql_fetch_array($res))
{
	$cat_id = $row["category"];
	$root_cat = $cat_id;
	do {
		// update counter for this category
		$categories[$cat_id]['sub_counter']++;
		if ($cat_id == $root_cat)
		++$categories[$cat_id]['counter'];
		$categories[$cat_id]['updated']=true;
		$cat_id = $categories[$cat_id]['parent_id'];
	} while ($cat_id != 0 && isset($categories[$cat_id]));
}
foreach($categories as $cat_id=>$category) {
	if($category['updated']) {
		$query = "UPDATE HB_categories SET
						counter=$category[counter],
						sub_counter=$category[sub_counter]
						WHERE cat_id=$cat_id";
		$res = mysql_query($query);
		$category['updated']=false;
	}
}

?>