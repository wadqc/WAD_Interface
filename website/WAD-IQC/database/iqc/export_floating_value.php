<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");
require("./excel-function.php");


$table_resultaten_floating='resultaten_floating';
$table_resultaten_char='resultaten_char';
$table_resultaten_object='resultaten_object';
$table_gewenste_processen='gewenste_processen';
$table_selector='selector';


$table_study='study';
$table_series='series';
$table_instance='instance';


//new


//$data = new Smarty_NM();
//$data->display("resultaten_floating_high_charts.tpl");
//exit();



//new





$v=$_GET['v'];
$selector_fk=0;
if (!empty($_GET['selector_fk']))
{
  $selector_fk=$_GET['selector_fk'];
}
$omschrijving="%";
if (!empty($_GET['omschrijving']))
{
  $omschrijving=rawurldecode($_GET['omschrijving']);
}
$grootheid="%";
if (!empty($_GET['grootheid']))
{
  $grootheid=rawurldecode($_GET['grootheid']);
}
$eenheid="%";
if (!empty($_GET['eenheid']))
{
  $eenheid=$_GET['eenheid'];
}

$omschrijving_char="%%";
if (!empty($_GET['omschrijving_char']))
{
  $omschrijving_char=rawurldecode($_GET['omschrijving_char']);
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
  
$results_floating_Stmt="SELECT $table_study.study_datetime as 'datum', $table_resultaten_floating.omschrijving as 'omschrijving', $table_resultaten_floating.grootheid as 'grootheid', $table_resultaten_floating.eenheid as 'eenheid', $table_resultaten_floating.grens_kritisch_boven as 'grens_kritisch_boven', $table_resultaten_floating.grens_kritisch_onder as 'grens_kritisch_onder', $table_resultaten_floating.grens_acceptabel_boven as 'grens_acceptabel_boven', $table_resultaten_floating.grens_acceptabel_onder as 'grens_acceptabel_onder', $table_resultaten_floating.waarde as 'waarde' from $table_study inner join ($table_gewenste_processen inner join $table_resultaten_floating on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk) on $table_study.pk=$table_gewenste_processen.study_fk 
where $table_gewenste_processen.selector_fk=$selector_fk 
and $table_gewenste_processen.status=$status 
and $table_resultaten_floating.omschrijving like '$omschrijving'
and $table_resultaten_floating.grootheid like '$grootheid' 
and $table_resultaten_floating.eenheid like '$eenheid' 
order by $table_gewenste_processen.pk, $table_resultaten_floating.volgnummer";

}



if ($analyse_level=='series')
{

$results_floating_Stmt="SELECT $table_instance.content_datetime as 'datum', $table_resultaten_floating.omschrijving as 'omschrijving', $table_resultaten_floating.grootheid as 'grootheid', $table_resultaten_floating.eenheid as 'eenheid', $table_resultaten_floating.grens_kritisch_boven as 'grens_kritisch_boven', $table_resultaten_floating.grens_kritisch_onder as 'grens_kritisch_onder', $table_resultaten_floating.grens_acceptabel_boven as 'grens_acceptabel_boven', $table_resultaten_floating.grens_acceptabel_onder as 'grens_acceptabel_onder', $table_resultaten_floating.waarde as 'waarde' from $table_series inner join ($table_gewenste_processen inner join $table_resultaten_floating on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk) on $table_series.pk=$table_gewenste_processen.series_fk, $table_instance  
where $table_gewenste_processen.selector_fk=$selector_fk 
and $table_series.pk=$table_instance.series_fk
and $table_instance.pk=(select min(pk) from $table_instance where series_fk=$table_series.pk)
and $table_gewenste_processen.status=$status 
and $table_resultaten_floating.omschrijving like '$omschrijving'
and $table_resultaten_floating.grootheid like '$grootheid' 
and $table_resultaten_floating.eenheid like '$eenheid'  
order by $table_gewenste_processen.pk, $table_resultaten_floating.volgnummer";

}


if ($analyse_level=='instance')
{
  
$results_floating_Stmt="SELECT $table_instance.content_datetime as 'datum', $table_resultaten_floating.omschrijving as 'omschrijving', $table_resultaten_floating.grootheid as 'grootheid', $table_resultaten_floating.eenheid as 'eenheid', $table_resultaten_floating.grens_kritisch_boven as 'grens_kritisch_boven', $table_resultaten_floating.grens_kritisch_onder as 'grens_kritisch_onder', $table_resultaten_floating.grens_acceptabel_boven as 'grens_acceptabel_boven', $table_resultaten_floating.grens_acceptabel_onder as 'grens_acceptabel_onder', $table_resultaten_floating.waarde as 'waarde' from $table_instance inner join ($table_gewenste_processen inner join $table_resultaten_floating on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk) on $table_instance.pk=$table_gewenste_processen.instance_fk 
where $table_gewenste_processen.selector_fk=$selector_fk 
and $table_gewenste_processen.status=$status 
and $table_resultaten_floating.omschrijving like '$omschrijving'
and $table_resultaten_floating.grootheid like '$grootheid' 
and $table_resultaten_floating.eenheid like '$eenheid' 
order by $table_gewenste_processen.pk, $table_resultaten_floating.volgnummer";

}


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



if ($gewenste_processen_id==0) //wildcard on gewenste_processen_id
{
  $gewenste_processen_id="%";
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




while ($row = mysqli_fetch_array($result_floating, MYSQLI_ASSOC))
{
   $output[] = $row;
}


$result_floating->close();

$contents = getExcelData($output);

//echo $contents;
//exit;


$filename = sprintf("IQC-floating_data-%s.xls",$omschrijving);

//prepare to give the user a Save/Open dialog...


header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename);

//setting the cache expiration to 30 seconds ahead of current time. an IE 8 issue when opening the data directly in the browser without first saving it to a file
$expiredate = time() + 30;
$expireheader = "Expires: ".gmdate("D, d M Y G:i:s",$expiredate)." GMT";
header ($expireheader);

//output the contents
echo $contents;
//echo $retval;
exit;
?>

