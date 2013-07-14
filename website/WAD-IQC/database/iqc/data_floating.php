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

//$omschrijving_object="%";
//if (!empty($_GET['omschrijving_object']))
//{
//  $omschrijving_object=$_GET['omschrijving_object'];
//}


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
and $table_gewenste_processen.status=$status 
and $table_resultaten_floating.omschrijving like '$omschrijving'
and $table_resultaten_floating.grootheid like '$grootheid' 
and $table_resultaten_floating.eenheid like '$eenheid' 
order by date_time";
//order by $table_gewenste_processen.pk, $table_resultaten_floating.volgnummer";

}



if ($analyse_level=='series')
{
  
$results_floating_Stmt="SELECT $table_series.pps_start as 'date_time', $table_resultaten_floating.omschrijving as 'omschrijving', $table_resultaten_floating.grootheid as 'grootheid', $table_resultaten_floating.eenheid as 'eenheid', $table_resultaten_floating.grens_kritisch_boven as 'grens_kritisch_boven', $table_resultaten_floating.grens_kritisch_onder as 'grens_kritisch_onder', $table_resultaten_floating.grens_acceptabel_boven as 'grens_acceptabel_boven', $table_resultaten_floating.grens_acceptabel_onder as 'grens_acceptabel_onder', $table_resultaten_floating.waarde as 'waarde' from $table_series inner join ($table_gewenste_processen inner join $table_resultaten_floating on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk) on $table_series.pk=$table_gewenste_processen.series_fk 
where $table_gewenste_processen.selector_fk=$selector_fk 
and $table_gewenste_processen.status=$status 
and $table_resultaten_floating.omschrijving like '$omschrijving'
and $table_resultaten_floating.grootheid like '$grootheid' 
and $table_resultaten_floating.eenheid like '$eenheid' 
order by date_time";
//order by $table_gewenste_processen.pk, $table_resultaten_floating.volgnummer";

}


if ($analyse_level=='instance')
{
  
$results_floating_Stmt="SELECT $table_instance.content_datetime as 'date_time', $table_resultaten_floating.omschrijving as 'omschrijving', $table_resultaten_floating.grootheid as 'grootheid', $table_resultaten_floating.eenheid as 'eenheid', $table_resultaten_floating.grens_kritisch_boven as 'grens_kritisch_boven', $table_resultaten_floating.grens_kritisch_onder as 'grens_kritisch_onder', $table_resultaten_floating.grens_acceptabel_boven as 'grens_acceptabel_boven', $table_resultaten_floating.grens_acceptabel_onder as 'grens_acceptabel_onder', $table_resultaten_floating.waarde as 'waarde' from $table_instance inner join ($table_gewenste_processen inner join $table_resultaten_floating on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk) on $table_instance.pk=$table_gewenste_processen.instance_fk 
where $table_gewenste_processen.selector_fk=$selector_fk 
and $table_gewenste_processen.status=$status 
and $table_resultaten_floating.omschrijving like '$omschrijving'
and $table_resultaten_floating.grootheid like '$grootheid' 
and $table_resultaten_floating.eenheid like '$eenheid' 
order by date_time";
//order by $table_gewenste_processen.pk, $table_resultaten_floating.volgnummer";

}



$selector_Stmt="SELECT * from $table_selector
where $table_selector.pk=$selector_fk"; 

$gewenste_processen_Stmt="SELECT * from $table_gewenste_processen
where $table_gewenste_processen.selector_fk=$selector_fk
order by $table_gewenste_processen.pk";

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



if ($gewenste_processen_id==0) //wildcard on gewenste_processen_id
{
  $gewenste_processen_id="%";
}



if (!($result_floating= mysql_query($results_floating_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $results_floating_Stmt) );
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



$table_resultaten_floating='';

$value="Meetwaarde";

//printf("kritischboven \t acceptabelboven \t %s \t acceptabelonder \t kritischonder \n",$value);         //name 
//printf("Red \t Orange \t Blue \t Orange \t Red \n");                                                          //color
//printf("ShortDot\tShortDot\tSolid\tShortDot\tShortDot\n");                                    //dashstyle
//printf("0\t0\t0\t0\t0\n");                                    //marker
//printf("diamond\ttriangle\tcircle\ttriangle-down\tdiamond\n");
//printf("%s [%s]\t%s\tcircle\ttriangle-down\tdiamond\n",$grootheid,$eenheid,$omschrijving);

$grens_waarden=1;

$j=0;
while (($field_results = mysql_fetch_object($result_floating)))
{
  $grens_kritisch_boven=$field_results->grens_kritisch_boven;
  $grens_kritisch_onder=$field_results->grens_kritisch_onder;
  $grens_acceptabel_boven=$field_results->grens_acceptabel_boven;
  $grens_acceptabel_onder=$field_results->grens_acceptabel_onder;  

  if ($j==0&&( ($grens_kritisch_boven=='') || ($grens_kritisch_onder=='') || ($grens_acceptabel_boven=='')||($grens_acceptabel_onder=='') ) )
  { 
    //printf("kritischboven \t acceptabelboven \t %s \t acceptabelonder \t kritischonder \n",$value);         //name 
    printf(" \t \t %s \t  \t \n",$value);         //name 
    printf(" \t  \t Blue \t  \t  \n");                                                          //color
    printf("Solid\tSolid\tSolid\tSolid\tSolid\n");                                    //dashstyle
    printf("0\t0\t0\t0\t0\n");                                    //marker
    printf("circle\tcircle\tcircle\tcircle\tcircle\n");
    printf("%s [%s]\t%s\tcircle\ttriangle-down\tdiamond\n",$grootheid,$eenheid,$omschrijving);
    //printf("GRENS one");
    $grens_waarden=0;
    //printf("GRENS zero");
    
  }
  else if ( ($j==0)&&($grens_waarden==1))
  {
    printf("kritischboven \t acceptabelboven \t %s \t acceptabelonder \t kritischonder \n",$value);         //name 
    printf("Red \t Orange \t Blue \t Orange \t Red \n");                                                          //color
    printf("ShortDot\tShortDot\tSolid\tShortDot\tShortDot\n");                                    //dashstyle
    printf("0\t0\t0\t0\t0\n");                                    //marker
    printf("diamond\ttriangle\tcircle\ttriangle-down\tdiamond\n");
    printf("%s [%s]\t%s\tcircle\ttriangle-down\tdiamond\n",$grootheid,$eenheid,$omschrijving);
    //printf("GRENS one");
  }
  //printf("GRENS %d",$grens_waarden);

  $tijd = strtotime(sprintf("%s UTC",$field_results->date_time)); 
  
  if ($grens_waarden==1)
  {
    printf("%s \t %s \t %s \t %s \t %s \t %s \n",$tijd,$grens_kritisch_boven,$grens_acceptabel_boven,$field_results->waarde,$grens_acceptabel_onder,$grens_kritisch_onder);
  }
  if ($grens_waarden==0)
  {
    printf("%s \t %s \t %s \t %s \t %s \t %s \n",$tijd,$field_results->waarde,$field_results->waarde,$field_results->waarde,$field_results->waarde,$field_results->waarde);
  }
  $j++;
 
}


mysql_free_result($result_floating); 



?> 