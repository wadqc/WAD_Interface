<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



$table_analysemodule_cfg='analysemodule_cfg';

$analysemodule_cfg_Stmt = "SELECT * from $table_analysemodule_cfg 
order by $table_analysemodule_cfg.description, $table_analysemodule_cfg.filename";

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

if (!($result_analysemodule_cfg= mysql_query($analysemodule_cfg_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


$table_analysemodule_cfg='';
 
$j=0;
while (($field_analysemodule_cfg = mysql_fetch_object($result_analysemodule_cfg)))
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
     $table_analysemodule_cfg=$table_data->fetch("file_select_header.tpl");
   }
   $action=sprintf("new_analysemodule_cfg.php?pk=%d&t=%d",$field_analysemodule_cfg->pk,time());
   $checkbox_name=sprintf("analysemodule_cfg[%d]",$field_analysemodule_cfg->pk);
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("description",$field_analysemodule_cfg->description);
   $table_data->assign("filename",$field_analysemodule_cfg->filename);
   $table_data->assign("action",$action);
      
   $table_analysemodule_cfg.=$table_data->fetch("file_select_row.tpl");

   $j++;
}


mysql_free_result($result_analysemodule_cfg);  

$data = new Smarty_NM();
$data->assign("Title","Config Files");
$data->assign("header","Config Files");
$data->assign("form_action",sprintf("new_analysemodule_cfg.php?pk=-1&t=%d",time() ) );
$data->assign("file_list",$table_analysemodule_cfg);

$new_analysemodule_cfg=sprintf("<a href=\"new_analysemodule_cfg.php?pk=0&t=%d\">Add new analysemodule_cfg</a>",time());

$data->assign("new_file",$new_analysemodule_cfg);

$data->display("file_select.tpl");
 

?>
