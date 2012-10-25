<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


if (empty($_POST['down_x']))
{
  $down_x=-1;
}
if (!empty($_POST['down_x']))
{
  $down_x=$_POST['down_x'];
}


if (empty($_POST['up_x']))
{
  $up_x=-1;
}
if (!empty($_POST['up_x']))
{
  $up_x=$_POST['up_x'];
}



$table_presention='presention_subject';

$addStmt = "Insert into $table_presention(date,comment,value,subjects_ref) values ('%s','%s','%s','%d')";

$deleteStmt = "DELETE from $table_presention WHERE
$table_presention.subjects_ref='%d'and 
$table_presention.date='%s'"; 


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



  if (!empty($presention_check))
  {
    $subjects_ref_key=array_keys($presention_check);
  
    $first_key=$subjects_ref_key[0];
  }
   
  $i=0;
 
  if (!empty($presention_check)) 
  {

  while ($i<sizeof($subjects_ref_key)) // loop for $subjects_ref
  {
    //delete all excisting marks for subjects_ref equal to $subjects_ref[$i]
    if (!(mysql_query(sprintf($deleteStmt,$subjects_ref_key[$i],$datum),$link))) 
    {
      DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
      exit() ;
    }

     
    if ($presention_check[$subjects_ref_key[$i]]=="on")
    {  //rebuild all data (new and modified) for subjects_ref equal to $subjects_ref[$i]
       
        if (!(mysql_query(sprintf($addStmt,$datum,$presention_comment[$subjects_ref_key[$i]],$presention_check[$subjects_ref_key[$i]],$subjects_ref_key[$i]),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      
    }

   $i++;
  } //loop for subject_ref
  
  }//loop for presention_check

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= sprintf("subject_presention.php?stamp=$stamp&year=$year&department=$department&klas=$klas&subject=$subject&group=$group&v=$v&up_x=$up_x&down_x=$down_x&t=%d",time());

  header($executestring);
  exit();

?>