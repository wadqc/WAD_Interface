<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_study='study';
$table_series='series';
$table_instance='instance';

$table_resultaten_floating='resultaten_floating';
$table_resultaten_char='resultaten_char';
$table_resultaten_object='resultaten_object';
$table_gewenste_processen='gewenste_processen';
$table_selector='selector';


$v=$_GET['v'];
$selector_fk=0;
if (!empty($_GET['selector_fk']))
{
  $selector_fk=$_GET['selector_fk'];
}


$omschrijving_char="%";
if (!empty($_GET['omschrijving_char']))
{
  $omschrijving_char=$_GET['omschrijving_char'];
}



$analyse_level='';
if (!empty($_GET['analyse_level']))
{
  $analyse_level=$_GET['analyse_level'];
}

if (!empty($_GET['status']))
{
  $status=$_GET['status'];
}
if (!empty($_POST['status']))
{
  $status=$_POST['status'];
}

if ($analyse_level=='study')
{
$results_char_Stmt="SELECT  
$table_study.study_datetime as 'date_time',
$table_resultaten_char.omschrijving as 'omschrijving',
$table_resultaten_char.volgnummer as 'volgnummer',
$table_resultaten_char.criterium as 'criterium',
$table_resultaten_char.waarde as 'waarde'
from $table_study inner join (
  $table_gewenste_processen inner join $table_resultaten_char 
  on $table_gewenste_processen.pk=$table_resultaten_char.gewenste_processen_fk
) on $table_study.pk=$table_gewenste_processen.study_fk 
where 
$table_gewenste_processen.selector_fk=$selector_fk 
and $table_gewenste_processen.status in ($status) 
and $table_resultaten_char.omschrijving like '$omschrijving_char' 
order by date_time desc, $table_resultaten_char.volgnummer asc";
}

if ($analyse_level=='series')
{
$results_char_Stmt="SELECT  
$table_instance.content_datetime as 'date_time',
$table_resultaten_char.omschrijving as 'omschrijving',
$table_resultaten_char.volgnummer as 'volgnummer',
$table_resultaten_char.criterium as 'criterium',
$table_resultaten_char.waarde as 'waarde'
from 
$table_instance inner join (
  $table_series inner join (
    $table_gewenste_processen inner join $table_resultaten_char 
    on $table_gewenste_processen.pk=$table_resultaten_char.gewenste_processen_fk
  ) on $table_series.pk=$table_gewenste_processen.series_fk
) on series.pk=$table_instance.series_fk
where 
$table_gewenste_processen.selector_fk=$selector_fk 
and $table_gewenste_processen.status in ($status) 
and $table_resultaten_char.omschrijving like '$omschrijving_char' 
and $table_instance.pk=(select min(pk) from $table_instance where series_fk=series.pk)
order by date_time desc, $table_resultaten_char.volgnummer asc";
}

if ($analyse_level=='instance')
{
$results_char_Stmt="SELECT  
$table_instance.content_datetime as 'date_time',
$table_resultaten_char.omschrijving as 'omschrijving',
$table_resultaten_char.volgnummer as 'volgnummer',
$table_resultaten_char.criterium as 'criterium',
$table_resultaten_char.waarde as 'waarde'
from 
$table_instance inner join (
    $table_gewenste_processen inner join $table_resultaten_char 
    on $table_gewenste_processen.pk=$table_resultaten_char.gewenste_processen_fk
  ) on $table_instance.pk=$table_gewenste_processen.instance_fk
where 
$table_gewenste_processen.selector_fk=$selector_fk 
and $table_gewenste_processen.status in ($status) 
and $table_resultaten_char.omschrijving like '$omschrijving_char' 
order by date_time desc";
}

  
/*$results_char_Stmt="SELECT  * from $table_gewenste_processen inner join $table_resultaten_char on $table_gewenste_processen.pk=$table_resultaten_char.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.status in ($status)
and $table_resultaten_char.omschrijving like '$omschrijving_char'
order by $table_gewenste_processen.pk, $table_resultaten_char.volgnummer";
*/


$selector_Stmt="SELECT * from $table_selector
where $table_selector.pk=$selector_fk"; 

$gewenste_processen_Stmt="SELECT * from $table_gewenste_processen
where $table_gewenste_processen.selector_fk=$selector_fk
order by $table_gewenste_processen.pk";

// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}




if (!($result_char= $link->query(sprintf($results_char_Stmt,$gewenste_processen_id)))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_char_Stmt,$gewenste_processen_id)) );
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}


if (!($result_selector= $link->query($selector_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}


$field_results = $result_selector->fetch_object();
$header_result=sprintf("Selector: %s, analyse level: %s",$field_results->name,$field_results->analyselevel);
$result_selector->close();  







$table_resultaten_char='';


$j=0;
while (($field_results = $result_char->fetch_object()))
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
     $table_resultaten_char=$table_data->fetch("resultaten_char_header.tpl");
   }

   //$action_char=sprintf("show_results.php?selector_fk=%d&gewenste_processen_id=0&omschrijving_char=%s&t=%d",$selector_fk,$field_results->omschrijving,time()); 

     
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("datum",$field_results->date_time);
   $table_data->assign("omschrijving",$field_results->omschrijving);
   $table_data->assign("criterium",$field_results->criterium);
   $table_data->assign("waarde_class","table_data");
   $table_data->assign("waarde",$field_results->waarde);
   
   if ($field_results->criterium != '')
   {
     $table_data->assign("waarde_class","table_data_green"); // default is green if criterium is defined
   }
   //if ( ($field_results->criterium=='') and ($field_results->waarde!=$field_results->criterium) )
   //{
   //  $table_data->assign("waarde_class","table_data_orange"); // assign is criterium not given, but value is
   //} 
   if ( ($field_results->criterium!='') and ($field_results->waarde!=$field_results->criterium) )
   {
     $table_data->assign("waarde_class","table_data_red");
   } 
         
   $table_resultaten_char.=$table_data->fetch("resultaten_char_value_row.tpl");

   $j++;
}




$data = new Smarty_NM();
$data->assign("Title","Results");

$data->assign("header_result",$header_result);


if ($table_resultaten_char!='')
{
  $data->assign("header_value","Resultaten char");
  $data->assign("resultaten_value_list",$table_resultaten_char);
}

//$action_result=sprintf("show_results.php?selector_fk=%d&analyse_level=%s&t=%d",$selector_fk,$analyselevel,time()); 
//$data->assign("action_result",$action_result);

$data->display("resultaten_result_value.tpl");







?>
