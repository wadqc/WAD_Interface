<?php 

//require("../globals.php") ;
//require("./common.php") ;
require("./menu_structure.php") ;
//require("./php/includes/setup.php");

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));

$menu=$_GET['menu'];
$top=$_GET['top'];
$top_menu=$_GET['top_menu'];
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

$button_row=sprintf("<table><tr>");


$level_ref_key=array_keys($level[$menu]);

$button = new Smarty_NM();

$i=0;
while ($i<sizeof($level_ref_key)) // loop sub_levels
{
  $button = new Smarty_NM();
  if ($top==1) //top buttons
  {  
    $button->assign("top_menu",$top_menu);
    $button->assign("bottom_menu",$level_ref_key[$i]);