<?php 

header("p3p: CP=\"IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT\""); 
session_start();

require("/home/happybid/public_html/machform/machform.php");

$mf_param['form_id'] = 12257;
$mf_param['base_path'] = 'http://happybid.co.uk/machform/';
$mf_param['show_border'] = true;
display_machform($mf_param);

?>