<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$main_page = new Smarty_NM();


$db_action_list['0'] = 'Kies een actie uit de lijst...';
$db_action_list['1'] = 'Verwijder alle resultaten voor een specifieke selector';
//$db_action_list['2'] = 'Herstel IQC-database naar "fabrieksinstellingen"';
$db_action_list['3'] = 'Verwijder studies/series zonder entry in gewenste processen tabel';
$db_action_list['4'] = 'Verwijder patienten/studies/series zonder entry in gewenste processen tabel';
$db_action_list['5'] = 'Verwijder gewenste processen zonder resultaten';
//$db_action_list['6'] = 'Verwijder specifiek gewenst proces incl resultaten';



// action queries

/////////////////////////////////////////////////////////////////////
// action 1:

$selector_Stmt="select * from selector order by name";

// lijst met selectoren, incl aantal resultaten van elk type
// als deze te traag mocht blijken bij een gevulde DB dan vervangen door bovenstaande query
$selector_Stmt_old="
 select
   s.pk,s.name,s.description,
   count(distinct gp.pk) as nr_gewenste_processen,
   count(distinct rf.pk) as nr_results_floating,
   count(distinct rc.pk) as nr_results_char,
   count(distinct ro.pk) as nr_results_object,
   count(distinct rb.pk) as nr_results_boolean
 from selector as s
 left join gewenste_processen as gp
   on s.pk=gp.selector_fk
 left join resultaten_floating as rf
   on gp.pk=rf.gewenste_processen_fk
 left join resultaten_char as rc
   on gp.pk=rc.gewenste_processen_fk
 left join resultaten_object as ro
   on gp.pk=ro.gewenste_processen_fk
 left join resultaten_boolean as rb
   on gp.pk=rb.gewenste_processen_fk
 group by s.pk
";

// gewenste_processen entry ook deleten of van status wijzigen?
$delete_selector_results_Stmt="
 delete gewenste_processen,resultaten_floating,resultaten_char,resultaten_object,resultaten_boolean
 from gewenste_processen
 left join resultaten_floating
   on gewenste_processen.pk=resultaten_floating.gewenste_processen_fk
 left join resultaten_char
   on gewenste_processen.pk=resultaten_char.gewenste_processen_fk
 left join resultaten_object
   on gewenste_processen.pk=resultaten_object.gewenste_processen_fk
 left join resultaten_boolean
   on gewenste_processen.pk=resultaten_boolean.gewenste_processen_fk
 where gewenste_processen.selector_fk in (%s)
";




/////////////////////////////////////////////////////////////////////
// action 2:

/* initialiseren DB: welke tabellen willen we behouden/wissen?
SET FOREIGN_KEY_CHECKS=0;
truncate files;
truncate instance;
truncate series;
truncate study;
truncate patient;
truncate analysemodule_input;
truncate analysemodule_output;
truncate collector_series_status;
truncate collector_study_status;
truncate gewenste_processen;
truncate resultaten_boolean;
truncate resultaten_floating;
truncate resultaten_object;
truncate resultaten_char;
truncate resultaten_status;
SET FOREIGN_KEY_CHECKS=1;
*/



/////////////////////////////////////////////////////////////////////
// action 3:
// zoek studies waarvoor op study/series/instance level geen entry in gewenste processen tabel zitten
$study_Stmt="
 select study.*,patient.pat_name,patient.pat_id
 from study
  inner join patient on study.patient_fk=patient.pk
  left outer join series on study.pk=series.study_fk
  left outer join instance on series.pk=instance.series_fk
  left outer join gewenste_processen
   on gewenste_processen.study_fk=study.pk or
      gewenste_processen.series_fk=series.pk or
      gewenste_processen.instance_fk=instance.pk
 where
  gewenste_processen.study_fk is null and
  gewenste_processen.series_fk is null and
  gewenste_processen.instance_fk is null
 group by study.pk
";

// check studie nog in dcm4chee db staat (ivm deleten in iqc)
$study_dcm4chee_Stmt="
 select * from study where study.pk=%s
";

// delete studies (gerelateerde series/instances/files/collector_study_status/collector_series_status
//                 worden automatisch "on cascade" ook weggehaald)
$delete_study_Stmt="delete from study where study.pk in (%s)";



/////////////////////////////////////////////////////////////////////

$gewenste_processen_failed_Stmt="select * from gewenste_processen where status!=5";

/////////////////////////////////////////////////////////////////////
// action 4:

// zoek patienten waarvoor op study/series/instance level geen entry in gewenste processen tabel zitten
$patient_Stmt="
 select patient.pk,patient.pat_name,patient.pat_id,
        count(distinct study.pk) as nr_studies,
        count(distinct series.pk) as nr_series,
        count(distinct instance.pk) as nr_instances
 from patient
  left outer join study on patient.pk=study.patient_fk
  left outer join series on study.pk=series.study_fk
  left outer join instance on series.pk=instance.series_fk
  left outer join gewenste_processen
   on gewenste_processen.study_fk=study.pk or
      gewenste_processen.series_fk=series.pk or
      gewenste_processen.instance_fk=instance.pk
 where
  gewenste_processen.study_fk is null and
  gewenste_processen.series_fk is null and
  gewenste_processen.instance_fk is null
 group by patient.pk
";


// check studie nog in dcm4chee db staat (ivm deleten in iqc)
$patient_dcm4chee_Stmt="
 select * from patient where patient.pk=%s
";

// delete patienten (gerelateerde studies/series/instances/files/collector_study_status/collector_series_status
//                   worden automatisch "on cascade" ook weggehaald)
$delete_patient_Stmt="delete from patient where patient.pk in (%s)";



/////////////////////////////////////////////////////////////////////
// action 5:

$gewenste_processen_no_results_Stmt="
 select gewenste_processen.pk
 from gewenste_processen
  left outer join resultaten_floating on gewenste_processen.pk=resultaten_floating.gewenste_processen_fk
  left outer join resultaten_char     on gewenste_processen.pk=resultaten_char.gewenste_processen_fk
  left outer join resultaten_object   on gewenste_processen.pk=resultaten_object.gewenste_processen_fk
  left outer join resultaten_boolean  on gewenste_processen.pk=resultaten_boolean.gewenste_processen_fk
  where
    resultaten_floating.gewenste_processen_fk is null and
    resultaten_char.gewenste_processen_fk is null and
    resultaten_object.gewenste_processen_fk is null and
    resultaten_boolean.gewenste_processen_fk is null
";

$delete_processen_no_results_Stmt="
 delete gewenste_processen
 from gewenste_processen
  left outer join resultaten_floating on gewenste_processen.pk=resultaten_floating.gewenste_processen_fk
  left outer join resultaten_char     on gewenste_processen.pk=resultaten_char.gewenste_processen_fk
  left outer join resultaten_object   on gewenste_processen.pk=resultaten_object.gewenste_processen_fk
  left outer join resultaten_boolean  on gewenste_processen.pk=resultaten_boolean.gewenste_processen_fk
  where
    resultaten_floating.gewenste_processen_fk is null and
    resultaten_char.gewenste_processen_fk is null and
    resultaten_object.gewenste_processen_fk is null and
    resultaten_boolean.gewenste_processen_fk is null
";

/////////////////////////////////////////////////////////////////////
// action 6:

//$delete_gewenst_proces_incl_results_Stmt="delete from gewenste_processen where pk=%d";




// Connect to the IQC Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


// db_action vanuit dropdown box
if (!empty($_GET['db_action']))
{
  $db_action=$_GET['db_action'];
}

// voer POST opdracht uit
if (!empty($_POST))
{
  $db_action=$_POST['db_action'];
  $confirm_action=$_POST['confirm_action'];
  //var_dump($_POST);
}


$table_output='';

switch ($db_action) {

   case 0:
        break;
   case 1:
        if(!empty($confirm_action)) {
           if (!empty($_POST['selector'])) {
              $selectors=$_POST['selector'];
              $selector_ref_key=array_keys($selectors);
           }
           $selector_list=implode(",",$selector_ref_key);

           if(empty($selector_list)) {
              $main_page->assign("action_result",'Geen studies geselecteerd');
              $db_action=0;
           } else {

              // actie is bevestigd en studielijst bevat pk's dus deleten maar...
              if (!($result=$link->query(sprintf($delete_selector_results_Stmt,$selector_list)))) {
                 DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($delete_selector_results_Stmt,$selector_list))) ;
                 DisplayErrMsg(sprintf("error: %s", $link->error)) ;
                 exit() ;
              }

              $main_page->assign("action_result",'Resultaten zijn verwijderd');
              $db_action=0;
           }
        } else {

           $main_page->assign("action_text",'Selectie');
           $main_page->assign("action_name",'Verwijder resultaten');

           if (!($result_selector= $link->query($selector_Stmt))) {
              DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt)) ;
              DisplayErrMsg(sprintf("error: %s", $link->error)) ;
              exit() ;
           }

           $j=0;
           while (($field_selector = $result_selector->fetch_object()))
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
                $table_output=$table_data->fetch("beheer_db_action1_header.tpl");
              }

              $table_data->assign("bgcolor",$bgcolor);
              $table_data->assign("selector",$field_selector->name);
              $table_data->assign("description",$field_selector->description);
              $checkbox_name=sprintf("selector[%d]",$field_selector->pk);
              $main_page->assign("toggle",1);
              $table_data->assign("checkbox_name",$checkbox_name);

              $table_output.=$table_data->fetch("beheer_db_action1_row.tpl");

              $j++;
           }
        }
        break;
   case 2:
        if(!empty($confirm_action)) {
           // FIXME
           $main_page->assign("action_result",'Database is geinitialiseerd');
           $db_action=0;
        } else {
           $main_page->assign("action_text",'Weet u het heel zeker?');
           $main_page->assign("action_name",'Initialiseer DB');
        }
        break;
   case 3:
        if(!empty($confirm_action)) {

           if (!empty($_POST['study']))
           {
              $studies=$_POST['study'];
              $study_ref_key=array_keys($studies);
           }

           $study_list=implode(",",$study_ref_key);
           if(empty($study_list)) {
              $main_page->assign("action_result",'Geen studies geselecteerd');
              $db_action=0;
           } else {
              // actie is bevestigd en studielijst bevat pk's dus deleten maar...
              if (!($link->query(sprintf($delete_study_Stmt,$study_list)))) {
                 DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($delete_study_Stmt,$study_list))) ;
                 DisplayErrMsg(sprintf("error: %s", $link->error)) ;
                 exit() ;
              }

              $main_page->assign("action_result",'Studies/series/instances/collector_*_status entries zijn verwijderd');
              $db_action=0;
           }
        } else {
           $main_page->assign("action_text",'Selectie');
           $main_page->assign("action_name",'Verwijder studies');

           if (!($result_studies=$link->query($study_Stmt))) {
              DisplayErrMsg(sprintf("Error in executing %s stmt", $study_Stmt)) ;
              DisplayErrMsg(sprintf("error: %s", $link->error)) ;
              exit();
           }

           $result_output = 'Aantal gevonden studies: ' . $result_studies->num_rows . '<br/>';

           // check of deze studies nog in de dcm4chee db staan
           // Connect to the IQC Database
           $link_dcm4chee = new mysqli($hostName_dcm4chee, $userName_dcm4chee, $password_dcm4chee, $databaseName_dcm4chee);

           // check connection
           if (mysqli_connect_errno()) {
              printf("Connect failed: %s\n", mysqli_connect_error());
              exit();
           }

           $result_output .= 'N.B. studies moeten eerst uit DCM4CHEE worden verwijderd!<br/>';
           $main_page->assign("action_result",$result_output);

           $j=0;
           while ($field_study = $result_studies->fetch_object())
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
                $table_output=$table_data->fetch("beheer_db_action3_header.tpl");
              }

              $table_data->assign("bgcolor",$bgcolor);
              $table_data->assign("patient_name",$field_study->pat_name);
              $table_data->assign("patient_id",$field_study->pat_id);
              $table_data->assign("study_description",$field_study->study_desc);
              $checkbox_name=sprintf("study[%d]",$field_study->pk);
              $table_data->assign("checkbox_name",$checkbox_name);
              $main_page->assign("toggle",1);
              $table_data->assign("study_datetime",$field_study->study_datetime);
              $table_data->assign("accession_number",$field_study->accession_no);
              //$table_data->assign("status",$field_collector_study->omschrijving);


              if (!($result_studies_dcm4chee=$link_dcm4chee->query(sprintf($study_dcm4chee_Stmt,$field_study->pk)))) {
                 DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($study_dcm4chee_Stmt,$study_list))) ;
                 DisplayErrMsg(sprintf("error: %s", $link->error)) ;
                 exit();
              }
              if($result_studies_dcm4chee->num_rows>0) {
                 $dcm4chee_status='aanwezig';
              } else {
                 $dcm4chee_status='niet aanwezig';
              }

              $result_studies_dcm4chee->close();

              $table_data->assign("dcm4chee_status",$dcm4chee_status);

              $table_output.=$table_data->fetch("beheer_db_action3_row.tpl");

              $j++;
           }

           $result_studies->close();

        }
        break;
   case 4:
        if(!empty($confirm_action)) {

           if (!empty($_POST['patient']))
           {
              $patients=$_POST['patient'];
              $patient_ref_key=array_keys($patients);
           }

           $patient_list=implode(",",$patient_ref_key);
           if(empty($patient_list)) {
              $main_page->assign("action_result",'Geen patienten geselecteerd');
              $db_action=0;
           } else {
              // actie is bevestigd en patientenlijst bevat pk's dus deleten maar...
              if (!($link->query(sprintf($delete_patient_Stmt,$patient_list)))) {
                 DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($delete_patient_Stmt,$patient_list))) ;
                 DisplayErrMsg(sprintf("error: %s", $link->error)) ;
                 exit() ;
              }

              $main_page->assign("action_result",'Patient/studies/series/instances/collector_*_status entries zijn verwijderd');
              $db_action=0;
           }
        } else {
           $main_page->assign("action_text",'Selectie');
           $main_page->assign("action_name",'Verwijder patienten');

           if (!($result_patients=$link->query($patient_Stmt))) {
              DisplayErrMsg(sprintf("Error in executing %s stmt", $patient_Stmt)) ;
              DisplayErrMsg(sprintf("error: %s", $link->error)) ;
              exit();
           }

           $result_output = 'Aantal gevonden patienten: ' . $result_patients->num_rows . '<br/>';

           // check of deze patienten nog in de dcm4chee db staan
           // Connect to the IQC Database
           $link_dcm4chee = new mysqli($hostName_dcm4chee, $userName_dcm4chee, $password_dcm4chee, $databaseName_dcm4chee);

           // check connection
           if (mysqli_connect_errno()) {
              printf("Connect failed: %s\n", mysqli_connect_error());
              exit();
           }

           $result_output .= 'N.B. patienten moeten eerst uit DCM4CHEE worden verwijderd!<br/>';
           $main_page->assign("action_result",$result_output);

           $j=0;
           while ($field_patient = $result_patients->fetch_object())
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
                $table_output=$table_data->fetch("beheer_db_action4_header.tpl");
              }

              $table_data->assign("bgcolor",$bgcolor);
              $table_data->assign("patient_name",$field_patient->pat_name);
              $table_data->assign("patient_id",$field_patient->pat_id);
              $checkbox_name=sprintf("patient[%d]",$field_patient->pk);
              $table_data->assign("checkbox_name",$checkbox_name);
              $main_page->assign("toggle",1);
              $table_data->assign("nr_studies",$field_patient->nr_studies);
              $table_data->assign("nr_series",$field_patient->nr_series);
              $table_data->assign("nr_instances",$field_patient->nr_instances);


              if (!($result_patients_dcm4chee=$link_dcm4chee->query(sprintf($patient_dcm4chee_Stmt,$field_patient->pk)))) {
                 DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($patient_dcm4chee_Stmt,$patient_list))) ;
                 DisplayErrMsg(sprintf("error: %s", $link->error)) ;
                 exit();
              }
              if($result_patients_dcm4chee->num_rows>0) {
                 $dcm4chee_status='aanwezig';
              } else {
                 $dcm4chee_status='niet aanwezig';
              }

              $result_patients_dcm4chee->close();

              $table_data->assign("dcm4chee_status",$dcm4chee_status);

              $table_output.=$table_data->fetch("beheer_db_action4_row.tpl");

              $j++;
           }

           $result_patients->close();

        }
        break;
   case 5:
        if(!empty($confirm_action)) {

           // actie is bevestigd en dus deleten maar...
           if (!($link->query($delete_processen_no_results_Stmt))) {
              DisplayErrMsg(sprintf("Error in executing %s stmt", $delete_processen_no_results_Stmt)) ;
              DisplayErrMsg(sprintf("error: %s", $link->error)) ;
              exit() ;
           }

           $main_page->assign("action_result",'Gewenste processen zijn verwijderd');
           $db_action=0;
        } else {

           $main_page->assign("action_text",'Weet u het heel zeker?');
           $main_page->assign("action_name",'Verwijder');

           if (!($result=$link->query($gewenste_processen_no_results_Stmt))) {
              DisplayErrMsg(sprintf("Error in executing %s stmt", $gewenste_processen_no_results_Stmt)) ;
              DisplayErrMsg(sprintf("error: %s", $link->error)) ;
              exit() ;
           }

           $main_page->assign("action_result",'Aantal gewenste processen zonder resultaten: ' . $result->num_rows . '<br/>');

           $result->close();

        }
        break;
   case 6:
        if(!empty($confirm_action)) {
           // FIXME
           $main_page->assign("action_result",'Gewenst proces incl resultaten verwijderd');
           $db_action=0;
        } else {
           $main_page->assign("action_text",'Weet u het heel zeker?');
           $main_page->assign("action_name",'Verwijder');
        }
        break;
   default:
        break;
}



$table_data = new Smarty_NM();
$table_data->assign("db_action_options",$db_action_list);
$table_data->assign("db_action_select",$db_action);

$action_list=$table_data->fetch("beheer_db_dropdown.tpl");



$main_page->assign("form_action",sprintf("beheer_db.php?db_action=%s",$db_action));
$main_page->assign("action_list",$action_list);
$main_page->assign("table_list",$table_output);

$main_page->display("beheer_db.tpl");

?>
