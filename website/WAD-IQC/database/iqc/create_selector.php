<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



$table_selector='selector';
$table_analysemodule='analysemodule';
$table_analysemodule_cfg='analysemodule_cfg';


$selector_Stmt = "SELECT * from $table_selector 
order by $table_selector.name";

$testfile_Stmt = "SELECT * from $table_analysemodule 
where $table_analysemodule.pk='%d'";

$configfile_Stmt = "SELECT * from $table_analysemodule_cfg 
where $table_analysemodule_cfg.pk='%d'";



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

if (!($result_selector= mysql_query($selector_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


$table_selector='';



 


 
$j=0;
while (($field_selector = mysql_fetch_object($result_selector)))
{
  $selector_patient_fk=$field_selector->selector_patient_fk;
  $selector_study_fk=$field_selector->selector_study_fk;
  $selector_series_fk=$field_selector->selector_series_fk;
  $selector_instance_fk=$field_selector->selector_instance_fk;

  if (!($result_analysemodule= mysql_query(sprintf($testfile_Stmt,$field_selector->analysemodule_fk),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($testfile_Stmt,$field_selector->analysemodule_fk))) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
  }
  $field_analysemodule = mysql_fetch_object($result_analysemodule);
  $analysemodule_name=$field_analysemodule->description;
  mysql_free_result($result_analysemodule);

  if (!($result_analysemodule_cfg= mysql_query(sprintf($configfile_Stmt,$field_selector->analysemodule_cfg_fk),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($configfile_Stmt,$field_selector->analysemodule_cfg_fk))) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
  }
  $field_analysemodule_cfg = mysql_fetch_object($result_analysemodule_cfg);
  $analysemodule_cfg_name=$field_analysemodule_cfg->description;
  mysql_free_result($result_analysemodule_cfg);


   $b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }   

   $table_data = new Smarty_NM();
   
   if ($j==0) //define header data
   {
     $table_selector=$table_data->fetch("selector_select_header.tpl");
   }

   $action=sprintf("new_selector.php?pk=%d&selector_patient_fk=%d&selector_study_fk=%d&selector_series_fk=%d&selector_instance_fk=%d&t=%d",$field_selector->pk,$selector_patient_fk,$selector_study_fk,$selector_series_fk,$selector_instance_fk,time()); 
   $checkbox_name=sprintf("selector[%d]",$field_selector->pk);
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("name",$field_selector->name);
   $table_data->assign("analysemodule",$analysemodule_name);
   $table_data->assign("analysemodule_cfg",$analysemodule_cfg_name);
   
   $table_data->assign("action",$action);
      
   $table_selector.=$table_data->fetch("selector_selector_select_row.tpl");

   $j++;
}


mysql_free_result($result_selector);  

$data = new Smarty_NM();
$data->assign("Title","Selector");
$data->assign("header","Selector");
$data->assign("form_action",sprintf("new_selector.php?pk=-1&t=%d",time() ) );
$data->assign("file_list",$table_selector);

$new_selector=sprintf("<a href=\"new_selector.php?pk=0&selector_patient_fk=0&selector_study_fk=0&selector_series_fk=0&selector_instance_fk=0&t=%d\">Add new selector</a>",time());


$data->assign("new_file",$new_selector);

$data->display("file_select.tpl");
 

?>
