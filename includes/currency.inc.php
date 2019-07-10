<?#//v.3.0.0
if(!defined('INCLUDED')) exit("Access denied");

// Paypal currencies  - are the currencies accepted by Paypal
$PaypalCurrencies = array('USD' => 'United States Dollar','AUD' => 'Australian Dollars','GBP' => 'Great Britain Pound','JPY' => 'Japanese Yen','CAD' => 'Canadian Dollar','EUR' => 'Euro');
 
// You can modify currency symbol position by modifying the function 
// You may also modify the decimal markers by changeing number_format
// See the php manual for more information on number_format()

if($SETTINGS[moneyformat] == 1) // USA style format
{
	if(!function_exists(print_money))
	{
		function print_money($str)
		{
			global $SETTINGS;
			if ($SETTINGS[currency]=="USD") $SETTINGS[currency]="$";
			if ($SETTINGS[currency]=="EUR") $SETTINGS[currency]="&euro;";
			
			
			if($SETTINGS[moneysymbol] == "2") // Symbol on the right
			{
				return number_format($str,$SETTINGS[moneydecimals],".",",") . " " . $SETTINGS[currency];
			}
			elseif($SETTINGS[moneysymbol] == "1") // Symbol on the left
			{
				return $SETTINGS[currency] . "" . number_format($str,$SETTINGS[moneydecimals],".",",");
			}
		}
	}
	
	if(!function_exists(print_money_nosymbol))
	{
		function print_money_nosymbol($str)
		{
			global $SETTINGS;
			if($SETTINGS[moneysymbol] == "2") // Symbol on the right
			{
				return number_format($str,$SETTINGS[moneydecimals],".",",");
			}
			elseif($SETTINGS[moneysymbol] == "1") // Symbol on the left
			{
				return number_format($str,$SETTINGS[moneydecimals],".",",");
			}
		}
	}
}
elseif($SETTINGS[moneyformat] == 2) //EUROPE like style
{
	if(!function_exists(print_money))
	{
		function print_money($str)
		{
			global $SETTINGS;
			if ($SETTINGS[currency]=="USD") $SETTINGS[currency]="$";
			if ($SETTINGS[currency]=="EUR") $SETTINGS[currency]="&euro;";
			if($SETTINGS[moneysymbol] == "2") // Symbol on the right
			{
				return number_format($str,$SETTINGS[moneydecimals],",",".") . " " . $SETTINGS[currency];
			}
			elseif($SETTINGS[moneysymbol] == "1") // Symbol on the keft
			{
				return $SETTINGS[currency] . "" . number_format($str,$SETTINGS[moneydecimals],",",".");
			}
		}
	}

	if(!function_exists(print_money_nosymbol))
	{
		function print_money_nosymbol($str)
		{
			global $SETTINGS;
			if($SETTINGS[moneysymbol] == "2") // Symbol on the right
			{
				return number_format($str,$SETTINGS[moneydecimals],",",".");
			}
			elseif($SETTINGS[moneysymbol] == "1") // Symbol on the keft
			{
				return number_format($str,$SETTINGS[moneydecimals],",",".");
			}
		}
	}
}


// when dealing with money, we really dont ever want fancy formating, so 
// we remove it from any input value. You need to make sure this works 
// with however you have formatted print money above.

if(!function_exists(input_money))
{
	Function input_money($str)
	{
		global $SETTINGS;
	
		if($SETTINGS[moneyformat] == 1) //USA format
		{
			#// Drop thousands separator
			$str = ereg_replace(",","",$str);
		}
		elseif($SETTINGS[moneyformat] == 2)
		{
			#// Drop thousands separator
			$str = ereg_replace("\.","",$str);
			
			#// Change decimals separator
			$str = ereg_replace(",",".",$str);
		}
		
		return $str;
	}
}

if(!function_exists(CheckMoney))
{
	Function CheckMoney($amount)
	{
		global $SETTINGS;
		
		if($SETTINGS[moneyformat] == 1) //USA format
		{
			#//
			if(!ereg("^([0-9]+|[0-9]{1,3}(,[0-9]{3})*)(\.[0-9]{0,3})?$",$amount))
			{
				return FALSE;
			}
		}
		elseif($SETTINGS[moneyformat] == 2)
		{
			#//
			if(!ereg("^([0-9]+|[0-9]{1,3}(\.[0-9]{3})*)(,[0-9]{0,3})?$",$amount))
			{
				return FALSE;
			}
			
		}
		
		return TRUE;
	}
}

?>