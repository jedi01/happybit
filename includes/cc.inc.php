<?
if(!defined('INCLUDED')) exit("Access denied");


   function ValidateCC($CardNumber)
   {
      #
      $LEFT = substr($CardNumber, 0, 4);
      $RIGHT = substr($CardNumber, -4);
      $LENGTH = strlen($CardNumber);

      #
      if ($LEFT >= 3000 and $LEFT <= 3059)
	  {
         $ShouldLength = 14;
      }
	  elseif ($LEFT >= 3600 and $LEFT <= 3699)
	  {
         $ShouldLength = 14;
      }
	  elseif ($LEFT >= 3800 and $LEFT <= 3889)
	  {
         $ShouldLength = 14;

      }
	  elseif ($LEFT >= 3400 and $LEFT <= 3499)
	  {
         $ShouldLength = 15;
      }
	  elseif ($LEFT >= 3700 and $LEFT <= 3799)
	  {
         $ShouldLength = 15;

      }
	  elseif ($LEFT >= 3528 and $LEFT <= 3589)
	  {
         $ShouldLength = 16;

      }
	  elseif ($LEFT >= 3890 and $LEFT <= 3899)
	  {
         $ShouldLength = 14;

      }
	  elseif ($LEFT >= 4000 and $LEFT <= 4999)
	  {
         if ($LENGTH > 14)
		 {
            $ShouldLength = 16;
         }
		 elseif ($LENGTH < 14)
		 {
            $ShouldLength = 13;
         }
		 else
		 {
	         return "ERR_5011";
         }

      }
	  elseif ($LEFT >= 5100 and $LEFT <= 5599)
	  {
         $ShouldLength = 16;

      }
	  elseif ($LEFT == 5610)
	  {
         $ShouldLength = 16;

      }
	  elseif ($LEFT == 6011)
	  {
         $ShouldLength = 16;

      }
	  else
	  {
         return "ERR_5011";
      }


      #  Is the length correct?
      if ($LENGTH <> $ShouldLength)
	  {
         return "ERR_5011";
      }

      #  Start the Mod10 checksum process...
      $CHK = 0;

      #  Add even digits in even length strings
      #  or odd digits in odd length strings.
      for ($Location = 1 - ($LENGTH % 2); $Location < $LENGTH; $Location += 2)
	  {
         $CHK += substr($CardNumber, $Location, 1);
      }

      #  Analyze odd digits in even length strings
      #  or even digits in odd length strings.
      for ($Location = ($LENGTH % 2); $Location < $LENGTH; $Location += 2)
	  {
         $Digit = substr($CardNumber, $Location, 1) * 2;
         if ($Digit < 10)
		 {
            $CHK += $Digit;
         }
		 else
		 {
            $CHK += $Digit - 9;
         }
      }

      #  If the checksum is divisible by 10, the number passes.
      if ($CHK % 10 == 0)
	  {
         return FALSE;
      }
	  else
	  {
         return "ERR_5011";
      }
   }

?>