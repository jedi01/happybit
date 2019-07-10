<?
if(!defined('INCLUDED')) exit("Access denied");
	


	$HTMLTAGS = array("<B>",
				  "</B>",
				  "<I>",
				  "</I>",
				  "<U>",
				  "</U>",
				  "<STRONG>",
				  "</STRONG>",
				  "<UL>",
				  "<OL>",
				  "<LI>",
				  "</LI>",
				  "</LO>",
				  "</LU>",
				  "<H1>",
				  "</H1>",
				  "<H2>",
				  "</H2>",
				  "<H3>",
				  "</H3>",
				  "<H4>",
				  "</H4>",
				  "</H5>",
				  "<H5>",
				  "<H6>",
				  "</H6>",
				  "<FONT [a-z0-9=]*>",
				  "</FONT>",
				  "<P>",
				  "</P>");

	Function DropHtml($str)
	{
		global $HTMLTAGS;

		reset($HTMLTAGS);

		while(list($k,$v) = each($HTMLTAGS))
		{
			$repl = '';
			$str = eregi_replace($v,$repl,$str);
		}

		return strval($str);
	}






?>
