<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$start_string='';
$level='';
if (!empty($_GET['start_string']))
{
  $start_string=$_GET['start_string'];
}
if (!empty($_GET['level']))
{
  $level=$_GET['level'];
}



$menu=new Smarty_NM();
$start_string.=$menu->fetch(sprintf("%s",$level));



$top=new Smarty_NM();

$top->assign("user",$user);
$top->assign("frontpage_picture_src","./pictures/logo_site_open_school_100.jpg");
//$top->display("frontpage-top.tpl"); 
$top->assign("start_string",$start_string);
$top->display("frontpage_level_all.tpl"); 
?>












