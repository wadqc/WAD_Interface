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
$table_skill='skill';
$table_skill_sub='skill_sub';


$year_verification_Stmt = "SELECT * from $table_school,$table_year,$table_skill where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_skill.year_ref and
$table_skill.skill_ref='%d'";

$skill_Stmt = "SELECT * from $table_skill where 
$table_skill.skill_ref='%d'";

$skill_sub_Stmt = "SELECT * from $table_skill_sub where
$table_skill_sub.skill_ref='%d'";

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
if (!empty($_POST['skill']))
{
  $skill=$_POST['skill'];
  $skill_ref_key=array_keys($skill);
  $limit=sizeof($skill_ref_key);
} 
if (!empty($_GET['skill']))
{
  $skill=$_GET['skill'];
  $skill_ref_key=array_keys($skill);
  $limit=sizeof($skill_ref_key);
} 

if (($transfer_action=='transfer')&&($limit>0))
{
   //create new school and year if necessary; else determine year_ref
   add_school_school($school_t,&$school_ref);  
   add_school_year($school_year_t,$school_ref,&$year_ref);
 
   //perform year verification for a random value of skill_ref

   if (!($result_year_verification= mysql_query(sprintf($year_verification_Stmt,$skill_ref_key[0]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
   $field_year_verification = mysql_fetch_object($result_year_verification);

   if ($year_ref== $field_year_verification->year_ref)
   {
      GenerateHTMLHeader("The skill can not be transfered to the same school year");
      ReturnToMain();
      exit(1);
   }
   mysql_free_result($result_year_verification);
}


  
$i=0;
while ($i<$limit) // loop for $skill_ref
{
  if (($transfer_action=='transfer')&&($skill[$skill_ref_key[$i]]=='on'))
  {
    if (!($result_skill= mysql_query(sprintf($skill_Stmt,$skill_ref_key[$i]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    $field_skill = mysql_fetch_object($result_skill);
    
    // create new skill
    add_school_skill($field_skill->skill,$field_skill->abreviation,$field_skill->number,$year_ref,&$skill_ref);
    
    mysql_free_result($result_skill);
        
    if (!($result_skill_sub = mysql_query(sprintf($skill_sub_Stmt,$skill_ref_key[$i]),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
    
    while($field_skill_sub = mysql_fetch_object($result_skill_sub))
    {
      // create new skill_sub
      add_school_sub_skill($field_skill_sub->skill_sub,$field_skill_sub->code,$field_skill_sub->number,$skill_ref,&$skill_sub_ref);
    }
    mysql_free_result($result_skill_sub);
  } // end transfer action and skill=on

  if (($transfer_action=='delete')&&($skill[$skill_ref_key[$i]]=='on'))
  {
    delete_skill($skill_ref_key[$i],&$year_ref,&$school_ref);
  } // end delete action and skill=on}

  $i++;
}// end loop for skill_ref   


if ($transfer_action=='delete')
{
    if ($limit>0)
    {
      delete_year($year_ref,$school_ref); 
    }
    $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
    $executestring.= sprintf("create_skills.php?school=$school&school_year=$school_year&t=%d",time());
    header($executestring);
    exit();

   //GenerateHTMLHeader("The skill structure was deleted succesfully");
}


if ($transfer_action=='transfer')
{
  GenerateHTMLHeader("The skill structure was transfered succesfully");
}
ReturnToMain();

?>




