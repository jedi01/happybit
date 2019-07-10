<?


	require('./includes/config.inc.php');
	include('header.php');

	#// Retrieve data from the database
	$query = "SELECT * FROM HB_aboutmeusers WHERE user=".intval($_GET['id']);
	$res = @mysql_query($query);
	if(!$res)
	{
		MySQLError($query);
		exit;
	}
	elseif(mysql_num_rows($res) > 0)
	{
		$ABOUTME = mysql_fetch_array($res);
	}
	else
	{
		print "Invalid id";
		exit;
	}

	#// Retrieve template HTML code
	$query = "SELECT code FROM HB_aboutmetemplates WHERE id=".intval($ABOUTME['template']);
	$res = @mysql_query($query);
	if(!$res)
	{
		MySQLError($query);
		exit;
	}
	elseif(mysql_num_rows($res) > 0)
	{
		$CODE = mysql_result($res,0,"code");
		$CODE = str_replace("{TITLE}",stripslashes($ABOUTME['pagetitle']),$CODE);
		$CODE = str_replace("{WELCOME}",stripslashes($ABOUTME['welcome']),$CODE);
		$CODE = str_replace("{WELCOMEMSG}",stripslashes($ABOUTME['welcomemsg']),$CODE);
		$CODE = str_replace("{PARAGRAPH}",stripslashes($ABOUTME['paragraph']),$CODE);
		$CODE = str_replace("{PARAGRAPHMGS}",stripslashes($ABOUTME['paragraphmsg']),$CODE);
		if ($ABOUTME['picture']!='')
			$CODE = str_replace("{PICTURE}","<IMG SRC=".$uploaded_path."aboutmepictures/".intval($_GET['id'])."/".$ABOUTME['picture'].">",$CODE);
		else
			$CODE = str_replace("{PICTURE}","<I>no picture</I></FONT>",$CODE);

		if($ABOUTME['auctions'] > 0)
		{
			$query = "SELECT title,id FROM HB_auctions WHERE closed=0 and user=".intval($_GET['id']). " ORDER BY starts ASC LIMIT ".$ABOUTME['auctions'];
			$res = mysql_query($query);
			if(!$res)
			{
				MySQLError($query);
				exit;
			}
			elseif(mysql_num_rows($res) > 0)
			{
				while($row = mysql_fetch_array($res))
				{
					$AUCTIONS .= "<A HREF=item.php?id=".$row['id'].">".stripslashes($row['title'])."</A><BR>";
				}
			}
			$CODE = str_replace("{YOURAUCTIONS}",$AUCTIONS,$CODE);
		}
		else
		{
			$CODE = str_replace("{YOURAUCTIONS}",'',$CODE);
		}
    print "<br><br>";
		print stripslashes($CODE);
    print "<br><br>";
	}
	include('footer.php');
?>
