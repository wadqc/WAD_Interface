<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



$table_study='study';
$table_series='series';
$table_instance='instance';



$table_resultaten_floating='resultaten_floating';
$table_study='study';
$table_patient='patient';
$table_gewenste_processen='gewenste_processen';
$table_selector='selector';
$table_resultaten_status='resultaten_status';





$v=0;
$v=$_GET['v'];




$analyse_level='study';
if (!empty($_GET['analyse_level']))
{
  $analyse_level=$_GET['analyse_level'];
}


if (!empty($_POST['niveau']))
{
  $niveau=$_POST['niveau'];
}
if (!empty($_GET['niveau']))
{
  $niveau=$_GET['niveau'];
}

//$status=5;

if (!empty($_GET['status']))
{
  $status=$_GET['status'];
}
if (!empty($_POST['status']))
{
  $status=$_POST['status'];
}



$selector_fk=0;
if (!empty($_GET['selector_fk']))
{
  $selector_fk=$_GET['selector_fk'];
}

$omschrijving="*";

if (isset($_GET['omschrijving']))
{
  $omschrijving=$_GET['omschrijving'];
} elseif (isset($_POST['omschrijving']))
{
  $omschrijving=$_POST['omschrijving'];
}






$results_omschrijving_Stmt="SELECT distinct $table_resultaten_floating.omschrijving as omschrijving
from 
$table_selector
inner join 
($table_gewenste_processen
  inner join $table_resultaten_floating
  on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk
) on 
$table_selector.pk=$table_gewenste_processen.selector_fk 
where $table_selector.pk='%d'
order by $table_resultaten_floating.omschrijving";



if ($omschrijving=="*")
{


$results_dosis_Stmt="SELECT $table_resultaten_floating.omschrijving as omschrijving, $table_resultaten_floating.grootheid as grootheid,$table_resultaten_floating.waarde as waarde, $table_resultaten_floating.eenheid as eenheid, 
$table_patient.pat_birthdate as birth_date, $table_study.accession_no as accession_no, $table_study.study_datetime as study_datetime,
round((DATEDIFF(study.study_datetime,patient.pat_birthdate)/365),0) as leeftijd
from 
($table_selector
inner join 
($table_gewenste_processen
  inner join $table_resultaten_floating
  on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk
) on 
$table_selector.pk=$table_gewenste_processen.selector_fk) 
inner join 
($table_study 
  inner join 
  $table_patient on $table_patient.pk=$table_study.patient_fk
) on
$table_study.pk=$table_gewenste_processen.study_fk
where $table_selector.pk='%d'
order by study_datetime,omschrijving";


}

if ($omschrijving!="*")
{


$results_dosis_Stmt="SELECT $table_resultaten_floating.omschrijving as omschrijving, $table_resultaten_floating.grootheid as grootheid,$table_resultaten_floating.waarde as waarde, $table_resultaten_floating.eenheid as eenheid, 
$table_patient.pat_birthdate as birth_date, $table_study.accession_no as accession_no, $table_study.study_datetime as study_datetime,
round((DATEDIFF(study.study_datetime,patient.pat_birthdate)/365),0) as leeftijd
from 
($table_selector
inner join 
($table_gewenste_processen
  inner join $table_resultaten_floating
  on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk
) on 
$table_selector.pk=$table_gewenste_processen.selector_fk) 
inner join 
($table_study 
  inner join 
  $table_patient on $table_patient.pk=$table_study.patient_fk
) on
$table_study.pk=$table_gewenste_processen.study_fk
where $table_selector.pk='%d'and
$table_resultaten_floating.omschrijving='$omschrijving'
order by study_datetime,omschrijving";

}


// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!$link->set_charset('utf8')) {
   printf("Error loading character set utf8: %s\n", $link->error);
} 

//printf("%s",$link->character_set_name() );


   
   if (!($result_dosis= $link->query(sprintf($results_dosis_Stmt,$selector_fk) ))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_dosis_Stmt,$selector_fk)) );
   DisplayErrMsg(sprintf("error:%d %s", $link->error(), mysql_error($link))) ;
   exit() ;
   }


$omschrijving_list["*"]="*";


if (!($result_omschrijving= $link->query(sprintf($results_omschrijving_Stmt,$selector_fk) ))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_dosis_Stmt,$selector_fk)) );
   DisplayErrMsg(sprintf("error:%d %s", $link->error(), mysql_error($link))) ;
   exit() ;
   }
header('Content-Type: text/html; charset=utf-8');
while ($field_result_omschrijving = $result_omschrijving->fetch_object() )
{
  $test=$field_result_omschrijving->omschrijving;
   
 

  $omschrijving_list["$field_result_omschrijving->omschrijving"]="$field_result_omschrijving->omschrijving";
  

} 

$result_omschrijving->close();

//print_r($omschrijving_list);
//exit();


$table_data = new Smarty_NM();
$table_data->assign("status_options",$list_status);
$table_data->assign("status_id",$status);
$table_data->assign("omschrijving_options",$omschrijving_list);
$table_data->assign("omschrijving_id",$omschrijving);
$table_data->assign("date_options",$list_date);
$table_data->assign("date_select",$date_filter);
$table_data->assign("selector_fk",$selector_fk);

$selector_list=$table_data->fetch("dose_filter.tpl");


if (!($result_dosis= $link->query(sprintf($results_dosis_Stmt,$selector_fk) ))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_dosis_Stmt,$selector_fk)) );
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
   }
 

 
$table_data = new Smarty_NM(); 

$dose_row='';
$j=0;

while ($field_results_dosis = $result_dosis->fetch_object() )
{

   $b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }   

   if ($j==0) //define header data
   {
     $dose_row=$table_data->fetch("dose_select_header.tpl");
   }
   
   $test_action=$field_results_dosis->omschrijving;  

   $test_action=rawurlencode($field_results_dosis->omschrijving);
   $action=sprintf("show_floating_value_dose.php?selector_fk=%d&analyse_level=%s&status=%s&omschrijving=%s&grootheid=%s&eenheid=%s&t=%d",$selector_fk,$analyse_level,$status,$test_action,$field_results_dosis->grootheid,$field_results_dosis->eenheid ,time());  

   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("action",$action);
   $test=$field_results_dosis->omschrijving;
  
   $table_data->assign("omschrijving",$test);
   $table_data->assign("grootheid",$field_results_dosis->grootheid);
   $table_data->assign("waarde",$field_results_dosis->waarde);
   $table_data->assign("eenheid",$field_results_dosis->eenheid);
   $year=substr($field_results_dosis->birth_date,0,4);
   $month=substr($field_results_dosis->birth_date,4,2);
   $day=substr($field_results_dosis->birth_date,6,2);
   $birth_date=sprintf("%s-%s-%s",$year,$month,$day);
   $age=($field_results_dosis->study_datetime)-$birth_date;
   //$age=$age-$field_results_dosis->leeftijd; 
   $age=$field_results_dosis->leeftijd; 
   
  
   $table_data->assign("birth_date",$birth_date); 
   $table_data->assign("age",$age); 
   $table_data->assign("study_date",$field_results_dosis->study_datetime);
   $table_data->assign("accession_number",$field_results_dosis->accession_no);
  
   

   $table_data->assign("action",$action);
   
   $dose_row.=$table_data->fetch("dose_select_row.tpl");
      
   $j++;



}


$result_dosis->close(); 

$data = new Smarty_NM();

$data->assign("picture_src","./logo_pictures/excel.jpg");
$export_action=sprintf("export_floating_value_dose.php?selector_fk=%d&t=%d",$selector_fk,time());
$data->assign("export_action",$export_action);

$data->assign("selector_list",$selector_list);
$data->assign("dose_list",$dose_row);

$data->display("dose_select.tpl");






?>