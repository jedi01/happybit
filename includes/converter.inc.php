<?
if(!defined('INCLUDED')) exit("Access denied");

include($include_path."nusoap.php");

Function CurrenciesList() {
	if(!isset($_SESSION["curlist"])) {
		$s = new soapclientt("http://webservices.lb.lt/ExchangeRates/ExchangeRates.asmx/getListOfCurrencies");
		$result= $s->call('getListOfCurrencies',array(),'','http://webservices.lb.lt/ExchangeRates/getListOfCurrencies');
		$parser = xml_parser_create();
		xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
		xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
		xml_parse_into_struct($parser,$s->responseData,$values,$tags);
		xml_parser_free($parser);
		$CURRENCIES=array();
		foreach($values as $k=>$v) {
			if($v["tag"]=="currency") $cur=$v["value"];
			if($v["tag"]=="description" && $v["attributes"]["lang"]=='en') {
				$CURRENCIES[$cur]=$v["value"];
			}
		}
		$_SESSION["curlist"]=$CURRENCIES;
	} else {
		$CURRENCIES=$_SESSION["curlist"];
	}
	return $CURRENCIES;
}

Function ConvertCurrency($FROM,$INTO,$AMOUNT) {
	global $prefix;
	$params1 = array(
	'FromCurrency' 		=> $FROM,
	'ToCurrency' 		=> $INTO
	);
	if($FROM==$INTO) return $AMOUNT;
	$sclient 		= new soapclientt($include_path."includes/CurrencyConverter.wdsl","wsdl");
	$p				= $sclient->getProxy();
	$ratio			= $p->ConversionRate($params1);
	
	$VAL 	= doubleval($AMOUNT);
	return $VAL*$ratio;
}

Function oldConvertCurrency($FROM,$INTO,$AMOUNT)
{
	$query = "SELECT * FROM HB_rates WHERE symbol='$FROM'";
	$R 		= mysql_query($query);
	if(!$R)
	{
		print "Error: $query<BR>".mysql_error();
		exit;
	}
	$F_RATE	= mysql_fetch_array($R);
	
	$query = "SELECT * FROM HB_rates WHERE symbol='$INTO'";
	$R_ 	= mysql_query($query);
	if(!$R_)
	{
		print "Error: $query<BR>".mysql_error();
		exit;
	}
	$I_RATE	= mysql_fetch_array($R_);
	
	$VAL 	= doubleval($AMOUNT);
	return $VAL/$F_RATE[rate]*$I_RATE[rate];
}


function UpdateRates()
{
	return; // every conversion will be made online!
	global $PHP_SELF;
	$interval = 1440; // Minutes in 1 day
	
	$res = @mysql_query("select *,NOW()-(last_update) as dif from HB_lastupdate;");
	$ar = @mysql_fetch_array($res);
	$mydif = (int)($ar[dif]/60) - $interval;
	if($mydif>0)
	{
		$fp = fopen("http://www.bankofcanada.ca/fmd/exchange.htm","r");
		$x=0;$g=0;
		while(!feof($fp))
		{
			$buf = fgets($fp, 4096);
			if(eregi("U.S. Dollar",$buf)) $x=4;
			if(eregi("</PRE>",$buf)) $x=0;
			if($x==4)
			{
				if(!eregi("US/CA",$buf))
				{
					$ime = explode("/",$buf);
					$s = explode(" ",$ime[1]);
					$r = array_reverse ($s);
					
					if(eregi("Euro de",$buf))
					{
						$ime[0]="European Monetary Union EURO";
						$s = explode(" ",$buf);
						$r = array_reverse ($s);
					}
					
					if($ime[0]<>"" and $r[0]<>"")
					{
						$g++;
						if(eregi("U.S. Dollar",$buf)) {$koef = (float)$r[0];}
						$k = ((float)$r[0]/(float)$koef);
						$usd = 1/$k;
						$res = mysql_query("SELECT * FROM HB_rates WHERE sifra=\"$ime[0]\"") or exit("ERROR 42:".mysql_error());
						$num = mysql_num_rows($res);
						if($num == 0)
						{
							mysql_query("INSERT INTO HB_rates VALUES(
		 			NULL,
		 			\"$ime[0]\",
					'',
					$usd,
					\"$ime[0]\")");
						}
						else
						mysql_query("UPDATE HB_rates SET rate='$usd' WHERE sifra=\"$ime[0]\"");
					}
					if(eregi("Venezuelan Bolivar",$buf)) $x=0;
				}
			}
		}
		fclose($fp);
		mysql_query("UPDATE HB_lastupdate SET last_update=NOW();");
	}
}
?>
