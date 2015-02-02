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
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!($result_selector= $link->query($selector_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}


$table_selector='';



 


 
$j=0;
while (($field_selector = $result_selector->fetch_object()))
{
  $selector_patient_fk=$field_selector->selector_patient_fk;
  $selector_study_fk=$field_selector->selector_study_fk;
  $selector_series_fk=$field_selector->selector_series_fk;
  $selector_instance_fk=$field_selector->selector_instance_fk;

  if (!($result_analysemodule= $link->query(sprintf($testfile_Stmt,$field_selector->analysemodule_fk)))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($testfile_Stmt,$field_selector->analysemodule_fk))) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
  }
  $field_analysemodule = $result_analysemodule->fetch_object();
  $analysemodule_name=$field_analysemodule->description;
  $result_analysemodule->close();

  if (!($result_analysemodule_cfg= $link->query(sprintf($configfile_Stmt,$field_selector->analysemodule_cfg_fk)))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($configfile_Stmt,$field_selector->analysemodule_cfg_fk))) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
  }
  $field_analysemodule_cfg = $result_analysemodule_cfg->fetch_object();
  $analysemodule_cfg_name=$field_analysemodule_cfg->description;
  $result_analysemodule_cfg->close();


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


$result_selector->close();  

$data = new Smarty_NM();
$data->assign("Title","Selector");
$data->assign("header","Selector");
$data->assign("form_action",sprintf("new_selector.php?pk=-1&t=%d",time() ) );
$data->assign("file_list",$table_selector);

$new_selector=sprintf("<a href=\"new_selector.php?pk=0&selector_patient_fk=0&selector_study_fk=0&selector_series_fk=0&selector_instance_fk=0&t=%d\">Add new selector</a>",time());


$data->assign("new_file",$new_selector);

$data->display("file_select.tpl");
 

?>
