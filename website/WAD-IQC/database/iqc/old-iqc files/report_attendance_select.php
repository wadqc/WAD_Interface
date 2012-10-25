<?php

require("../globals.php") ;
require("./common.php") ;
require("././php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$v=$_GET['v'];

$day_list='';
$i=1;
while ($i<32)
{
  $day_list["$i"]="$i";
  $i++;
}  
$data = new Smarty_NM();
$date_stamp=time();
$current_month=sprintf("%s",date("m",$date_stamp));

$data->assign("month_options",$month); 
$data->assign("month_id",$current_month); 
$data->assign("day_options",$day_list); 
$data->assign("day_id","20"); 

$credit_action=sprintf("report_selection_attendance.php?school_year=$school_year&school=$school&v=$v&t=%d",time());


$data->assign("credit_action",$credit_action);
$data->assign("header",sprintf("%s %s",$school,$school_year));
$data->display("credit_term_report_attendance.tpl");

?>
