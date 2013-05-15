<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$study_pk=-1;

if (!empty($_GET['pk']))
{
  $study_pk=$_GET['pk'];
}



$table_gewenste_processen='gewenste_processen';
$table_status_omschrijving='status_omschrijving';
$table_patient='patient';
$table_study='study';
$table_series='series';
$table_instance='instance';


$processor_study_Stmt = "SELECT distinct patient.pat_id AS 'pat_id', patient.pat_name AS 'pat_name', study.accession_no AS 'accession_no', study.study_datetime AS 'study_datetime', selector.name AS 'selector_name', gewenste_processen.creation_time AS 'creation_time', status_omschrijving.veld_omschrijving as 'status_omschrijving'
FROM patient
INNER JOIN (
study inner join (
gewenste_processen
inner join selector on gewenste_processen.selector_fk=selector.pk
inner join status_omschrijving on gewenste_processen.status=status_omschrijving.nummer
)
on study.pk=gewenste_processen.study_fk
)
on patient.pk = study.patient_fk
where gewenste_processen.pk='%d'
ORDER BY 'creation_time'";

$processor_series_Stmt = "SELECT distinct patient.pat_id AS 'pat_id', patient.pat_name AS 'pat_name', study.accession_no AS 'accession_no', study.study_datetime AS 'study_datetime', selector.name AS 'selector_name', series.modality as 'modality', series.station_name as 'station_name', series.pps_start as 'series_datetime',gewenste_processen.creation_time AS 'creation_time', status_omschrijving.veld_omschrijving as 'status_omschrijving'
FROM patient
INNER JOIN (
study inner join (
series inner join (
gewenste_processen
inner join selector on gewenste_processen.selector_fk=selector.pk
inner join status_omschrijving on gewenste_processen.status=status_omschrijving.nummer
)
on series.pk=gewenste_processen.series_fk
)
on study.pk=series.study_fk
)
on patient.pk = study.patient_fk
where gewenste_processen.pk='%d'
ORDER BY 'creation_time'";

$processor_instance_Stmt = "SELECT distinct patient.pat_id AS 'pat_id', patient.pat_name AS 'pat_name', study.accession_no AS 'accession_no', study.study_datetime AS 'study_datetime', selector.name AS 'selector_name', series.modality as 'modality', series.station_name as 'station_name', series.pps_start as 'series_datetime', instance.content_datetime as 'image_datetime', gewenste_processen.creation_time AS 'creation_time', status_omschrijving.veld_omschrijving as 'status_omschrijving'
FROM patient
INNER JOIN (
study inner join (
series inner join (
instance inner join (
gewenste_processen
inner join selector on gewenste_processen.selector_fk=selector.pk
inner join status_omschrijving on gewenste_processen.status=status_omschrijving.nummer
)
on instance.pk=gewenste_processen.instance_fk
)
on series.pk=instance.series_fk
)
on study.pk=series.study_fk
)
on patient.pk = study.patient_fk
where gewenste_processen.pk='%d'
ORDER BY 'creation_time'";






$status_list = "SELECT * from $table_status_omschrijving order by $table_status_omschrijving.nummer"; 

$gewenste_processen_Stmt="Select * from $table_gewenste_processen where $table_gewenste_processen.status!='%d' 
order by $table_gewenste_processen.creation_time";








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

if (!($result_status= mysql_query($status_list, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $collector_study_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}



if (!($result_processor_study= mysql_query(sprintf($processor_study_Stmt,10,8), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $collector_study_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


if (!($result_processor_series= mysql_query(sprintf($processor_series_Stmt,10,56), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $collector_study_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


if (!($result_processor_instance= mysql_query(sprintf($processor_instance_Stmt,10,1), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $collector_study_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


if (!($result_gewenste_processen= mysql_query(sprintf($gewenste_processen_Stmt,5), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $collector_study_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}



$list_status='';
$counter=0;

while($field = mysql_fetch_object($result_status))
{
  if (($counter==0)&&($status_id==-1)) //first visit, id will be changed to the id that is linked to the most recent date of study
  {
    $status_id=$field->nummer;
  }   
  $list_status["$field->nummer"]="$field->veld_omschrijving";
  $counter++;
} 

mysql_free_result($result_status);


$table_data = new Smarty_NM();
$table_data->assign("status_options",$list_status);
$table_data->assign("status_id",$gewenste_processen_id);

$selector_list=$table_data->fetch("status_select.tpl");




$processor_status_row='';

$j=0;
while ($field_gewenste_processen = mysql_fetch_object($result_gewenste_processen))
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
       $processor_status_row=$table_data->fetch("proces_select_header.tpl");
     }
     if ( (!empty($user_level_2))||(!empty($user_level_5)) ) 
     {
       $processor_status_row=$table_data->fetch("proces_header.tpl");
     }
   }
   
   if (!($field_gewenste_processen->study_fk == NULL))
   {
     if (!($result_processor_study= mysql_query(sprintf($processor_study_Stmt,$field_gewenste_processen->pk), $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $collector_study_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
     }
     while ($field_processor_study = mysql_fetch_object($result_processor_study))
     {
       $checkbox_name=sprintf("gewenste_processen[%d]",$field_gewenste_processen->pk);
       $table_data->assign("bgcolor",$bgcolor);
       $table_data->assign("checkbox_name",$checkbox_name);
       $table_data->assign("patient_id",$field_processor_study->pat_id);
       $table_data->assign("patient_name",$field_processor_study->pat_name);
       $table_data->assign("accession_number",$field_processor_study->accession_no);
       $table_data->assign("study_date",$field_processor_study->study_datetime);
       $table_data->assign("selector_name",$field_processor_study->selector_name);
       $table_data->assign("proces_date",$field_processor_study->creation_time);
       $table_data->assign("proces_status",$field_processor_study->status_omschrijving);

       $table_data->assign("action",$action);
       if (!empty($user_level_1))
       {
        $processor_status_row.=$table_data->fetch("proces_select_row.tpl");
       }
       if ( (!empty($user_level_2))||(!empty($user_level_5)) )
       {
       $processor_status_row.=$table_data->fetch("proces_row.tpl");
       }
       $j++;
     }
     mysql_free_result($result_processor_study); 
   }

   if (!($field_gewenste_processen->series_fk == NULL))
   {
     if (!($result_processor_series= mysql_query(sprintf($processor_series_Stmt,$field_gewenste_processen->pk), $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $collector_study_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
     }
     while ($field_processor_series = mysql_fetch_object($result_processor_series))
     {
       $checkbox_name=sprintf("gewenste_processen[%d]",$field_gewenste_processen->pk);
       $table_data->assign("bgcolor",$bgcolor);
       $table_data->assign("checkbox_name",$checkbox_name);
       $table_data->assign("patient_id",$field_processor_series->pat_id);
       $table_data->assign("patient_name",$field_processor_series->pat_name);
       $table_data->assign("accession_number",$field_processor_series->accession_no);
       $table_data->assign("study_date",$field_processor_series->study_datetime);
       $table_data->assign("modality",$field_processor_series->modality);
       $table_data->assign("station_name",$field_processor_series->station_name);
       $table_data->assign("series_date",$field_processor_series->series_datetime);
       $table_data->assign("selector_name",$field_processor_series->selector_name);
       $table_data->assign("proces_date",$field_processor_series->creation_time);
       $table_data->assign("proces_status",$field_processor_series->status_omschrijving);

       $table_data->assign("action",$action);
       if (!empty($user_level_1))
       {
        $processor_status_row.=$table_data->fetch("proces_select_row.tpl");
       }
       if ( (!empty($user_level_2))||(!empty($user_level_5)) )
       {
       $processor_status_row.=$table_data->fetch("proces_row.tpl");
       }
       $j++;
     }
     mysql_free_result($result_processor_series); 
   }

   if (!($field_gewenste_processen->instance_fk == NULL))
   {
     if (!($result_processor_instance= mysql_query(sprintf($processor_instance_Stmt,$field_gewenste_processen->pk), $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $collector_study_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
     }
     while ($field_processor_instance = mysql_fetch_object($result_processor_instance))
     {
       $checkbox_name=sprintf("gewenste_processen[%d]",$field_gewenste_processen->pk);
       $table_data->assign("bgcolor",$bgcolor);
       $table_data->assign("checkbox_name",$checkbox_name);
       $table_data->assign("patient_id",$field_processor_instance->pat_id);
       $table_data->assign("patient_name",$field_processor_instance->pat_name);
       $table_data->assign("accession_number",$field_processor_instance->accession_no);
       $table_data->assign("study_date",$field_processor_instance->study_datetime);
       $table_data->assign("modality",$field_processor_instance->modality);
       $table_data->assign("station_name",$field_processor_instance->station_name);
       $table_data->assign("series_date",$field_processor_instance->series_datetime);
       $table_data->assign("instance_date",$field_processor_instance->instance_datetime);  
       $table_data->assign("selector_name",$field_processor_instance->selector_name);
       $table_data->assign("proces_date",$field_processor_instance->creation_time);
       $table_data->assign("proces_status",$field_processor_instance->status_omschrijving);

       $table_data->assign("action",$action);
       if (!empty($user_level_1))
       {
        $processor_status_row.=$table_data->fetch("proces_select_row.tpl");
       }
       if ( (!empty($user_level_2))||(!empty($user_level_5)) )
       {
       $processor_status_row.=$table_data->fetch("proces_row.tpl");
       }
       $j++;
     }
     mysql_free_result($result_processor_instance); 
   }

}
mysql_free_result($result_gewenste_processen); 




$data = new Smarty_NM();


$data->assign("form_action",sprintf("transfer_users.php?t=%d",time()));
$data->assign("users_list",$processor_status_row);

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

























?>
 
  
