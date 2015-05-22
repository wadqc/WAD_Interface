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


if (isset($_GET['omschrijving']))
{
  $omschrijving=$_GET['omschrijving'];
} elseif (isset($_POST['omschrijving']))
{
  $omschrijving=$_POST['omschrijving'];
}


//printf("omschrijving=%s",$omschrijving);



$grootheid="%";
if (!empty($_GET['grootheid']))
{
  $grootheid=$_GET['grootheid'];
}
$eenheid="%";
if (!empty($_GET['eenheid']))
{
  $eenheid=$_GET['eenheid'];
}



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


   
   if (!($result_dosis= $link->query(sprintf($results_dosis_Stmt,$selector_fk)) )) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_dosis_Stmt,$selector_fk)) );
   DisplayErrMsg(sprintf("error:%d %s", $link->error(), mysql_error($link))) ;
   exit() ;
   }


 
$table_data = new Smarty_NM(); 

$dose_row='';
$j=0;

$grens_kritisch_boven_visible='false';
$grens_kritisch_onder_visible='false';
$grens_acceptabel_boven_visible='false';
$grens_acceptabel_onder_visible='false';



while (($field_results_dosis = $result_dosis->fetch_object()))
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

   
   $table_data->assign("bgcolor",$bgcolor);

   $year=substr($field_results_dosis->birth_date,0,4);
   $month=substr($field_results_dosis->birth_date,4,2);
   $day=substr($field_results_dosis->birth_date,6,2);
   //$birth_date=sprintf("%s-%s-%s",$year,$month,$day);
   //$age=($field_results_dosis->study_datetime)-$birth_date;
   
   $test=$field_results_dosis->omschrijving;
   $table_data->assign("omschrijving",$test);
   $table_data->assign("grootheid",$field_results_dosis->grootheid);
   $table_data->assign("waarde",$field_results_dosis->waarde);
   $table_data->assign("eenheid",$field_results_dosis->eenheid);
   $table_data->assign("study_date",$field_results_dosis->study_datetime);
   $table_data->assign("age",$field_results_dosis->leeftijd);
   $table_data->assign("accession_number",$field_results_dosis->accession_no);
  
   $dose_row.=$table_data->fetch("dose_row.tpl");
   $j++;
}


$result_dosis->close(); 


$data = new Smarty_NM();
$data->assign("Title","Results");
$data->assign("selection_list",$selector_list);
$data->assign("header_result",$header_result);
$data->assign("header_value","Resultaten floating");
$data->assign("picture_src","./logo_pictures/excel.jpg");
$omschrijving_export=rawurlencode($omschrijving);
//$omschrijving_export=$omschrijving;
$export_action=sprintf("export_floating_value_dose.php?selector_fk=%d&status=%d&analyse_level=%s&omschrijving=%s&grootheid=%s&eenheid=%s&t=%d",$selector_fk,$status,$analyse_level,$omschrijving_export,$grootheid,$eenheid,time());


$action_page=sprintf("data_floating.php?selector_fk=%d&status=%s&analyse_level=%s&omschrijving=%s&grootheid=%s&eenheid=%s&t=%d",$selector_fk,$status,$analyse_level,$omschrijving_export,$grootheid,$eenheid,time());

$data->assign("export_action",$export_action);
$data->assign("action_page",$action_page);
$data->assign("grens_kritisch_boven_visible",$grens_kritisch_boven_visible);
$data->assign("grens_kritisch_onder_visible",$grens_kritisch_onder_visible);
$data->assign("grens_acceptabel_boven_visible",$grens_acceptabel_boven_visible);
$data->assign("grens_acceptabel_onder_visible",$grens_acceptabel_onder_visible);

if ($dose_row!='')
{
  $data->assign("header_value","Resultaten floating");
  $data->assign("resultaten_value_list",$dose_row);
}



$data->display("data_floating_highcharts.tpl");





?>

