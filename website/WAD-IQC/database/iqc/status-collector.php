<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$study_pk=-1;

if (!empty($_GET['pk']))
{
  $study_pk=$_GET['pk'];
}



$table_patient='patient';
$table_study='study';
$table_series='series';
$table_study_status='collector_study_status';
$table_series_status='collector_series_status';
$table_omschrijving='collector_status_omschrijving';


$collector_study_Stmt = "SELECT distinct patient.pat_id AS 'pat_id', patient.pat_name AS 'pat_name', study.accession_no AS 'accession_no', study.study_datetime AS 'study_datetime', study.pk AS 'study_pk', series.modality AS 'modality', collector_study_status.study_status AS 'status_study',collector_status_omschrijving.veld_omschrijving as 'omschrijving'
FROM patient
INNER JOIN (
study
INNER JOIN series ON study.pk = series.study_fk
INNER JOIN 
 ( collector_study_status
   inner join collector_status_omschrijving on collector_study_status.study_status=collector_status_omschrijving.nummer
 ) ON study.pk = collector_study_status.study_fk
) ON patient.pk = study.patient_fk
ORDER BY 'study_datetime'";


$collector_series_Stmt = "SELECT distinct series.series_no as 'series_number', series.modality as 'modality', series.series_desc as 'series_description', series.station_name as 'station_name', series.pps_start as 'series_datetime', collector_status_omschrijving.veld_omschrijving as 'omschrijving'
FROM 
series
INNER JOIN 
 ( collector_series_status
   inner join collector_status_omschrijving on collector_series_status.series_status=collector_status_omschrijving.nummer
 ) ON series.pk = collector_series_status.series_fk
where 
series.study_fk='%d'
ORDER BY 'series_datetime'";








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

if (!($result_collector_study= mysql_query($collector_study_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $collector_study_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


if ($study_pk>0)
{
   if (!($result_collector_series= mysql_query(sprintf($collector_series_Stmt,$study_pk), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($collector_study_Stmt,$pk_study) )) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


}

if ($study_pk<0)

{

$collector_study_row='';
 
$j=0;
while ($field_collector_study = mysql_fetch_object($result_collector_study))
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
     if (!empty($user_level_1))
     {
       $collector_study_row=$table_data->fetch("study_select_header.tpl");
     }
     if ( (!empty($user_level_2))||(!empty($user_level_5)) ) 
     {
       $collector_study_row=$table_data->fetch("study_header.tpl");
     }
   }
  $checkbox_name=sprintf("study[%d]",$field_collector_study->study_pk);
   $action=sprintf("status-collector.php?pk=%s&t=%d",$field_collector_study->study_pk,time());
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("patient_id",$field_collector_study->pat_id);
   //printf("%s",$field_collector_study->pat_id);
   $table_data->assign("patient_name",$field_collector_study->pat_name);
   $table_data->assign("accession_number",$field_collector_study->accession_no);
   $table_data->assign("status",$field_collector_study->omschrijving);

   
   $table_data->assign("action",$action);
   if (!empty($user_level_1))
   {
     $collector_study_row.=$table_data->fetch("study_select_row.tpl");
   }
   if ( (!empty($user_level_2))||(!empty($user_level_5)) )
   {
     $collector_study_row.=$table_data->fetch("study_row.tpl");
   }
   $j++;
}


mysql_free_result($result_collector_study);  




$data = new Smarty_NM();


$data->assign("form_action",sprintf("transfer_users.php?t=%d",time()));
$data->assign("users_list",$collector_study_row);

$new_users=sprintf("<a href=\"new_users.php?users_pk=-1&t=%d\">Add new User</a>",time());

$data->assign("new_users",$new_users);

if (!empty($user_level_1))
{
  $data->display("users_view.tpl");
}

if ( (!empty($user_level_2))||(!empty($user_level_5)) )
{
  $data->display("users_view.tpl");
}

}  // end study_pk<0





if ($study_pk>0)
{

$collector_series_row='';
 
$j=0;
while ($field_collector_series = mysql_fetch_object($result_collector_series))
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
     if (!empty($user_level_1))
     {
       $collector_series_row=$table_data->fetch("series_select_header.tpl");
     }
     if ( (!empty($user_level_2))||(!empty($user_level_5)) ) 
     {
       $collector_series_row=$table_data->fetch("series_header.tpl");
     }
   }
   $checkbox_name=sprintf("series[%d]",$field_collector_series->series_pk);
   //$action=sprintf("status-collector.php?pk=%s&t=%d",$field_collector_study->study_pk,time());
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("series_number",$field_collector_series->series_number);
   $table_data->assign("modality",$field_collector_series->modality);
   //printf("description: %s",$field_collector_series->series_description);
   $table_data->assign("series_description",$field_collector_series->series_description);
   $table_data->assign("station_name",$field_collector_series->station_name);
   $table_data->assign("series_datetime",$field_collector_series->series_datetime);
   $table_data->assign("status",$field_collector_series->omschrijving);

   
   $table_data->assign("action",$action);
   if (!empty($user_level_1))
   {
     $collector_series_row.=$table_data->fetch("series_select_row.tpl");
   }
   if ( (!empty($user_level_2))||(!empty($user_level_5)) )
   {
     $collector_series_row.=$table_data->fetch("series_row.tpl");
   }
   $j++;
}


mysql_free_result($result_collector_series);  




$data = new Smarty_NM();


$data->assign("form_action",sprintf("transfer_users.php?t=%d",time()));
$data->assign("users_list",$collector_series_row);

$new_users=sprintf("<a href=\"new_users.php?users_pk=-1&t=%d\">Add new User</a>",time());

$data->assign("new_users",$new_users);

if (!empty($user_level_1))
{
  $data->display("users_view.tpl");
}

if ( (!empty($user_level_2))||(!empty($user_level_5)) )
{
  $data->display("users_view.tpl");
}










}













?>
 
  
