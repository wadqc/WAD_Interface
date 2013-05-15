<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_study='study';
$table_series='series';
$table_instance='instance';



$table_resultaten_floating='resultaten_floating';
$table_resultaten_char='resultaten_char';
$table_resultaten_boolean='resultaten_boolean';
$table_resultaten_object='resultaten_object';
$table_gewenste_processen='gewenste_processen';
$table_selector='selector';


$v=$_GET['v'];
$selector_fk=0;
if (!empty($_GET['selector_fk']))
{
  $selector_fk=$_GET['selector_fk'];
}
$omschrijving="%%";
if (!empty($_GET['omschrijving']))
{
  $omschrijving=$_GET['omschrijving'];
}
$grootheid="%%";
if (!empty($_GET['grootheid']))
{
  $grootheid=$_GET['grootheid'];
}
$eenheid="%%";
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

$niveau=1;
if (!empty($_POST['niveau']))
{
  $niveau=$_POST['niveau'];
}


$gewenste_processen_id=0;
if (!empty($_POST['gewenste_processen_id']))
{
  $gewenste_processen_id=$_POST['gewenste_processen_id'];
}
if (!empty($_GET['gewenste_processen_id']))
{
  $gewenste_processen_id=$_GET['gewenste_processen_id'];
}





$results_floating_Stmt="SELECT * from $table_gewenste_processen inner join $table_resultaten_floating on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk 
and $table_gewenste_processen.pk='%s' 
and $table_resultaten_floating.niveau like '$niveau'
and $table_resultaten_floating.omschrijving like '$omschrijving'
and $table_resultaten_floating.grootheid like '$grootheid' 
and $table_resultaten_floating.eenheid like '$eenheid' 
order by $table_gewenste_processen.pk, $table_resultaten_floating.volgnummer";
  
$results_char_Stmt="SELECT  * from $table_gewenste_processen inner join $table_resultaten_char on $table_gewenste_processen.pk=$table_resultaten_char.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%s'
and $table_resultaten_char.niveau like '$niveau' 
and $table_resultaten_char.omschrijving like '$omschrijving_char'
order by $table_gewenste_processen.pk, $table_resultaten_char.volgnummer";

$results_boolean_Stmt="SELECT  * from $table_gewenste_processen inner join $table_resultaten_boolean on $table_gewenste_processen.pk=$table_resultaten_boolean.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%s'
and $table_resultaten_boolean.niveau like '$niveau' 
and $table_resultaten_boolean.omschrijving like '$omschrijving_char'
order by $table_gewenste_processen.pk, $table_resultaten_boolean.volgnummer";


$results_object_Stmt="SELECT  $table_resultaten_object.object_naam_pad as 'object_naam_pad', $table_resultaten_object.omschrijving as 'omschrijving', $table_resultaten_object.pk as 'pk' from $table_gewenste_processen inner join $table_resultaten_object on $table_gewenste_processen.pk=$table_resultaten_object.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%s' 
and $table_resultaten_object.niveau like '$niveau'
order by $table_gewenste_processen.pk, $table_resultaten_object.volgnummer";
//and $table_resultaten_object.omschrijving like '$omschrijving_object'

$year_Stmt_study="SELECT $table_gewenste_processen.pk as 'pk', $table_study.study_datetime as 'date_time' from $table_gewenste_processen inner join $table_study on $table_gewenste_processen.study_fk=$table_study.pk where $table_gewenste_processen.selector_fk=$selector_fk
order by $table_study.study_datetime desc";

$year_Stmt_series="SELECT $table_gewenste_processen.pk as 'pk', $table_series.pps_start as 'date_time' from $table_gewenste_processen inner join $table_series on $table_gewenste_processen.series_fk=$table_series.pk where $table_gewenste_processen.selector_fk=$selector_fk
order by $table_series.pps_start desc";

$year_Stmt_instance="SELECT $table_gewenste_processen.pk as 'pk', $table_instance.content_datetime as 'date_time' from $table_gewenste_processen inner join $table_instance on $table_gewenste_processen.study_fk=$table_instance.pk where $table_gewenste_processen.selector_fk=$selector_fk
order by $table_instance.content_datetime desc";


$selector_Stmt="SELECT * from $table_selector
where $table_selector.pk=$selector_fk"; 


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



$list_year='';

if ($analyse_level=='study')
{
  if (!($result_year= mysql_query($year_Stmt_study, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  $counter=0;

  while($field = mysql_fetch_object($result_year))
  {
    if (($counter==0)&&($gewenste_processen_id==-1)) //first visit, id will be changed to the id that is linked to the most recent date of study
    {
      $gewenste_processen_id=$field->pk;
    }   
    if ($field->pk== $gewenste_processen_id)
    {
       $date_result=$field->date_time;
    }  
    $list_year["$field->pk"]="$field->date_time";
    $counter++;
  } 
  mysql_free_result($result_year);
}

if ($analyse_level=='series')
{
  if (!($result_year= mysql_query($year_Stmt_series, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  $counter=0;

  while($field = mysql_fetch_object($result_year))
  {
    if (($counter==0)&&($gewenste_processen_id==-1)) //first visit, id will be changed to the id that is linked to the most recent date of study
    {
      $gewenste_processen_id=$field->pk;
    }    
    if ($field->pk== $gewenste_processen_id)
    {
       $date_result=$field->date_time;
    } 
    $list_year["$field->pk"]="$field->date_time";
    $counter++;
  } 
  mysql_free_result($result_year);
}

if ($analyse_level=='instance')
{
  if (!($result_year= mysql_query($year_Stmt_instance, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  $counter=0;

  while($field = mysql_fetch_object($result_year))
  {
    if (($counter==0)&&($gewenste_processen_id==-1)) //first visit, id will be changed to the id that is linked to the most recent date of study
    {
      $gewenste_processen_id=$field->pk;
    }
    if ($field->pk== $gewenste_processen_id)
    {
       $date_result=$field->date_time;
    } 
    $list_year["$field->pk"]="$field->date_time";
    $counter++;
  } 
  mysql_free_result($result_year);
}




if (!($result_floating= mysql_query(sprintf($results_floating_Stmt,$gewenste_processen_id), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_floating_Stmt,$gewenste_processen_id)) );
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_char= mysql_query(sprintf($results_char_Stmt,$gewenste_processen_id), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_char_Stmt,$gewenste_processen_id)) );
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_boolean= mysql_query(sprintf($results_boolean_Stmt,$gewenste_processen_id), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_boolean_Stmt,$gewenste_processen_id)) );
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_object= mysql_query(sprintf($results_object_Stmt,$gewenste_processen_id), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_object_Stmt,$gewenste_processen_id)) );
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


if (!($result_selector= mysql_query($selector_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


$field_results = mysql_fetch_object($result_selector);
$header_result=sprintf("Selector: %s, analyse level: %s",$field_results->name,$field_results->analyselevel);
mysql_free_result($result_selector);  




$list_niveau[1]='1';
$list_niveau[2]='2';

$table_data = new Smarty_NM();
$table_data->assign("processen_options",$list_year);
$table_data->assign("processen_id",$gewenste_processen_id);

$table_data->assign("niveau_options",$list_niveau);
$table_data->assign("niveau_id",$niveau);

$selector_list=$table_data->fetch("selector_select.tpl");



////new
$action='';
$datum='';
$type='';
$omschrijving='';
$grootheid='';
$eenheid='';
$waarde='';
$grens_kritisch_boven='';
$grens_kritisch_onder='';
$grens_acceptabel_boven='';
$grens_acceptabel_onder='';
$type='';


$j=0;
while (($field_results = mysql_fetch_object($result_floating)))
{
  
   $action[$field_results->volgnummer]=sprintf("show_floating_value.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=0&omschrijving=%s&grootheid=%s&eenheid=%s&t=%d",$selector_fk,$analyse_level,$field_results->omschrijving,$field_results->grootheid,$field_results->eenheid ,time()); 
   $datum[$field_results->volgnummer]=$date_result;
   $omschrijving[$field_results->volgnummer]=$field_results->omschrijving;
   $grootheid[$field_results->volgnummer]=$field_results->grootheid;
   $eenheid[$field_results->volgnummer]=$field_results->eenheid;
   $waarde[$field_results->volgnummer]=$field_results->waarde;
   $grens_kritisch_boven[$field_results->volgnummer]=$field_results->grens_kritisch_boven;
   $grens_kritisch_onder[$field_results->volgnummer]=$field_results->grens_kritisch_onder;
   $grens_acceptabel_boven[$field_results->volgnummer]=$field_results->grens_acceptabel_boven;
   $grens_acceptabel_onder[$field_results->volgnummer]=$field_results->grens_acceptabel_onder;
   $type[$field_results->volgnummer]='floating';

}


mysql_free_result($result_floating); 

while (($field_results = mysql_fetch_object($result_char)))
{
  
   $action[$field_results->volgnummer]=sprintf("show_char_value.php?selector_fk=%d&gewenste_processen_id=0&omschrijving_char=%s&t=%d",$selector_fk,$field_results->omschrijving,time()); 
   $datum[$field_results->volgnummer]=$date_result;
   $omschrijving[$field_results->volgnummer]=$field_results->omschrijving;
   $grootheid[$field_results->volgnummer]='na';
   $eenheid[$field_results->volgnummer]='na';
   $waarde[$field_results->volgnummer]=$field_results->waarde;
   $grens_kritisch_boven[$field_results->volgnummer]='na';
   $grens_kritisch_onder[$field_results->volgnummer]='na';
   $grens_acceptabel_boven[$field_results->volgnummer]='na';
   $grens_acceptabel_onder[$field_results->volgnummer]='na';
   $type[$field_results->volgnummer]='char';
      
}


mysql_free_result($result_char); 


while (($field_results = mysql_fetch_object($result_boolean)))
{
  
   $action[$field_results->volgnummer]=sprintf("show_boolean_value.php?selector_fk=%d&gewenste_processen_id=0&omschrijving_char=%s&t=%d",$selector_fk,$field_results->omschrijving,time()); 
   $datum[$field_results->volgnummer]=$date_result;
   $omschrijving[$field_results->volgnummer]=$field_results->omschrijving;
   $grootheid[$field_results->volgnummer]='na';
   $eenheid[$field_results->volgnummer]='na';
   $waarde[$field_results->volgnummer]=$field_results->waarde;
   $grens_kritisch_boven[$field_results->volgnummer]='na';
   $grens_kritisch_onder[$field_results->volgnummer]='na';
   $grens_acceptabel_boven[$field_results->volgnummer]='na';
   $grens_acceptabel_onder[$field_results->volgnummer]='na';
   $type[$field_results->volgnummer]='boolean';
      
}


mysql_free_result($result_boolean); 



$ref_key=array_keys($action);
$table_resultaten_floating='';
$j=0;
while ($j<sizeof($ref_key)) // loop for $ref_keys
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
     $table_resultaten_floating=$table_data->fetch("resultaten_floating_header.tpl");
   }

   if ($type[$ref_key[$j]]=="floating")   
   {
     $table_data->assign("bgcolor",$bgcolor);
     $table_data->assign("datum",$datum[$ref_key[$j]]);
     $table_data->assign("type",$type[$ref_key[$j]]);
     $table_data->assign("omschrijving",$omschrijving[$ref_key[$j]]);
     $table_data->assign("grootheid",$grootheid[$ref_key[$j]]);
     $table_data->assign("eenheid",$eenheid[$ref_key[$j]]);
     $table_data->assign("waarde",$waarde[$ref_key[$j]]);
     $table_data->assign("waarde_class","table_data");
     if ( ($waarde[$ref_key[$j]] > $grens_kritisch_boven[$ref_key[$j]]) or ($waarde[$ref_key[$j]] < $grens_kritisch_onder[$ref_key[$j]]) )
     {
       $table_data->assign("waarde_class","table_data_red");
     } 
     if ( ($waarde[$ref_key[$j]] > $grens_acceptabel_boven[$ref_key[$j]]) and ($waarde[$ref_key[$j]] < $grens_kritisch_boven[$ref_key[$j]]) )
     {
       $table_data->assign("waarde_class","table_data_orange");
     }
     if ( ($waarde[$ref_key[$j]] > $grens_kritisch_onder[$ref_key[$j]]) and ($waarde[$ref_key[$j]] < $grens_acceptabel_onder[$ref_key[$j]]) )
     {
       $table_data->assign("waarde_class","table_data_orange");
     }

     $table_data->assign("kritisch_onder",$grens_kritisch_onder[$ref_key[$j]]);
     $table_data->assign("kritisch_boven",$grens_kritisch_boven[$ref_key[$j]]);
     $table_data->assign("acceptabel_onder",$grens_acceptabel_onder[$ref_key[$j]]);
     $table_data->assign("acceptabel_boven",$grens_acceptabel_boven[$ref_key[$j]]);

     $table_data->assign("action_floating",$action[$ref_key[$j]]);
      
     $table_resultaten_floating.=$table_data->fetch("resultaten_floating_row.tpl");
   } 
   if ($type[$ref_key[$j]]=="char")   
   {
     $table_data->assign("bgcolor",$bgcolor);
     $table_data->assign("datum",$datum[$ref_key[$j]]);
     $table_data->assign("type",$type[$ref_key[$j]]);
     $table_data->assign("omschrijving",$omschrijving[$ref_key[$j]]);
     //$table_data->assign("grootheid",$grootheid[$ref_key[$j]]);
     //$table_data->assign("eenheid",$eenheid[$ref_key[$j]]);
     $table_data->assign("waarde",$waarde[$ref_key[$j]]);
     $table_data->assign("waarde_class","table_data");
     $table_data->assign("action_floating",$action[$ref_key[$j]]);
      
     $table_resultaten_floating.=$table_data->fetch("resultaten_floating_row.tpl");
   }
   if ($type[$ref_key[$j]]=="boolean")   
   {
     $table_data->assign("bgcolor",$bgcolor);
     $table_data->assign("datum",$datum[$ref_key[$j]]);
     $table_data->assign("type",$type[$ref_key[$j]]);
     $table_data->assign("omschrijving",$omschrijving[$ref_key[$j]]);
     //$table_data->assign("grootheid",$grootheid[$ref_key[$j]]);
     //$table_data->assign("eenheid",$eenheid[$ref_key[$j]]);
     $table_data->assign("waarde",$waarde[$ref_key[$j]]);
     $table_data->assign("waarde_class","table_data");
     $table_data->assign("action_floating",$action[$ref_key[$j]]);
      
     $table_resultaten_floating.=$table_data->fetch("resultaten_floating_row.tpl");
   }

   $j++;
   
}






///end new









$table_resultaten_object='';
$name_row='';
$picture_row='';
$b=0;

$j=0;
while (($field_results = mysql_fetch_object($result_object)))
{
  
   $b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }   

   $picture = new Smarty_NM();
   $description_name = new Smarty_NM();

      
   $action_object=sprintf("show_object.php?pk=%d&t=%d",$field_results->pk,time()); 

     
   

   $picture_src=sprintf("image_resize.php?f_name=$field_results->object_naam_pad&height=120");
   $picture->assign("picture_src",$picture_src);
   $picture->assign("picture_action",$action_object);
   $picture_row.=$picture->fetch("insert_picture_row.tpl");
   

   $description_name->assign("picture_name",$field_results->omschrijving);
   $name_row.=$description_name->fetch("insert_picture_name_row.tpl");


   $j++;
   $b=($j%8);
   if (($b==0)&&($j>0))
   {
     $table_resultaten_object.=sprintf("<tr>%s</tr>",$picture_row);
     $table_resultaten_object.=sprintf("<tr>%s</tr>",$name_row);
     $picture_row='';
     $name_row='';
   }
      

}


mysql_free_result($result_object); 


if ($b!=0)
{
  while ($b<8)
  {
    $picture_row.=sprintf("<td></td>");
    $name_row.=sprintf("<td></td>");
    $b++;
  }
  $table_resultaten_object.=sprintf("<tr>%s</tr>",$picture_row);
  $table_resultaten_object.=sprintf("<tr>%s</tr>",$name_row);
}





$data = new Smarty_NM();
$data->assign("Title","results Results");
$data->assign("selection_list",$selector_list);
$data->assign("header_result",$header_result);
if ($table_resultaten_floating!='')
{
  $data->assign("header_floating","Resultaten");
  $data->assign("resultaten_floating_list",$table_resultaten_floating);
}

if ($table_resultaten_object!='')
{
  $data->assign("header_object","Afbeeldingen");
  $data->assign("resultaten_object_list",$table_resultaten_object);
}

$action_result=sprintf("show_results.php?selector_fk=%d&analyse_level=%s&t=%d",$selector_fk,$analyse_level,time()); 
$data->assign("action_result",$action_result);



$data->display("resultaten_result.tpl");





?>