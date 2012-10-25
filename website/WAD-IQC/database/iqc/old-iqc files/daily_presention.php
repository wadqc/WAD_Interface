<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];


$action=sprintf("daily_presention_add.php?school=$school&t=%d",time());
$data=new Smarty_NM();

$header=sprintf("Enter a student ID for student at school $school");
$data->assign("header",$header);
$data->assign("presention_daily_action",$action);
//$data->left_delimiter = '-L';
//$data->right_delimiter = '-R';
$data->display("presention_daily_select.tpl");

?>
