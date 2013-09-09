<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



$table_selector='selector';
$table_analysemodule='analysemodule';
$table_analysemodule_cfg='analysemodule_cfg';


$selector_Stmt = "SELECT * from $table_selector 
order by $table_selector.naam";

$testfile_Stmt = "SELECT * from $table_analysemodule 
where $table_analysemodule.pk='%d'";

$configfile_Stmt = "SELECT * from $table_analysemodule_cfg 
where $table_analysemodule_cfg.pk='%d'";



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

if (!($result_selector= mysql_query($selector_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


$table_selector='';



  $table_selector_patient="selector_patient";
  $table_selector_study="selector_study";
  $table_selector_series="selector_series";
  $table_selector_instance="selector_instance";

  
  $selector_patient_stmt = "SELECT * from $table_selector_patient where $table_selector_patient.selector_fk='%d'";
  $selector_study_stmt = "SELECT * from $table_selector_study where $table_selector_study.selector_fk='%d'";
  $selector_series_stmt = "SELECT * from $table_selector_series where $table_selector_series.selector_fk='%d'";
  $selector_instance_stmt = "SELECT * from $table_selector_instance where $table_selector_instance.selector_fk='%d'";









 
$j=0;
while (($field_selector = mysql_fetch_object($result_selector)))
{


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


   $selector_patient_pk=0;
   $selector_study_pk=0;
   $selector_series_pk=0;
   $selector_instance_pk=0;
   
   

   

   if (!($result_patient= mysql_query(sprintf($selector_patient_stmt,$field_selector->pk), $link)))
   {
      DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($selector_patient_stmt,$field_selector->pk) )) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
   }
   $num_rows=0;
   $num_rows = mysql_num_rows($result_patient);
   if ($num_rows>0)
   {
     $field_patient = mysql_fetch_object($result_patient);
     $selector_patient_pk=$field_patient->pk;
   }   
   mysql_free_result($result_patient);

   if (!($result_study= mysql_query(sprintf($selector_study_stmt,$field_selector->pk), $link)))
   {
      DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($selector_study_stmt,$field_selector->pk) )) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
   }
   $num_rows = mysql_num_rows($result_study);
   if ($num_rows>0)
   {
     $field_study = mysql_fetch_object($result_study);
     $selector_study_pk=$field_selector->pk;
   }   
   mysql_free_result($result_study);
 
   if (!($result_series= mysql_query(sprintf($selector_series_stmt,$field_selector->pk), $link)))
   {
      DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($selector_series_stmt,$field_selector->pk) )) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
   }
   $num_rows = mysql_num_rows($result_series);
   if ($num_rows>0)
   {
     $field_series = mysql_fetch_object($result_series);
     $selector_series_pk=$field_selector->pk;
   }   
   mysql_free_result($result_series);

   if (!($result_instance= mysql_query(sprintf($selector_instance_stmt,$field_selector->pk), $link)))
   {
      DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($selector_instance_stmt,$field_selector->pk) )) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
   }
      

   $num_rows = mysql_num_rows($result_instance);
   if ($num_rows>0)
   {
     $field_instance = mysql_fetch_object($result_instance);
     $selector_instance_pk=$field_selector->pk;
     
   }   
   mysql_free_result($result_instance);
  
   
   $action=sprintf("new_selector.php?pk=%d&selector_patient_pk=%d&selector_study_pk=%d&selector_series_pk=%d&selector_instance_pk=%d&t=%d",$field_selector->pk,$selector_patient_pk,$selector_study_pk,$selector_series_pk,$selector_instance_pk,time());
   $checkbox_name=sprintf("selector[%d]",$field_selector->pk);
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("naam",$field_selector->naam);
   $table_data->assign("analysemodule",$analysemodule_naam);
   $table_data->assign("analysemodule_cfg",$analysemodule_cfg_naam);
   
   $table_data->assign("action",$action);
      
   $table_selector.=$table_data->fetch("selector_select_row.tpl");

   $j++;
}


mysql_free_result($result_selector);  

$data = new Smarty_NM();
$data->assign("Title","Selector");
$data->assign("header","Selector");
$data->assign("form_action",sprintf("new_selector.php?pk=-1&t=%d",time() ) );
$data->assign("file_list",$table_selector);

$new_selector=sprintf("<a href=\"new_selector.php?pk=0&selector_patient_pk=0&selector_study_pk=0&selector_series_pk=0&selector_instance_pk=0&t=%d\">Add new selector</a>",time());

$data->assign("new_file",$new_selector);

$data->display("file_select.tpl");
 

?>
