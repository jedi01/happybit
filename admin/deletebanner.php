<?
require('../includes/config.inc.php');
include "loggedin.inc.php";


@mysql_query("DELETE FROM HB_banners WHERE id=$banner");
@mysql_query("DELETE FROM HB_bannerscategories WHERE banner=$banner");
@mysql_query("DELETE FROM HB_bannerskeywords WHERE banner=$banner");

@unlink("$image_upload_path"."banners/$user/$name");

#// Redirect
Header("Location: userbanners.php?id=$user");
?>