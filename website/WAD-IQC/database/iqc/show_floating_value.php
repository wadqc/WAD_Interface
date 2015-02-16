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
$omschrijving="%";
if (!empty($_GET['omschrijving']))
{
  $omschrijving=$_GET['omschrijving'];
}
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

$omschrijving_char="%%";
if (!empty($_GET['omschrijving_char']))
{
  $omschrijving_char=$_GET['omschrijving_char'];
}




$analyse_level='';
if (!empty($_GET['analyse_level']))
{
  $analyse_level=$_GET['analyse_level'];
}

$status='';
if (!empty($_GET['status']))
{
  $status=$_GET['status'];
}



if ($analyse_level=='study')
{
  
$results_floating_Stmt="SELECT $table_study.study_datetime as 'date_time', $table_resultaten_floating.omschrijving as 'omschrijving', $table_resultaten_floating.grootheid as 'grootheid', $table_resultaten_floating.eenheid as 'eenheid', $table_resultaten_floating.grens_kritisch_boven as 'grens_kritisch_boven', $table_resultaten_floating.grens_kritisch_onder as 'grens_kritisch_onder', $table_resultaten_floating.grens_acceptabel_boven as 'grens_acceptabel_boven', $table_resultaten_floating.grens_acceptabel_onder as 'grens_acceptabel_onder', $table_resultaten_floating.waarde as 'waarde' from $table_study inner join ($table_gewenste_processen inner join $table_resultaten_floating on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk) on $table_study.pk=$table_gewenste_processen.study_fk 
where $table_gewenste_processen.selector_fk=$selector_fk 
and $table_gewenste_processen.status in ($status) 
and $table_resultaten_floating.omschrijving like '$omschrijving'
and $table_resultaten_floating.grootheid like '$grootheid' 
and $table_resultaten_floating.eenheid like '$eenheid' 
order by date_time desc";

}



if ($analyse_level=='series')
{

$results_floating_Stmt="SELECT $table_instance.content_datetime as 'date_time', $table_resultaten_floating.omschrijving as 'omschrijving', $table_resultaten_floating.grootheid as 'grootheid', $table_resultaten_floating.eenheid as 'eenheid', $table_resultaten_floating.grens_kritisch_boven as 'grens_kritisch_boven', $table_resultaten_floating.grens_kritisch_onder as 'grens_kritisch_onder', $table_resultaten_floating.grens_acceptabel_boven as 'grens_acceptabel_boven', $table_resultaten_floating.grens_acceptabel_onder as 'grens_acceptabel_onder', $table_resultaten_floating.waarde as 'waarde' from $table_series inner join ($table_gewenste_processen inner join $table_resultaten_floating on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk) on $table_series.pk=$table_gewenste_processen.series_fk, $table_instance 
where $table_gewenste_processen.selector_fk=$selector_fk 
and $table_series.pk=$table_instance.series_fk
and $table_gewenste_processen.status in ($status) 
and $table_resultaten_floating.omschrijving like '$omschrijving'
and $table_resultaten_floating.grootheid like '$grootheid' 
and $table_resultaten_floating.eenheid like '$eenheid' 
and $table_instance.pk=(select min(pk) from $table_instance where series_fk=$table_series.pk) 
order by date_time desc";

}


if ($analyse_level=='instance')
{
  
$results_floating_Stmt="SELECT $table_instance.content_datetime as 'date_time', $table_resultaten_floating.omschrijving as 'omschrijving', $table_resultaten_floating.grootheid as 'grootheid', $table_resultaten_floating.eenheid as 'eenheid', $table_resultaten_floating.grens_kritisch_boven as 'grens_kritisch_boven', $table_resultaten_floating.grens_kritisch_onder as 'grens_kritisch_onder', $table_resultaten_floating.grens_acceptabel_boven as 'grens_acceptabel_boven', $table_resultaten_floating.grens_acceptabel_onder as 'grens_acceptabel_onder', $table_resultaten_floating.waarde as 'waarde' from $table_instance inner join ($table_gewenste_processen inner join $table_resultaten_floating on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk) on $table_instance.pk=$table_gewenste_processen.instance_fk 
where $table_gewenste_processen.selector_fk=$selector_fk 
and $table_gewenste_processen.status in ($status) 
and $table_resultaten_floating.omschrijving like '$omschrijving'
and $table_resultaten_floating.grootheid like '$grootheid' 
and $table_resultaten_floating.eenheid like '$eenheid' 
order by date_time";

}



$selector_Stmt="SELECT * from $table_selector
where $table_selector.pk=$selector_fk"; 


// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}




if (!($result_floating= $link->query($results_floating_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $results_floating_Stmt) );
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



$grens_kritisch_boven_visible='false';
$grens_kritisch_onder_visible='false';
$grens_acceptabel_boven_visible='false';
$grens_acceptabel_onder_visible='false';


$table_resultaten_floating='';


$j=0;
while (($field_results = $result_floating->fetch_object()))
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
     $table_resultaten_floating=$table_data->fetch("resultaten_floating_value_header.tpl");
   }

        
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("datum",$field_results->date_time);
   $table_data->assign("omschrijving",$field_results->omschrijving);
   $table_data->assign("grootheid",$field_results->grootheid);
   $table_data->assign("eenheid",$field_results->eenheid);
   $table_data->assign("waarde",$field_results->waarde);
   $table_data->assign("waarde_class","table_data");
   
   if ( !is_null($field_results->grens_kritisch_boven) and !is_null($field_results->grens_kritisch_onder) )
   {
     $table_data->assign("waarde_class","table_data_green");
   } 
   if (  ( ($field_results->waarde >= $field_results->grens_kritisch_boven) or ($field_results->waarde <= $field_results->grens_kritisch_onder) ) and (($field_results->grens_kritisch_boven!='') and !is_null($field_results->grens_kritisch_onder) ) )
   {
     $table_data->assign("waarde_class","table_data_red");
   } 
   if ( ( ($field_results->waarde >= $field_results->grens_acceptabel_boven) and ($field_results->waarde < $field_results->grens_kritisch_boven) ) and (($field_results->grens_acceptabel_boven!='') and !is_null($field_results->grens_kritisch_boven) ) )
   {
     $table_data->assign("waarde_class","table_data_orange");
   }
   if ( ( ($field_results->waarde > $field_results->grens_kritisch_onder) and ($field_results->waarde <= $field_results->grens_acceptabel_onder) ) and (($field_results->grens_kritisch_onder!='') and !is_null($field_results->grens_acceptabel_onder) ) ) 
   {
     $table_data->assign("waarde_class","table_data_orange");
   }


   $table_data->assign("kritisch_onder",$field_results->grens_kritisch_onder);
   $table_data->assign("kritisch_boven",$field_results->grens_kritisch_boven);
   $table_data->assign("acceptabel_onder",$field_results->grens_acceptabel_onder);
   $table_data->assign("acceptabel_boven",$field_results->grens_acceptabel_boven);

      
   $table_resultaten_floating.=$table_data->fetch("resultaten_floating_value_row.tpl");
   
   if (!is_null($field_results->grens_kritisch_boven) and ($grens_kritisch_boven_visible=='false') )  
   {
      $grens_kritisch_boven_visible='true';
   }
   if (!is_null($field_results->grens_kritisch_onder) and ($grens_kritisch_onder_visible=='false') ) 
   {
       $grens_kritisch_onder_visible='true';
   }
   if (!is_null($field_results->grens_acceptabel_boven) and ($grens_acceptabel_boven_visible=='false') ) 
   {
       $grens_acceptabel_boven_visible='true';
   }
   if (!is_null($field_results->grens_acceptabel_onder) and ($grens_acceptabel_onder_visible=='false') ) 
   {
      $grens_acceptabel_onder_visible='true';
   }



   $j++;
  
}


$result_floating->close();  




$data = new Smarty_NM();
$data->assign("Title","Results");
$data->assign("selection_list",$selector_list);
$data->assign("header_result",$header_result);
$data->assign("header_value","Resultaten floating");
$data->assign("picture_src","./logo_pictures/excel.jpg");
$export_action=sprintf("export_floating_value.php?selector_fk=%d&status=%d&analyse_level=%s&omschrijving=%s&grootheid=%s&eenheid=%s&t=%d",$selector_fk,$status,$analyse_level,$omschrijving,$grootheid,$eenheid ,time());
$action_page=sprintf("data_floating.php?selector_fk=%d&status=%s&analyse_level=%s&omschrijving=%s&grootheid=%s&eenheid=%s&t=%d",$selector_fk,$status,$analyse_level,$omschrijving,$grootheid,$eenheid ,time());
//printf("data_floating.php?selector_fk=%d&status=%s&analyse_level=%s&omschrijving=%s&grootheid=%s&eenheid=%s&t=%d",$selector_fk,$status,$analyse_level,$omschrijving,$grootheid,$eenheid ,time());
//exit();

$data->assign("export_action",$export_action);
$data->assign("action_page",$action_page);
$data->assign("grens_kritisch_boven_visible",$grens_kritisch_boven_visible);
$data->assign("grens_kritisch_onder_visible",$grens_kritisch_onder_visible);
$data->assign("grens_acceptabel_boven_visible",$grens_acceptabel_boven_visible);
$data->assign("grens_acceptabel_onder_visible",$grens_acceptabel_onder_visible);

if ($table_resultaten_floating!='')
{
  $data->assign("header_value","Resultaten floating");
  $data->assign("resultaten_value_list",$table_resultaten_floating);
}

//$action_result=sprintf("show_results.php?selector_fk=%d&analyse_level=%s&t=%d",$selector_fk,$analyselevel,time()); 
//$data->assign("action_result",$action_result);

$data->display("data_floating_highcharts.tpl");

//$data->display("resultaten_result_value.tpl");





?>
