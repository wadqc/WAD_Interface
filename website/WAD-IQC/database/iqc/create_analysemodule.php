<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



$table_analysemodule='analysemodule';

$analysemodule_Stmt = "SELECT * from $table_analysemodule 
order by $table_analysemodule.description, $table_analysemodule.filename";

// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!($result_analysemodule= $link->query($analysemodule_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}


$table_analysemodule='';
 
$j=0;
while (($field_analysemodule = $result_analysemodule->fetch_object()))
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


$result_analysemodule->close();  

$data = new Smarty_NM();
$data->assign("Title","Analyse Modules");
$data->assign("header","Analyse Modules");
$data->assign("form_action",sprintf("new_analysemodule.php?pk=-1&t=%d",time() ) );
$data->assign("file_list",$table_analysemodule);

$new_analysemodule=sprintf("<a href=\"new_analysemodule.php?pk=0&t=%d\">Add new analyse module</a>",time());

$data->assign("new_file",$new_analysemodule);

$data->display("file_select.tpl");
 

?>
