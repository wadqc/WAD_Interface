<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



$table_config_file='config_file';

$config_file_Stmt = "SELECT * from $table_config_file 
order by $table_config_file.omschrijving, $table_config_file.filenaam";

// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!($result_config_file= $link->query($config_file_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}


$table_config_file='';
 
$j=0;
while (($field_config_file = $result_config_file->fetch_object()))
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
     $table_config_file=$table_data->fetch("file_select_header.tpl");
   }
   $action=sprintf("new_config_file.php?pk=%d&t=%d",$field_config_file->pk,time());
   $checkbox_name=sprintf("config_file[%d]",$field_config_file->pk);
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("omschrijving",$field_config_file->omschrijving);
   $table_data->assign("filenaam",$field_config_file->filenaam);
   $table_data->assign("action",$action);
      
   $table_config_file.=$table_data->fetch("file_select_row.tpl");

   $j++;
}


$result_config_file->close();  

$data = new Smarty_NM();
$data->assign("Title","Config Files");
$data->assign("header","Config Files");
$data->assign("form_action",sprintf("new_config_file.php?pk=-1&t=%d",time() ) );
$data->assign("file_list",$table_config_file);

$new_config_file=sprintf("<a href=\"new_config_file.php?pk=0&t=%d\">Add new config_file</a>",time());

$data->assign("new_file",$new_config_file);

$data->display("file_select.tpl");
 

?>
