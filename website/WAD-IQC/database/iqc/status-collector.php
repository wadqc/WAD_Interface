<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$study_pk=-1;

if (!empty($_GET['pk']))
{
  $study_pk=$_GET['pk'];
}

if (!empty($_GET['patient_name']))
{
  $patient_name=$_GET['patient_name'];
}
if (!empty($_GET['patient_id']))
{
  $patient_id=$_GET['patient_id'];
}
if (!empty($_GET['study_description']))
{
  $study_description=$_GET['study_description'];
}

if (isset($_GET['status']))
{
  $status=$_GET['status'];
} elseif (isset($_POST['status']))
{
  $status=$_POST['status'];
}

if (!empty($_GET['date_filter']))
{
  $date_filter=$_GET['date_filter'];
} elseif (!empty($_POST['date_filter']))
{
  $date_filter=$_POST['date_filter'];
} else
{
  $date_filter = '100 YEAR';
}

$table_patient='patient';
$table_study='study';
$table_series='series';
$table_instance='instance';
$table_study_status='collector_study_status';
$table_series_status='collector_series_status';
$table_collector_status_omschrijving='collector_status_omschrijving';
$table_omschrijving='collector_status_omschrijving';


$collector_study_Stmt = "SELECT distinct patient.pat_id AS 'pat_id', patient.pat_name AS 'pat_name', study.accession_no AS 'accession_no', study.study_desc as 'study_description', study.study_datetime AS 'study_datetime', study.pk AS 'study_pk', series.modality AS 'modality', collector_study_status.study_status AS 'status_study',collector_status_omschrijving.veld_omschrijving as 'omschrijving'
FROM patient
INNER JOIN (
study
INNER JOIN series ON study.pk = series.study_fk
INNER JOIN 
 ( collector_study_status
   inner join collector_status_omschrijving on collector_study_status.study_status=collector_status_omschrijving.nummer
 ) ON study.pk = collector_study_status.study_fk
) ON patient.pk = study.patient_fk
WHERE collector_study_status.study_status in (%s)
AND ( study.study_datetime > (NOW() - INTERVAL %s)) 
ORDER BY study_datetime desc";


$collector_series_Stmt = "SELECT distinct series.series_no as 'series_number', series.modality as 'modality', series.series_desc as 'series_description', series.station_name as 'station_name', coalesce(series.pps_start,instance.content_datetime) as 'series_datetime', collector_status_omschrijving.veld_omschrijving as 'omschrijving', series.pk as 'series_pk'
FROM 
instance, series
INNER JOIN 
 ( collector_series_status
   inner join collector_status_omschrijving on collector_series_status.series_status=collector_status_omschrijving.nummer
 ) ON series.pk = collector_series_status.series_fk
where 
series.study_fk='%d'
AND collector_series_status.series_status in (%s)
AND ( coalesce(series.pps_start,$table_instance.content_datetime,NOW()) > (NOW() - INTERVAL %s)) 
AND series.pk=instance.series_fk
AND $table_instance.pk=(select min(pk) from $table_instance where series_fk=$table_series.pk)
ORDER BY series_datetime desc";


$status_list = "SELECT * from $table_collector_status_omschrijving order by $table_collector_status_omschrijving.nummer"; 





// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!($result_status= $link->query($status_list))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $status_list)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}


$list_status='';
$counter=0;

while($field = $result_status->fetch_object())
{
  if (($counter==0)&&($status_id==-1)) //first visit, id will be changed to the id that is linked to the most recent date of study
  {
    $status_id=$field->nummer;
  }   
  $list_status["$field->nummer"]="$field->veld_omschrijving";
  $counter++;
} 

$list_all = implode(",", array_keys($list_status));
$list_status = array( $list_all => '*' ) + $list_status;

if(!isset($status))
{
  $status=$list_all;
}

$result_status->close();

$list_date['100 YEAR'] = '*';
$list_date['24 HOUR'] = 'afgelopen 24 uur';
$list_date['1 WEEK'] = 'afgelopen week';
$list_date['1 MONTH'] = 'afgelopen maand';
$list_date['1 YEAR'] = 'afgelopen jaar';

if (!($result_collector_study= $link->query(sprintf($collector_study_Stmt,$status,$date_filter)))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($collector_study_Stmt,$status,$date_filter))) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit();
}


if ($study_pk>0)
{
   if (!($result_collector_series= $link->query(sprintf($collector_series_Stmt,$study_pk,$status,$date_filter)))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($collector_series_Stmt,$study_pk,$status,$date_filter) )) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}


}

// tbv filter op series-niveau (doorgeven van studie-info bij onchange); date_filter en status komen dan uit de selectieboxes ipv $_GET
$GET=$_GET;
unset($GET['status']);
unset($GET['date_filter']);
$querystring = http_build_query($GET, '', '&');;

$table_data = new Smarty_NM();
$table_data->assign("status_options",$list_status);
$table_data->assign("status_id",$status);
$table_data->assign("date_options",$list_date);
$table_data->assign("date_select",$date_filter);
$table_data->assign("querystring",$querystring);
$selector_list=$table_data->fetch("status_filter_selector.tpl");


if ($study_pk<0)

{

$collector_study_row='';
 
$j=0;
$k=0;
while ($field_collector_study = $result_collector_study->fetch_object())
{
    
   $b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }   

   $table_data = new Smarty_NM();
   
   if ($k==0) //define header data
   {
     if (!empty($user_level_1))
     {
       $collector_study_row=$table_data->fetch("study_select_header.tpl");
     }
     if ( (!empty($user_level_2))||(!empty($user_level_5)) ) 
     {
       $collector_study_row=$table_data->fetch("study_header.tpl");
     }
     //$collector_study_row=$table_data->fetch("study_header.tpl");
     $pat_id=$field_collector_study->pat_id;
     $k++;
   }
   $checkbox_name=sprintf("study[%d]",$field_collector_study->study_pk);
   $action=sprintf("status-collector.php?pk=%s&patient_name=%s&patient_id=%s&study_description=%s&t=%d",$field_collector_study->study_pk,$field_collector_study->pat_name,$field_collector_study->pat_id,$field_collector_study->study_description,time());
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("study_datetime",$field_collector_study->study_datetime);
   $table_data->assign("patient_id",$field_collector_study->pat_id);
   //printf("%s",$field_collector_study->pat_id);
   $table_data->assign("patient_name",$field_collector_study->pat_name);
   $table_data->assign("accession_number",$field_collector_study->accession_no);
   $table_data->assign("study_description",$field_collector_study->study_description);
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
   //$collector_study_row.=$table_data->fetch("study_row.tpl");
   //if ($pat_id!=$field_collector_study->pat_id)
   //{ 
   //   $pat_id=$field_collector_study->pat_id;
   //   $j++;
   //}
   $j++;
   
}


$result_collector_study->close();  




$data = new Smarty_NM();

$data->assign("selection_list",$selector_list);
$data->assign("study_list",$collector_study_row);
$data->assign("form_action",sprintf("transfer_selector.php?t=%d&%s",time(),$querystring));



if (!empty($user_level_1))
{
  $data->display("study_select.tpl");
}

if ( (!empty($user_level_2))||(!empty($user_level_3)) )
{
  $data->display("study_view.tpl");
}

}  // end study_pk<0





if ($study_pk>0)
{

$collector_series_row='';
 
$j=0;
while ($field_collector_series = $result_collector_series->fetch_object())
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
     //$collector_series_row=$table_data->fetch("series_header.tpl");
   }
   $checkbox_name=sprintf("series[%d]",$field_collector_series->series_pk);
   $action=sprintf("status-collector.php?pk=%s&t=%d",$field_collector_study->study_pk,time());
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("series_number",$field_collector_series->series_number);
   $table_data->assign("modality",$field_collector_series->modality);
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
   //$collector_series_row.=$table_data->fetch("series_row.tpl");
   $j++;
   
}


$result_collector_series->close();  




$data = new Smarty_NM();


$data->assign("patient_name",$patient_name);
$data->assign("patient_id",$patient_id);
$data->assign("study_description",$study_description);
$data->assign("selection_list",$selector_list);
$data->assign("series_list",$collector_series_row);
$data->assign("form_action",sprintf("transfer_selector.php?t=%d&%s",time(),$querystring));

if (!empty($user_level_1))
{
  $data->display("series_select.tpl");
}

if ( (!empty($user_level_2))||(!empty($user_level_3)) )
{
  $data->display("series_view.tpl");
}



}




?>
 
  
