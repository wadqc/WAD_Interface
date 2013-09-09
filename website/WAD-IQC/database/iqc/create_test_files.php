<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



$table_test_file='test_file';

$test_file_Stmt = "SELECT * from $table_test_file 
order by $table_test_file.omschrijving, $table_test_file.filenaam";

// Connect to the Database
if (!($link=@mysql_pconnect($hostName, $userName, $password))) {
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

if (!($result_test_file= mysql_query($test_file_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


$table_test_file='';
 
$j=0;
while (($field_test_file = mysql_fetch_object($result_test_file)))
{
 
$b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }   

   $table_data = new Smarty_NM();
   
   if ($j==0) //define header data
   {
     $table_test_file=$table_data->fetch("file_select_header.tpl");
   }
   $action=sprintf("new_test_file.php?pk=%d&t=%d",$field_test_file->pk,time());
   $checkbox_name=sprintf("test_file[%d]",$field_test_file->pk);
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("omschrijving",$field_test_file->omschrijving);
   $table_data->assign("filenaam",$field_test_file->filenaam);
   $table_data->assign("action",$action);
      
   $table_test_file.=$table_data->fetch("file_select_row.tpl");

   $j++;
}


mysql_free_result($result_test_file);  

$data = new Smarty_NM();
$data->assign("Title","Test files");
$data->assign("header","Test files");
$data->assign("form_action",sprintf("new_test_file.php?pk=-1&t=%d",time() ) );
$data->assign("file_list",$table_test_file);

$new_test_file=sprintf("<a href=\"new_test_file.php?pk=0&t=%d\">Add new test_file</a>",time());

$data->assign("new_file",$new_test_file);

$data->display("file_select.tpl");
 

?>
