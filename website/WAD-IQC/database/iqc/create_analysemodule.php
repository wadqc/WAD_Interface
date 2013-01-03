<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



$table_analysemodule='analysemodule';

$analysemodule_Stmt = "SELECT * from $table_analysemodule 
order by $table_analysemodule.description, $table_analysemodule.filename";

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

if (!($result_analysemodule= mysql_query($analysemodule_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


$table_analysemodule='';
 
$j=0;
while (($field_analysemodule = mysql_fetch_object($result_analysemodule)))
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
     $table_analysemodule=$table_data->fetch("file_select_header.tpl");
   }
   $action=sprintf("new_analysemodule.php?pk=%d&t=%d",$field_analysemodule->pk,time());
   $checkbox_name=sprintf("analysemodule[%d]",$field_analysemodule->pk);
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("description",$field_analysemodule->description);
   $table_data->assign("filename",$field_analysemodule->filename);
   $table_data->assign("action",$action);
      
   $table_analysemodule.=$table_data->fetch("file_select_row.tpl");

   $j++;
}


mysql_free_result($result_analysemodule);  

$data = new Smarty_NM();
$data->assign("Title","Analyse Modules");
$data->assign("header","Analyse Modules");
$data->assign("form_action",sprintf("new_analysemodule.php?pk=-1&t=%d",time() ) );
$data->assign("file_list",$table_analysemodule);

$new_analysemodule=sprintf("<a href=\"new_analysemodule.php?pk=0&t=%d\">Add new analyse module</a>",time());

$data->assign("new_file",$new_analysemodule);

$data->display("file_select.tpl");
 

?>
