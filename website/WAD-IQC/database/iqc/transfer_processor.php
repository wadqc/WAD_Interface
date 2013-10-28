<?php
require("../globals.php");
require("../iqc_data.php");
require("./common.php");
require("./php/includes/setup.php");


if (!empty($_POST['transfer_action']))
{
  $transfer_action=$_POST['transfer_action'];
}
if (!empty($_GET['transfer_action']))
{
  $transfer_action=$_GET['transfer_action'];
}



$table_gewenste_processen='gewenste_processen';
$reset_status=0;

//transfer specific

$gewenste_processen_Stmt="SELECT * from $table_gewenste_processen where
$table_gewenste_processen.pk='%d'";


//delete specific
$del_gewenste_processen = "delete from  $table_gewenste_processen where 
$table_gewenste_processen.pk='%d'";


$updateStmt_gewenste_processen = "Update $table_gewenste_processen set
status='%d' where
$table_gewenste_processen.pk='%d'";

// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",
                             $hostName, $userName)) ;
   exit() ;
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}



$limit=0;
if (!empty($_POST['gewenste_processen']))
{
  $gewenste_processen=$_POST['gewenste_processen'];
  $gewenste_processen_ref_key=array_keys($gewenste_processen);
  $limit=sizeof($gewenste_processen_ref_key);
} 

if (!empty($_GET['gewenste_processen']))
{
  $gewenste_processen=$_POST['gewenste_processen'];
  $gewenste_processen_ref_key=array_keys($gewenste_processen);
  $limit=sizeof($gewenste_processen_ref_key);
} 



  
$i=0;
while ($i<$limit) // loop for $gewenste_processen_ref_key
{
  if (($transfer_action=='delete')&&($gewenste_processen[$gewenste_processen_ref_key[$i]]=='on'))
  {    
    if (!(mysql_query(sprintf($del_gewenste_processen,$gewenste_processen_ref_key[$i]), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($del_gewenste_processen,$gewenste_processen_ref_key[$i]) )) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}
  } // end delete action and users=on
  
  if (($transfer_action=='reset')&&($gewenste_processen[$gewenste_processen_ref_key[$i]]=='on'))
  {
    if (!(mysql_query(sprintf($updateStmt_gewenste_processen,$reset_status,$gewenste_processen_ref_key[$i]), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($updateStmt_gewenste_processen,md5($first_login),$gewenste_processen_ref_key[$i])  )) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}
  } // end reset action and users = on

  $i++;
}// end loop for $gewenste_processen_ref_key



$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
$executestring.= sprintf("status-processor.php?t=%d",time());
header($executestring);
exit();






?>




