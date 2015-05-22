<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");
require("./excel-function.php");



$table_study='study';
$table_series='series';
$table_instance='instance';



$table_resultaten_floating='resultaten_floating';
$table_study='study';
$table_patient='patient';
$table_gewenste_processen='gewenste_processen';
$table_selector='selector';
$table_resultaten_status='resultaten_status';



$v=0;
$v=$_GET['v'];




$analyse_level='study';
if (!empty($_GET['analyse_level']))
{
  $analyse_level=$_GET['analyse_level'];
}


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



$selector_fk=0;
if (!empty($_GET['selector_fk']))
{
  $selector_fk=$_GET['selector_fk'];
}

$omschrijving="%%";

if (isset($_GET['omschrijving']))
{
  $omschrijving=$_GET['omschrijving'];
} elseif (isset($_POST['omschrijving']))
{
  $omschrijving=$_POST['omschrijving'];
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



$results_dosis_Stmt="SELECT $table_resultaten_floating.omschrijving as omschrijving, $table_resultaten_floating.grootheid as grootheid,$table_resultaten_floating.waarde as waarde, $table_resultaten_floating.eenheid as eenheid, 
$table_study.study_datetime as study_datetime,  
round((DATEDIFF(study.study_datetime,patient.pat_birthdate)/365),0) as leeftijd, $table_study.accession_no as accession_no
from 
($table_selector
inner join 
($table_gewenste_processen
  inner join $table_resultaten_floating
  on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk
) on 
$table_selector.pk=$table_gewenste_processen.selector_fk) 
inner join 
($table_study 
  inner join 
  $table_patient on $table_patient.pk=$table_study.patient_fk
) on
$table_study.pk=$table_gewenste_processen.study_fk
where $table_selector.pk='%d'and
$table_resultaten_floating.omschrijving like '$omschrijving'
order by study_datetime,omschrijving";









// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!$link->set_charset('utf8')) {
    printf("Error loading character set utf8: %s\n", $link->error);
}
  
   
   if (!($result_dosis= $link->query(sprintf($results_dosis_Stmt,$selector_fk) ) )) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_dosis_Stmt,$selector_fk)) );
   DisplayErrMsg(sprintf("error:%d %s", $link->error(), mysql_error($link))) ;
   exit() ;
   }






while ($row = $result_dosis->fetch_assoc() )
{
   $output[] = $row;
}


$result_dosis->close();

$contents = getExcelData($output);
$contents = "\xFF\xFE".iconv("UTF-8","UCS-2LE",$contents);




$filename = sprintf("IQC-floating_data-%s.xls",$omschrijving);

//prepare to give the user a Save/Open dialog...


header ("Content-type: application/vnd.ms-excel; charset=UTF-8");


header ("Content-Disposition: attachment; filename=".$filename);






//And specify extension as xlsx





//setting the cache expiration to 30 seconds ahead of current time. an IE 8 issue when opening the data directly in the browser without first saving it to a file
$expiredate = time() + 30;
$expireheader = "Expires: ".gmdate("D, d M Y G:i:s",$expiredate)." GMT";
header ($expireheader);

//output the contents
echo $contents;
//echo $retval;
exit;
?>

