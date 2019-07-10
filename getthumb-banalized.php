<?#//v.3.0.0
function ErrorPNG($err)
{
	$im  = @imagecreate(100, 30); /* Create a blank image */
	$bgc = @imagecolorallocate($im, 255, 255, 255);
	$tc  = @imagecolorallocate($im, 0, 0, 0);
	@imagefilledrectangle($im, 0, 0, 100, 30, $bgc);
	/* Output an errmsg */
	@imagestring($im, 1, 5, 5, $err, $tc);
	return $im;
}
if(isset($_GET['fromfile']))	$_GET['fromfile'] = str_replace('..', '', $_GET['fromfile'] );
// control parameters and file existence
if(!isset($_GET['fromfile'])) {
	header("Content-type: image/png");
	echo @imagepng(@ErrorPNG("params empty"));
	exit;
} elseif (!file_exists($_GET['fromfile']))  {
	header("Content-type: image/png");
	echo @imagepng(@ErrorPNG("img doesn't exist"));
	exit;
}
// try to see if it already exists a cached thumbnail
$img=@getimagesize("./".$fromfile);									//	getting image data
header("Content-type: ".$img['mime']);								//	type not manageable
echo join('',@file($fromfile));										//	render back the entire image requested
exit;
?>