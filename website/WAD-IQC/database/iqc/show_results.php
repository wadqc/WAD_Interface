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
$table_resultaten_status='resultaten_status';

$v=0;
$v=$_GET['v'];
$selector_fk=0;
if (!empty($_GET['selector_fk']))
{
  $selector_fk=$_GET['selector_fk'];
}



$analyse_level='';
if (!empty($_GET['analyse_level']))
{
  $analyse_level=$_GET['analyse_level'];
}

//$niveau=1;
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







if (!empty($_GET['gewenste_processen_id']))
{
  $gewenste_processen_id=$_GET['gewenste_processen_id'];
}
if (!empty($_POST['gewenste_processen_id']))
{
  $gewenste_processen_id=$_POST['gewenste_processen_id'];
}



$results_floating_Stmt="SELECT * from $table_gewenste_processen inner join $table_resultaten_floating on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk 
and $table_gewenste_processen.pk='%s' 
and $table_resultaten_floating.niveau like '%s'
order by $table_gewenste_processen.pk, $table_resultaten_floating.volgnummer";

  
$results_char_Stmt="SELECT  * from $table_gewenste_processen inner join $table_resultaten_char on $table_gewenste_processen.pk=$table_resultaten_char.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%s'
and $table_resultaten_char.niveau like '%s' 
order by $table_gewenste_processen.pk, $table_resultaten_char.volgnummer";


$results_boolean_Stmt="SELECT  * from $table_gewenste_processen inner join $table_resultaten_boolean on $table_gewenste_processen.pk=$table_resultaten_boolean.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%s'
and $table_resultaten_boolean.niveau like '%s' 
order by $table_gewenste_processen.pk, $table_resultaten_boolean.volgnummer";


$results_object_Stmt="SELECT  $table_resultaten_object.object_naam_pad as 'object_naam_pad', $table_resultaten_object.omschrijving as 'omschrijving', $table_resultaten_object.pk as 'pk' from $table_gewenste_processen inner join $table_resultaten_object on $table_gewenste_processen.pk=$table_resultaten_object.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%s'
and $table_resultaten_object.niveau like '%s'
order by $table_gewenste_processen.pk, $table_resultaten_object.volgnummer";


$year_Stmt_study="SELECT $table_gewenste_processen.pk as 'pk', $table_study.study_datetime as 'date_time' from $table_gewenste_processen inner join $table_study on $table_gewenste_processen.study_fk=$table_study.pk where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.status in (%s)
order by $table_study.study_datetime desc";

//$year_Stmt_series="SELECT $table_gewenste_processen.pk as 'pk', $table_series.created_time as 'date_time' from $table_gewenste_processen inner join $table_series on $table_gewenste_processen.series_fk=$table_series.pk where $table_gewenste_processen.selector_fk=$selector_fk and $table_gewenste_processen.status in (%s) order by $table_series.created_time desc";

// gebruik study-datetime ipv series-creationtime of pps_start
$year_Stmt_series="SELECT $table_gewenste_processen.pk as 'pk', $table_study.study_datetime as 'date_time' from $table_gewenste_processen inner join $table_series on $table_gewenste_processen.series_fk=$table_series.pk, study where $table_gewenste_processen.selector_fk=$selector_fk and $table_gewenste_processen.status in (%s) and study.pk=series.study_fk order by $table_series.created_time desc";

$year_Stmt_instance="SELECT $table_gewenste_processen.pk as 'pk', $table_instance.content_datetime as 'date_time' from $table_gewenste_processen inner join $table_instance on $table_gewenste_processen.study_fk=$table_instance.pk where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.status in (%s) 
order by $table_instance.content_datetime desc";


$selector_Stmt="SELECT * from $table_selector
where $table_selector.pk=$selector_fk"; 

$resultaten_status_Stmt="SELECT * from $table_resultaten_status
where $table_resultaten_status.gewenste_processen_fk=%d"; 

$selector_processen_Stmt="SELECT * from $table_gewenste_processen
where $table_gewenste_processen.status in (%s) and $table_gewenste_processen.pk='%d'"; 

$status_Stmt="SELECT * from $table_gewenste_processen
where $table_gewenste_processen.selector_fk='%d'"; 


$niveaus_Stmt="SELECT $table_resultaten_floating.niveau as niveau from $table_resultaten_floating inner join $table_gewenste_processen on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk where $table_gewenste_processen.pk=%1\$d and $table_gewenste_processen.selector_fk=$selector_fk
UNION DISTINCT
SELECT $table_resultaten_char.niveau as niveau from $table_resultaten_char inner join $table_gewenste_processen on $table_gewenste_processen.pk=$table_resultaten_char.gewenste_processen_fk where $table_gewenste_processen.pk=%1\$d and $table_gewenste_processen.selector_fk=$selector_fk
UNION DISTINCT
SELECT $table_resultaten_boolean.niveau as niveau from $table_resultaten_boolean inner join $table_gewenste_processen on $table_gewenste_processen.pk=$table_resultaten_boolean.gewenste_processen_fk where $table_gewenste_processen.pk=%1\$d and $table_gewenste_processen.selector_fk=$selector_fk
UNION DISTINCT
SELECT $table_resultaten_object.niveau as niveau from $table_resultaten_object inner join $table_gewenste_processen on $table_gewenste_processen.pk=$table_resultaten_object.gewenste_processen_fk where $table_gewenste_processen.pk=%1\$d and $table_gewenste_processen.selector_fk=$selector_fk order by niveau asc";


// Connect to the Database
if (!($link=@mysql_pconnect($hostName, $userName, $password))) {
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



  if (!($result_status= mysql_query(sprintf($status_Stmt,$selector_fk), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($selector_processen_Stmt,$selector_fk) )) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }

  $status_select='NULL';
  while($field = mysql_fetch_object($result_status))
  {
    $status_select=$field->status;
    
    if ($status_select==5)
    {    
      $list_status[5]='Afgerond';
	  $list_status['5,30']='*';
    }
    if ($status_select==20)
    {    
      $list_status[20]='Verwijderd';
    }
    if ($status_select==30)
    {    
      $list_status[30]='Gevalideerd';
	  $list_status['5,30']='*';
    }
   
  }
  if(is_array($list_status)) {
	asort($list_status);
  }
  
  mysql_free_result($result_status);  


















//In case of a switch of status, gewenste_processen_id needs to be changed as well 



if (!($result_selector_processen= mysql_query(sprintf($selector_processen_Stmt,$status,$gewenste_processen_id), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($selector_processen_Stmt,$status,$gewenste_processen_id) )) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }


  if (!($field_results = mysql_fetch_object($result_selector_processen) ))
  {
   $gewenste_processen_id=-1;
  }
  
  
  mysql_free_result($result_selector_processen);  


//end of definition of gewenste_processen_id




$list_year='';

if ($analyse_level=='study')
{
  
  if (!($result_year= mysql_query(sprintf($year_Stmt_study,$status), $link))) {
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
  if ($counter==0)
  {
    if (!($result_year= mysql_query(sprintf($year_Stmt_study,$status_select), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
     
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
    $status=$status_select;
  }

}




if ($analyse_level=='series')
{
  if (!($result_year= mysql_query(sprintf($year_Stmt_series,$status), $link))) {
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

  if ($counter==0)
  {
    if (!($result_year= mysql_query(sprintf($year_Stmt_series,$status_select), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
     
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
    $status=$status_select;
  }

}

if ($analyse_level=='instance')
{
  if (!($result_year= mysql_query(sprintf($year_Stmt_instance,$status), $link))) {
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

  if ($counter==0)
  {
    if (!($result_year= mysql_query(sprintf($year_Stmt_instance,$status_select), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
     
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
    $status=$status_select;
  }

}


if ($counter==0)
{
  $data = new Smarty_NM();
  $data->assign("error_message","Geen resultaten voor deze selector aanwezig.");
  $data->display("error_handler.tpl");
  exit();
}



//selector_header

if (!($result_selector= mysql_query($selector_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$field_results = mysql_fetch_object($result_selector);
$header_result=sprintf("Selector: %s, analyse level: %s",$field_results->name,$field_results->analyselevel);
mysql_free_result($result_selector);  

if ($status==20||$status==30)
{
 
  if (!($result_resultaten_status= mysql_query(sprintf($resultaten_status_Stmt,$gewenste_processen_id), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($resultaten_status_Stmt,$gewenste_processen_id) )) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }


  $field_results = mysql_fetch_object($result_resultaten_status);
  if ($status==20)
  {  
    $recover_data=sprintf("Verwijderd door: %s, Reden: %s",$field_results->gebruiker,$field_results->omschrijving);
  }
  if ($status==30)
  {  
    $validate_data=sprintf("Gevalideerd door: %s, Initialen: %s",$field_results->gebruiker,$field_results->initialen);
  }
 
  mysql_free_result($result_resultaten_status);  

}


if (!($result_niveaus= mysql_query(sprintf($niveaus_Stmt,$gewenste_processen_id), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($niveaus_Stmt,$gewenste_processen_id) )) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
}

$j=1;
while ($field_results = mysql_fetch_object($result_niveaus)) {
	$list_niveau[$j]=$field_results->niveau;
	$j++;
}

// Check of gekozen niveau in de lijst voorkomt van geldige niveaus.
// Dit voor 't geval je een resultaat selecteert in de pulldown, met het niveau van het
// huidig resultaat dat niet geldig is voor het geselecteerde resultaat.
// In dat geval het hoogste geldige niveau nemen.
if(is_array($list_niveau)) {
	in_array($niveau,$list_niveau)?:$niveau=$list_niveau[1];
}

//$list_niveau[1]='1';
//$list_niveau[2]='2';

$table_data = new Smarty_NM();
$table_data->assign("processen_options",$list_year);
$table_data->assign("processen_id",$gewenste_processen_id);

$table_data->assign("niveau_options",$list_niveau);
$table_data->assign("niveau_id",$niveau);

$table_data->assign("status_options",$list_status);
$table_data->assign("status_id",$status);

$table_data->assign("selector_fk",$selector_fk);
$table_data->assign("analyse_level",$analyse_level);
$table_data->assign("v",$v);



//if ($status==5)
//{
//  $table_data->assign("select_value","Delete");
//}



if ($status==20)
{
  $table_data_verwijderd = new Smarty_NM();
  $table_data_verwijderd->assign("recover_data",$recover_data); 
  $menu_verwijderd=$table_data_verwijderd->fetch("selector_select_verwijderd.tpl");
  $table_data->assign("row_line",$menu_verwijderd);
  
  $table_data->assign("select_value","Herstel");

}

if ($status==30)
{
  $table_data_verwijderd = new Smarty_NM();
  $table_data_verwijderd->assign("recover_data",$validate_data); 
  $menu_verwijderd=$table_data_verwijderd->fetch("selector_select_verwijderd.tpl");
  $table_data->assign("row_line",$menu_verwijderd);
  
  $table_data->assign("select_value","Delete");

}


if ($status==5)
{
  $table_data_valideer = new Smarty_NM();
  
  $action_result_validate=sprintf("validate_results.php?selector_fk=%d&analyse_level=%s&v=%d&t=%d",$selector_fk,$analyse_level,$v,time()); 
  $table_data_valideer->assign("select_validate","Valideer"); 
  $table_data_valideer->assign("action_result_validate",$action_result_validate); 
  
  $menu_valideer=$table_data_valideer->fetch("selector_select_valideer.tpl");
  


  $table_data->assign("row_line",$menu_valideer);
  
  $table_data->assign("select_value","Delete");
 

}




$selector_list=$table_data->fetch("selector_select.tpl");


//end selector_header








if (!($result_floating= mysql_query(sprintf($results_floating_Stmt,$gewenste_processen_id,$niveau), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_floating_Stmt,$gewenste_processen_id,$niveau)) );
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_char= mysql_query(sprintf($results_char_Stmt,$gewenste_processen_id,$niveau), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_char_Stmt,$gewenste_processen_id,$niveau)) );
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_boolean= mysql_query(sprintf($results_boolean_Stmt,$gewenste_processen_id,$niveau), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_boolean_Stmt,$gewenste_processen_id,$niveau)) );
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_object= mysql_query(sprintf($results_object_Stmt,$gewenste_processen_id,$niveau), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_object_Stmt,$gewenste_processen_id,$niveau)) );
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}






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

   
   $action[$field_results->volgnummer]=sprintf("show_floating_value.php?selector_fk=%d&analyse_level=%s&status=%s&omschrijving=%s&grootheid=%s&eenheid=%s&t=%d",$selector_fk,$analyse_level,$status,$field_results->omschrijving,$field_results->grootheid,$field_results->eenheid ,time()); 
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

   $action[$field_results->volgnummer]=sprintf("show_char_value.php?selector_fk=%d&status=%s&omschrijving_char=%s&t=%d",$selector_fk,$status,$field_results->omschrijving,time()); 
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
  
   $action[$field_results->volgnummer]=sprintf("show_boolean_value.php?selector_fk=%d&status=%s&omschrijving_char=%s&t=%d",$selector_fk,$status,$field_results->omschrijving,time()); 
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

//Sorteren om op basis van volgnummer weer te geven
if (is_array($action)){
ksort($action);
ksort($datum);
ksort($type);
ksort($omschrijving);
ksort($grootheid);
ksort($eenheid);
ksort($waarde);
ksort($grens_kritisch_boven);
ksort($grens_kritisch_onder);
ksort($grens_acceptabel_boven);
ksort($grens_acceptabel_onder);
ksort($type);
}


if (is_array($action)){
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
     if ( ($grens_kritisch_boven[$ref_key[$j]]!='') and ($grens_kritisch_onder[$ref_key[$j]]!='') )
     {
       $table_data->assign("waarde_class","table_data_green");
     } 
     if (  ( ($waarde[$ref_key[$j]] >= $grens_kritisch_boven[$ref_key[$j]]) or ($waarde[$ref_key[$j]] <= $grens_kritisch_onder[$ref_key[$j]]) ) and (($grens_kritisch_boven[$ref_key[$j]]!='') and ($grens_kritisch_onder[$ref_key[$j]]!='')) )
     {
       $table_data->assign("waarde_class","table_data_red");
     } 
     if ( ( ($waarde[$ref_key[$j]] >= $grens_acceptabel_boven[$ref_key[$j]]) and ($waarde[$ref_key[$j]] < $grens_kritisch_boven[$ref_key[$j]]) ) and (($grens_acceptabel_boven[$ref_key[$j]]!='') and ($grens_kritisch_boven[$ref_key[$j]]!='')) )
     {
       $table_data->assign("waarde_class","table_data_orange");
     }
     if ( ( ($waarde[$ref_key[$j]] > $grens_kritisch_onder[$ref_key[$j]]) and ($waarde[$ref_key[$j]] <= $grens_acceptabel_onder[$ref_key[$j]]) ) and (($grens_kritisch_onder[$ref_key[$j]]!='') and ($grens_acceptabel_onder[$ref_key[$j]]!='')) ) 
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

} else {
$table_resultaten_floating="Geen resultaten beschikbaar.";
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

   

   $filename=$field_results->object_naam_pad;
   $object_type="image";
   
   $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
   if (finfo_file($finfo, $filename)=='text/plain')
   {
     $object_type='text';
   }
   finfo_close($finfo);

  
  if ($object_type=='image')
  {
    $action_object=sprintf("show_object.php?pk=%d&object_type=%s&t=%d",$field_results->pk,$object_type,time()); 
    $picture_src=sprintf("image_resize.php?f_name=$field_results->object_naam_pad&height=120");
  }  

  if ($object_type=="text")
  {
    $picture_log_file = sprintf("%s%s%s",$home_path,dirname($_SERVER['PHP_SELF']),$logo_log_file);

    $action_object=sprintf("show_object.php?pk=%d&object_type=%s&t=%d",$field_results->pk,$object_type,time()); 
    $picture_src=sprintf("image_resize.php?f_name=%s&height=120",$picture_log_file);
  }  

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

$data->assign("header_result",$header_result);


$action_result=sprintf("validate_results.php?selector_fk=%d&analyse_level=%s&v=%d&t=%d",$selector_fk,$analyse_level,$v,time()); 


$data->assign("action_result",$action_result);



$data->display("resultaten_result.tpl");





?>
