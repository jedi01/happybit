<?php

if (empty($_SESSION["HAPPYBID_ADMIN_LOGIN"])) {
	header("Location: login.php");
	exit();
}

