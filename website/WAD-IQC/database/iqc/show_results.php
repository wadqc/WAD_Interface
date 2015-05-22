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

$omschrijving='';
if (!empty($_GET['omschrijving']))
{
  $omschrijving=$_GET['omschrijving'];
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


$year_Stmt_study="SELECT $table_gewenste_processen.pk as 'pk', $table_gewenste_processen.status as 'status',$table_study.study_datetime as 'date_time' from $table_gewenste_processen inner join $table_study on $table_gewenste_processen.study_fk=$table_study.pk where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.status in (%s)
order by $table_study.study_datetime desc";

// gebruik study-datetime ipv series-creationtime of pps_start
//$year_Stmt_series="SELECT $table_gewenste_processen.pk as 'pk', $table_gewenste_processen.status as 'status', $table_study.study_datetime as 'date_time' from $table_gewenste_processen inner join $table_series on $table_gewenste_processen.series_fk=$table_series.pk, study where $table_gewenste_processen.selector_fk=$selector_fk and $table_gewenste_processen.status in (%s) and study.pk=series.study_fk order by $table_series.created_time desc";

$year_Stmt_series="SELECT $table_gewenste_processen.pk as 'pk', $table_gewenste_processen.status as 'status', $table_instance.content_datetime as 'date_time' from $table_gewenste_processen inner join $table_series on $table_gewenste_processen.series_fk=$table_series.pk, $table_instance where $table_gewenste_processen.selector_fk=$selector_fk and $table_gewenste_processen.status in (%s) and $table_series.pk=$table_instance.series_fk and $table_instance.pk=(select min(pk) from $table_instance where series_fk=$table_series.pk) order by $table_instance.content_datetime desc";


$year_Stmt_instance="SELECT $table_gewenste_processen.pk as 'pk', $table_gewenste_processen.status as 'status', $table_instance.content_datetime as 'date_time' from $table_gewenste_processen inner join $table_instance on $table_gewenste_processen.instance_fk=$table_instance.pk where $table_gewenste_processen.selector_fk=$selector_fk
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
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



  if (!($result_status= $link->query(sprintf($status_Stmt,$selector_fk)))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($status_Stmt,$selector_fk) )) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
  }

  $status_select='NULL';
  while($field = $result_status->fetch_object())
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
  
  $result_status->close();  



// geeft anders problemen met selectoren die alleen gewenste processen hebben met status!=5
// $status_select=5;








//In case of a switch of status, gewenste_processen_id needs to be changed as well 



if (!($result_selector_processen= $link->query(sprintf($selector_processen_Stmt,$status,$gewenste_processen_id)))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($selector_processen_Stmt,$status,$gewenste_processen_id) )) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
  }


  if (!($field_results = $result_selector_processen->fetch_object() ))
  {
   $gewenste_processen_id=-1;
  }
  
  $result_selector_processen->close();  


//end of definition of gewenste_processen_id



$list_year='';

if ($analyse_level=='study')
{
  if (!($result_year= $link->query(sprintf($year_Stmt_study,$status)))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
     DisplayErrMsg(sprintf("error: %s", $link->error)) ;
     exit() ;
  }
  $counter=0;

  
  while($field = $result_year->fetch_object())
  {
    
    if (($counter==0)&&($gewenste_processen_id==-1)) //first visit, id will be changed to the id that is linked to the most recent date of study
    {
      $gewenste_processen_id=$field->pk;
    }   
    if ($field->pk== $gewenste_processen_id)
    {
       $date_result=$field->date_time;
       $status_select=$field->status; 
    }  
    $list_year["$field->pk"]="$field->date_time";
    $counter++;
   
  }
  $result_year->close();
  //$status=$status_selected;
  
  if ($counter==0)
  {
    if (!($result_year= $link->query(sprintf($year_Stmt_study,$status_select)))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
    }
     
    while($field = $result_year->fetch_object())
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
    $result_year->close();
    $status=$status_select;
  }

}



if ($analyse_level=='series')
{
  if (!($result_year= $link->query(sprintf($year_Stmt_series,$status)))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
     DisplayErrMsg(sprintf("error: %s", $link->error)) ;
     exit() ;
  }
  $counter=0;

  while($field = $result_year->fetch_object())
  {
    if (($counter==0)&&($gewenste_processen_id==-1)) //first visit, id will be changed to the id that is linked to the most recent date of study
    {
      $gewenste_processen_id=$field->pk;
    }    
    if ($field->pk== $gewenste_processen_id)
    {
       $date_result=$field->date_time;
       $status_select=$field->status;
    } 
    $list_year["$field->pk"]="$field->date_time";
    $counter++;
  } 
  $result_year->close();

  if ($counter==0)
  {
    if (!($result_year= $link->query(sprintf($year_Stmt_series,$status_select)))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
    }
     
    while($field = $result_year->fetch_object())
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
    $result_year->close();
    $status=$status_select;
  }

}


if ($analyse_level=='instance')
{
  if (!($result_year= $link->query(sprintf($year_Stmt_instance,$status)))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
     DisplayErrMsg(sprintf("error: %s", $link->error)) ;
     exit() ;
  }
  $counter=0;

  while($field = $result_year->fetch_object())
  {
    if (($counter==0)&&($gewenste_processen_id==-1)) //first visit, id will be changed to the id that is linked to the most recent date of study
    {
      $gewenste_processen_id=$field->pk;
    }
    if ($field->pk== $gewenste_processen_id)
    {
       $date_result=$field->date_time;
       $status_select=$field->status;
    } 
    $list_year["$field->pk"]="$field->date_time";
    $counter++;
  } 
  $result_year->close();

  if ($counter==0)
  {
    if (!($result_year= $link->query(sprintf($year_Stmt_instance,$status_select)))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
    }
     
    while($field = $result_year->fetch_object())
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
    $result_year->close();
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

if (!($result_selector= $link->query($selector_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}

$field_results = $result_selector->fetch_object();
$header_result=sprintf("Selector: %s, analyse level: %s",$field_results->name,$field_results->analyselevel);
$result_selector->close();  

if ($status_select==20||$status_select==30)
{
 
  if (!($result_resultaten_status= $link->query(sprintf($resultaten_status_Stmt,$gewenste_processen_id)))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($resultaten_status_Stmt,$gewenste_processen_id) )) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
  }


  $field_results = $result_resultaten_status->fetch_object();
  if ($status_select==20)
  {  
    $recover_data=sprintf("Verwijderd door: %s, Reden: %s",$field_results->gebruiker,$field_results->omschrijving);
    $notitie_data=sprintf("Notitie: %s",$field_results->omschrijving); 
  }
  if ($status_select==30)
  {  
    $validate_data=sprintf("Notitie: %s, Gevalideerd door: %s, Initialen: %s",$field_results->omschrijving, $field_results->gebruiker,$field_results->initialen);
    $notitie_data=sprintf("Notitie: %s",$field_results->omschrijving); 
  }
 
  $result_resultaten_status->close();  

}


if (!($result_niveaus= $link->query(sprintf($niveaus_Stmt,$gewenste_processen_id)))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($niveaus_Stmt,$gewenste_processen_id) )) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
}

$j=1;
while ($field_results = $result_niveaus->fetch_object()) {
	$list_niveau[$j]=$field_results->niveau;
	$j++;
}

// Check of gekozen niveau in de lijst voorkomt van geldige niveaus.
// Dit voor 't geval je een resultaat selecteert in de pulldown, met het niveau van het
// huidig resultaat dat niet geldig is voor het geselecteerde resultaat.
// In dat geval het hoogste geldige niveau nemen.

if(is_array($list_niveau))
{
  in_array($niveau,$list_niveau)?:$niveau=$list_niveau[1];
}


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


if ($status_select==5)
{
  $table_data_valideer = new Smarty_NM();
  
  $action_result_validate=sprintf("validate_results.php?selector_fk=%d&analyse_level=%s&v=%d&t=%d",$selector_fk,$analyse_level,$v,time()); 
  $table_data_valideer->assign("select_validate","Valideer"); 
  $table_data_valideer->assign("action_result_validate",$action_result_validate); 
  
  $menu_valideer=$table_data_valideer->fetch("selector_select_valideer.tpl");
  
  $table_data_notitie = new Smarty_NM();
  $table_data_notitie->assign("default_omschrijving",$omschrijving);
  $menu_notitie=$table_data_notitie->fetch("selector_select_omschrijving_input.tpl");

  $table_data->assign("notitie",$menu_notitie);
  $table_data->assign("row_line",$menu_valideer);
  
  //$table_data->assign("select_value","Delete");
}


if ($status_select==20)
{
  $table_data_verwijderd = new Smarty_NM();
  $table_data_verwijderd->assign("recover_data",$recover_data); 
  $menu_verwijderd=$table_data_verwijderd->fetch("selector_select_verwijderd.tpl");
  
  $table_data_notitie = new Smarty_NM();
  $menu_notitie=$table_data_notitie->fetch("selector_select_omschrijving_input.tpl");

  $table_data_selection = new Smarty_NM();
  $table_data_selection->assign("select_value","Herstel");
  $menu_selection=$table_data_selection->fetch("selector_select_selection.tpl"); 



  //$table_data->assign("notitie",$menu_notitie);

  $table_data->assign("row_line",$menu_verwijderd);
  
  $table_data->assign("selection",$menu_selection);

}


if ($status_select==30)
{
  $table_data_verwijderd = new Smarty_NM();
  $table_data_verwijderd->assign("recover_data",$validate_data); 
  $menu_verwijderd=$table_data_verwijderd->fetch("selector_select_verwijderd.tpl");
  
  $table_data_notitie = new Smarty_NM();
  $menu_notitie=$table_data_notitie->fetch("selector_select_omschrijving_input.tpl");

  $table_data_selection = new Smarty_NM();
  $table_data_selection->assign("select_value","Delete");
  $menu_selection=$table_data_selection->fetch("selector_select_selection.tpl");

  //$table_data->assign("notitie",$menu_notitie);


  $table_data->assign("row_line",$menu_verwijderd);
  $table_data->assign("selection","$menu_selection");  

 
}



if ($user_level_1=='on')
{
  $selector_list=$table_data->fetch("selector_select.tpl");
}

if ($user_level_1!='on')
{
  $selector_list=$table_data->fetch("selector_select_user.tpl");
}

//end selector_header








if (!($result_floating= $link->query(sprintf($results_floating_Stmt,$gewenste_processen_id,$niveau)))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_floating_Stmt,$gewenste_processen_id,$niveau)) );
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}

if (!($result_char= $link->query(sprintf($results_char_Stmt,$gewenste_processen_id,$niveau)))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_char_Stmt,$gewenste_processen_id,$niveau)) );
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}

if (!($result_boolean= $link->query(sprintf($results_boolean_Stmt,$gewenste_processen_id,$niveau)))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_boolean_Stmt,$gewenste_processen_id,$niveau)) );
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}

if (!($result_object= $link->query(sprintf($results_object_Stmt,$gewenste_processen_id,$niveau)))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_object_Stmt,$gewenste_processen_id,$niveau)) );
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
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
$criterium = '';
$type='';



$j=0;
while (($field_results = $result_floating->fetch_object()))
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
   $criterium[$field_results->volgnummer]='na';
   $type[$field_results->volgnummer]='floating';

}


$result_floating->close(); 

while (($field_results = $result_char->fetch_object()))
{

   $action[$field_results->volgnummer]=sprintf("show_char_value.php?selector_fk=%d&analyse_level=%s&status=%s&omschrijving_char=%s&t=%d",$selector_fk,$analyse_level,$status,$field_results->omschrijving,time()); 
   $datum[$field_results->volgnummer]=$date_result;
   $omschrijving[$field_results->volgnummer]=$field_results->omschrijving;
   $grootheid[$field_results->volgnummer]='na';
   $eenheid[$field_results->volgnummer]='na';
   $waarde[$field_results->volgnummer]=$field_results->waarde;
   $grens_kritisch_boven[$field_results->volgnummer]='na';
   $grens_kritisch_onder[$field_results->volgnummer]='na';
   $grens_acceptabel_boven[$field_results->volgnummer]='na';
   $grens_acceptabel_onder[$field_results->volgnummer]='na';
   $criterium[$field_results->volgnummer]=$field_results->criterium;
   $type[$field_results->volgnummer]='char';
      
}


$result_char->close(); 


while (($field_results = $result_boolean->fetch_object()))
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
   $criterium[$field_results->volgnummer]='na';
   $type[$field_results->volgnummer]='boolean';
      
}


$result_boolean->close(); 

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
ksort($criterium);
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
     if (  ( ($waarde[$ref_key[$j]] > $grens_kritisch_boven[$ref_key[$j]]) or ($waarde[$ref_key[$j]] < $grens_kritisch_onder[$ref_key[$j]]) ) and (($grens_kritisch_boven[$ref_key[$j]]!='') and ($grens_kritisch_onder[$ref_key[$j]]!='')) )
     {
       $table_data->assign("waarde_class","table_data_red");
     } 
     if ( ( ($waarde[$ref_key[$j]] > $grens_acceptabel_boven[$ref_key[$j]]) and ($waarde[$ref_key[$j]] <= $grens_kritisch_boven[$ref_key[$j]]) ) and (($grens_acceptabel_boven[$ref_key[$j]]!='') and ($grens_kritisch_boven[$ref_key[$j]]!='')) )
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
//   if ($type[$ref_key[$j]]=="char")   
//   {
//     $table_data->assign("bgcolor",$bgcolor);
//     $table_data->assign("datum",$datum[$ref_key[$j]]);
//     $table_data->assign("type",$type[$ref_key[$j]]);
//     $table_data->assign("omschrijving",$omschrijving[$ref_key[$j]]);
//     //$table_data->assign("grootheid",$grootheid[$ref_key[$j]]);
//     //$table_data->assign("eenheid",$eenheid[$ref_key[$j]]);
//     $table_data->assign("waarde",$waarde[$ref_key[$j]]);
//     $table_data->assign("waarde_class","table_data");
//     $table_data->assign("action_floating",$action[$ref_key[$j]]);
//      
//     $table_resultaten_floating.=$table_data->fetch("resultaten_floating_row.tpl");
//   }
   if ($type[$ref_key[$j]]=="char")   
   {
     $table_data->assign("bgcolor",$bgcolor);
     $table_data->assign("datum",$datum[$ref_key[$j]]);
     $table_data->assign("type",$type[$ref_key[$j]]);
     $table_data->assign("omschrijving",$omschrijving[$ref_key[$j]]);
     $table_data->assign("waarde",$waarde[$ref_key[$j]]);
     $table_data->assign("waarde_class","table_data");
     $table_data->assign("action_char",$action[$ref_key[$j]]);
     $table_data->assign("criterium",$criterium[$ref_key[$j]]);

     if ($criterium[$ref_key[$j]] != '')
     {
         $table_data->assign("waarde_class","table_data_green"); // default is green if criterium is defined
     }
     //if ( ($criterium[$ref_key[$j]]=='') and ($waarde[$ref_key[$j]]!=$criterium[$ref_key[$j]]) )
     //{
     //  $table_data->assign("waarde_class","table_data_orange"); // assign is criterium not given, but value is
     //} 
     if ( ($criterium[$ref_key[$j]]!='') and ($waarde[$ref_key[$j]]!=$criterium[$ref_key[$j]]) )
     {
       $table_data->assign("waarde_class","table_data_red");
     } 
      
     $table_resultaten_floating.=$table_data->fetch("resultaten_char_row.tpl");
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
while (($field_results = $result_object->fetch_object()))
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
  $object_type="None";

  $finfo = finfo_open(FILEINFO_MIME_TYPE,null); // return mime type ala mimetype extension
  $object_type=@finfo_file($finfo, $filename);
  finfo_close($finfo);


  switch ( $object_type )
  {
    case "image/jpeg":
    case "image/png":
    case "image/gif":
    case "image/bmp":
    case "image/wbmp":
      $action_object=sprintf("show_object.php?pk=%d&object_type=%s&t=%d",$field_results->pk,$object_type,time()); 
      $picture_src=sprintf("image_resize.php?f_name=$field_results->object_naam_pad&height=120");
      break;

    case "text/plain":
    case "text/x-c":
      $action_object=sprintf("show_object.php?pk=%d&object_type=%s&t=%d",$field_results->pk,$object_type,time()); 
      $picture_src=sprintf("image_resize.php?f_name=%s&height=120",$logo_log_file);
      break;

    case "application/pdf":
      $action_object=sprintf("show_object.php?pk=%d&object_type=%s&t=%d",$field_results->pk,$object_type,time()); 
      $picture_src=sprintf("image_resize.php?f_name=%s&height=120",$logo_pdf_file);
      break;

    default:
      $action_object=sprintf("show_object.php?pk=%d&object_type=%s&t=%d",$field_results->pk,$object_type,time()); 
      $picture_src=sprintf("image_resize.php?f_name=%s&height=120",$logo_obj_file);
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


$result_object->close(); 


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
$data->assign("Title","Results");
$data->assign("selection_list",$selector_list);
$data->assign("header_result",$header_result);
if ($table_resultaten_floating!='')
{
  $data->assign("header_floating","Resultaten");
  $data->assign("resultaten_floating_list",$table_resultaten_floating);
}

if ($table_resultaten_object!='')
{
  $data->assign("header_object","Objecten");
  $data->assign("resultaten_object_list",$table_resultaten_object);
}

$data->assign("header_result",$header_result);


$action_result=sprintf("validate_results.php?selector_fk=%d&analyse_level=%s&v=%d&t=%d",$selector_fk,$analyse_level,$v,time()); 


$data->assign("action_result",$action_result);



$data->display("resultaten_result.tpl");





?>
                                                                                                                                                                                                                                                                                                                                                                                                                              