<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$table_resultaten_object='resultaten_object';



$v=$_GET['v'];
$pk=0;
if (!empty($_GET['pk']))
{
  $pk=$_GET['pk'];
}


$results_object_Stmt="SELECT  $table_resultaten_object.object_naam_pad as 'object_naam_pad', $table_resultaten_object.omschrijving as 'omschrijving' from  $table_resultaten_object
where $table_resultaten_object.pk=$pk";



// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",
                             $hostName, $userName)) ;
   exit();
}


// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


if (!($result_object= mysql_query($results_object_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $results_object_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}






$table_resultaten_object='';
$name_row='';
$picture_row='';

$field_results = mysql_fetch_object($result_object);

$picture = new Smarty_NM();
$description_name = new Smarty_NM();
 

$action_object=sprintf("show_results.php?resultaten_object.pk=%d&t=%d",$field_results->pk,time()); 

list($width, $height) = getimagesize($field_results->object_naam_pad);     
$picture_src=sprintf("image_resize.php?f_name=$field_results->object_naam_pad&height=%s",$height);
//$picture->assign("picture_src",$field_results->object_naam_pad);
$picture->assign("picture_src",$picture_src);

$picture->assign("picture_action",$action_object);
$picture_row.=$picture->fetch("insert_picture_row_object.tpl");
   

$description_name->assign("picture_name",$field_results->omschrijving);
$name_row.=$description_name->fetch("insert_picture_name_row_object.tpl");

$table_resultaten_object.=sprintf("<tr>%s</tr>",$picture_row);
$table_resultaten_object.=sprintf("<tr>%s</tr>",$name_row);


mysql_free_result($result_object); 




$data = new Smarty_NM();
$data->assign("Title","results Results");
$data->assign("header_result","Object file");
$data->assign("header_object","Resultaten Object");
$data->assign("resultaten_object_list",$table_resultaten_object);



$data->display("resultaten_result.tpl");





?>