<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");
require("./add_school_function.php");
require("./delete_department_function.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];

if (!empty($_POST['school_t']))
{
  $school_t=$_POST['school_t'];
}
if (!empty($_POST['school_year_t']))
{
  $school_year_t=$_POST['school_year_t'];
}
if (!empty($_POST['transfer_action']))
{
  $transfer_action=$_POST['transfer_action'];
}
if (!empty($_GET['transfer_action']))
{
  $transfer_action=$_GET['transfer_action'];
}

$table_school='school';
$table_year='year';
$table_score='score';


$year_verification_Stmt = "SELECT * from $table_school,$table_year,$table_score where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_score.year_ref and
$table_score.score_ref='%d'";

$score_Stmt = "SELECT * from $table_score where 
$table_score.score_ref='%d'";


//delete specific


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
if (!empty($_POST['score']))
{
  $score=$_POST['score'];
  $score_ref_key=array_keys($score);
  $limit=sizeof($score_ref_key);
} 
if (!empty($_GET['score']))
{
  $score=$_GET['score'];
  $score_ref_key=array_keys($score);
  $limit=sizeof($score_ref_key);
} 

if (($transfer_action=='transfer')&&($limit>0))
{
   //create new school and year if necessary; else determine year_ref
   add_school_school($school_t,&$school_ref);  
   add_school_year($school_year_t,$school_ref,&$year_ref);
 
   //perform year verification for a random value of score_ref

   if (!($result_year_verification= mysql_query(sprintf($year_verification_Stmt,$score_ref_key[0]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
   $field_year_verification = mysql_fetch_object($result_year_verification);

   if ($year_ref== $field_year_verification->year_ref)
   {
      GenerateHTMLHeader("The score can not be transfered to the same school year");
      ReturnToMain();
      exit(1);
   }
   mysql_free_result($result_year_verification);
}


  
$i=0;
while ($i<$limit) // loop for $score_ref
{
  if (($transfer_action=='transfer')&&($score[$score_ref_key[$i]]=='on'))
  {
    if (!($result_score= mysql_query(sprintf($score_Stmt,$score_ref_key[$i]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    $field_score = mysql_fetch_object($result_score);
    
    // create new score
    add_school_score($field_score->description,$field_score->score,$field_score->selected_score,$year_ref,&$score_ref);
    
    mysql_free_result($result_score);
        
  } // end transfer action and score=on

  if (($transfer_action=='delete')&&($score[$score_ref_key[$i]]=='on'))
  {
    delete_score($score_ref_key[$i],&$year_ref,&$school_ref);
  } // end delete action and score=on}

  $i++;
}// end loop for score_ref   


if ($transfer_action=='delete')
{
    if ($limit>0)
    {
      delete_year($year_ref,$school_ref); 
    }
    $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
    $executestring.= sprintf("create_score.php?school=$school&school_year=$school_year&t=%d",time());
    header($executestring);
    exit();

   //GenerateHTMLHeader("The score structure was deleted succesfully");
}


if ($transfer_action=='transfer')
{
  GenerateHTMLHeader("The score structure was transfered succesfully");
}
ReturnToMain();

?>




