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



$results_floating_Stmt="SELECT $table_gewenste_processen.creation_time as 'creation_time', $table_resultaten_floating.omschrijving as 'omschrijving', $table_resultaten_floating.grootheid as 'grootheid', $table_resultaten_floating.eenheid as 'eenheid', $table_resultaten_floating.waarde as 'waarde', $table_resultaten_floating.grens_kritisch_boven as 'grens_kritisch_boven', $table_resultaten_floating.grens_kritisch_onder as 'grens_kritisch_onder', $table_resultaten_floating.grens_acceptabel_boven as 'grens_acceptabel_boven', $table_resultaten_floating.grens_acceptabel_onder as 'grens_acceptabel_onder'
from $table_gewenste_processen inner join $table_resultaten_floating on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk 
and $table_resultaten_floating.omschrijving like '$omschrijving'
and $table_resultaten_floating.grootheid like '$grootheid' 
and $table_resultaten_floating.eenheid like '$eenheid' 
order by $table_gewenste_processen.pk, $table_resultaten_floating.volgnummer";



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




while ($row = mysql_fetch_array($result_floating, MYSQL_ASSOC))
{
   $output[] = $row;
}


mysql_free_result($result_floating);

$contents = getExcelData($output);

//echo $contents;
//exit;


$filename = sprintf("IQC-floating_data-%s.xls",$omschrijving);

//prepare to give the user a Save/Open dialog...


header ("Content-type: application/vnd.ms-excel");
//header ("Content-type: application/octet-stream");
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

