<?php


include "../includes/config.inc.php";
include "loggedin.inc.php";
unset($HAPPYBID_ADMIN_LOGIN);
unset($HAPPYBID_ADMIN_USER);
unset($_SESSION["HAPPYBID_ADMIN_LOGIN"]);
unset($_SESSION["HAPPYBID_ADMIN_USER"]);
echo "<S";
echo "CRIPT Language=Javascript>
parent.location.href='admin2.php';
</SCRIPT>
";
