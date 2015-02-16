<?php
require("../globals.php");
require("../iqc_data.php");
require("./common.php");
require("./php/includes/setup.php");


if (!empty($_POST['transfer_action']))
{
  $transfer_action=$_POST['transfer_action'];
}
if (!empty($_GET['transfer_action']))
{
  $transfer_action=$_GET['transfer_action'];
}

if (isset($_POST['study'])) {
   $level='study';
   $selected_studies=implode(",", array_keys($_POST['study']));
}

if (isset($_POST['series'])) {
   $level='series';
   $selected_series=implode(",", array_keys($_POST['series']));
}

$querystring='';

if (!empty($_GET['pk']))
{
  $querystring .= 'pk=' . $_GET['pk'] . '&';
}
if (!empty($_GET['patient_name']))
{
  $querystring .= 'patient_name=' . $_GET['patient_name'] . '&';
}
if (!empty($_GET['patient_id']))
{
  $querystring .= 'patient_id=' . $_GET['patient_id'] . '&';
}
if (!empty($_GET['study_description']))
{
  $querystring .= 'study_description=' . $_GET['study_description'] . '&';
}

$table_study='study';
$table_collector_study_status='collector_study_status';
$table_series='series';
$table_collector_series_status='collector_series_status';
$reset_status=1;


//$del_studies_Stmt=''; 
//$del_series_Stmt='';

//$update_studies_Stmt="update $table_study set status='%d' where pk in (%s)";
$update_studies_Stmt="update $table_series,$table_study,$table_collector_series_status,$table_collector_study_status  set $table_collector_study_status.study_status='%d',$table_collector_series_status.series_status='%d' where $table_study.pk=$table_series.study_fk and $table_study.pk in (%s) and $table_collector_study_status.study_fk=$table_study.pk and $table_collector_series_status.series_fk=$table_series.pk";
$update_series_Stmt="update $table_collector_series_status,$table_series set $table_collector_series_status.series_status='%d' where $table_series.pk in (%s) and $table_collector_series_status.series_fk=$table_series.pk";




// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


if($level=='series' && $transfer_action='reset'){
  if (!($link->query(sprintf($update_series_Stmt,$reset_status,$selected_series)))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($update_series_Stmt,$reset_status,$selected_series)) ) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
  }
}


if($level=='study' && $transfer_action='reset'){
  if (!($link->query(sprintf($update_studies_Stmt,$reset_status,$reset_status,$selected_studies)))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($update_studies_Stmt,$reset_status,$reset_status,$selected_studies)) ) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
  }
}

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
$executestring.= sprintf("status-collector.php?t=%d&%s",time(),$querystring);
header($executestring);
exit();






?>




