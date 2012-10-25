<?php

require("../globals.php") ;
require("../iqc/common.php") ;
require("../../database/iqc/php/includes/setup.php");



$top_menu=$_GET['top_menu'];
$bottom_menu='';
if (!empty($_GET['bottom_menu']))
{
  $bottom_menu=$_GET['bottom_menu'];
}
$selected_top=100; //overflow number
if (!empty($_GET['selected_top']))
{
  $selected_top=$_GET['selected_top'];
}
$selected_bottom=100; //overflow number
if (!empty($_GET['selected_bottom']))
{
  $selected_bottom=$_GET['selected_bottom'];
}


if (!empty($_GET['bottom_frame']))
{
  $bottom_frame=$_GET['bottom_frame'];
}


$bottom_frame=$_GET['bottom_frame'];

$start_page = new Smarty_NM();
$top_frame=sprintf("../iqc/menu_row.php?top_menu=$top_menu&bottom_menu=$bottom_menu&selected_top=$selected_top&selected_bottom=$selected_bottom&t=%d",time());


$start_page->assign("top_frame",$top_frame);
$start_page->assign("bottom_frame",$bottom_frame);

$start_page->display("start_page.tpl");

?>
