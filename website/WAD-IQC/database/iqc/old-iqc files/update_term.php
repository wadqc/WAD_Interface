<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];

$term='';
if (!empty($_POST['term']))
{
  $term=$_POST['term'];
}
$lock='';
if (!empty($_POST['lock']))
{
  $lock=$_POST['lock'];
}
$start_date_1_Year='';
$start_date_1_Month='';
$start_date_1_Day='';
$start_date_2_Year='';
$start_date_2_Month='';
$start_date_2_Day='';
$start_date_3_Year='';
$start_date_3_Month='';
$start_date_3_Day='';
$start_date_4_Year='';
$start_date_4_Month='';
$start_date_4_Day='';
$start_date_5_Year='';
$start_date_5_Month='';
$start_date_5_Day='';
$start_date_6_Year='';
$start_date_6_Month='';
$start_date_6_Day='';
$stop_date_1_Year='';
$stop_date_1_Month='';
$stop_date_1_Day='';
$stop_date_2_Year='';
$stop_date_2_Month='';
$stop_date_2_Day='';
$stop_date_3_Year='';
$stop_date_3_Month='';
$stop_date_3_Day='';
$stop_date_4_Year='';
$stop_date_4_Month='';
$stop_date_4_Day='';
$stop_date_5_Year='';
$stop_date_5_Month='';
$stop_date_5_Day='';
$stop_date_6_Year='';
$stop_date_6_Month='';
$stop_date_6_Day='';






//start date
if (!empty($_POST['start_date_1_Year']))
{ 
   $start_date_1_Year=$_POST['start_date_1_Year'];
}
if (!empty($_POST['start_date_1_Month']))
{ 
  $start_date_1_Month=$_POST['start_date_1_Month'];
}
if (!empty($_POST['start_date_1_Day']))
{ 
  $start_date_1_Day=$_POST['start_date_1_Day'];
}

if (!empty($_POST['start_date_2_Year']))
{ 
   $start_date_2_Year=$_POST['start_date_2_Year'];
}
if (!empty($_POST['start_date_2_Month']))
{ 
  $start_date_2_Month=$_POST['start_date_2_Month'];
}
if (!empty($_POST['start_date_2_Day']))
{ 
  $start_date_2_Day=$_POST['start_date_2_Day'];
}

if (!empty($_POST['start_date_3_Year']))
{ 
   $start_date_3_Year=$_POST['start_date_3_Year'];
}
if (!empty($_POST['start_date_3_Month']))
{ 
  $start_date_3_Month=$_POST['start_date_3_Month'];
}
if (!empty($_POST['start_date_3_Day']))
{ 
  $start_date_3_Day=$_POST['start_date_3_Day'];
}

if (!empty($_POST['start_date_4_Year']))
{ 
   $start_date_4_Year=$_POST['start_date_4_Year'];
}
if (!empty($_POST['start_date_4_Month']))
{ 
  $start_date_4_Month=$_POST['start_date_4_Month'];
}
if (!empty($_POST['start_date_4_Day']))
{ 
  $start_date_4_Day=$_POST['start_date_4_Day'];
}

if (!empty($_POST['start_date_5_Year']))
{ 
   $start_date_5_Year=$_POST['start_date_5_Year'];
}
if (!empty($_POST['start_date_5_Month']))
{ 
  $start_date_5_Month=$_POST['start_date_5_Month'];
}
if (!empty($_POST['start_date_5_Day']))
{ 
  $start_date_5_Day=$_POST['start_date_5_Day'];
}

if (!empty($_POST['start_date_6_Year']))
{ 
   $start_date_6_Year=$_POST['start_date_6_Year'];
}
if (!empty($_POST['start_date_6_Month']))
{ 
  $start_date_6_Month=$_POST['start_date_6_Month'];
}
if (!empty($_POST['start_date_6_Day']))
{ 
  $start_date_6_Day=$_POST['start_date_6_Day'];
}

//stop date

if (!empty($_POST['stop_date_1_Year']))
{ 
   $stop_date_1_Year=$_POST['stop_date_1_Year'];
}
if (!empty($_POST['stop_date_1_Month']))
{ 
  $stop_date_1_Month=$_POST['stop_date_1_Month'];
}
if (!empty($_POST['stop_date_1_Day']))
{ 
  $stop_date_1_Day=$_POST['stop_date_1_Day'];
}

if (!empty($_POST['stop_date_2_Year']))
{ 
   $stop_date_2_Year=$_POST['stop_date_2_Year'];
}
if (!empty($_POST['stop_date_2_Month']))
{ 
  $stop_date_2_Month=$_POST['stop_date_2_Month'];
}
if (!empty($_POST['stop_date_2_Day']))
{ 
  $stop_date_2_Day=$_POST['stop_date_2_Day'];
}

if (!empty($_POST['stop_date_3_Year']))
{ 
   $stop_date_3_Year=$_POST['stop_date_3_Year'];
}
if (!empty($_POST['stop_date_3_Month']))
{ 
  $stop_date_3_Month=$_POST['stop_date_3_Month'];
}
if (!empty($_POST['stop_date_3_Day']))
{ 
  $stop_date_3_Day=$_POST['stop_date_3_Day'];
}

if (!empty($_POST['stop_date_4_Year']))
{ 
   $stop_date_4_Year=$_POST['stop_date_4_Year'];
}
if (!empty($_POST['stop_date_4_Month']))
{ 
  $stop_date_4_Month=$_POST['stop_date_4_Month'];
}
if (!empty($_POST['stop_date_4_Day']))
{ 
  $stop_date_4_Day=$_POST['stop_date_4_Day'];
}

if (!empty($_POST['stop_date_5_Year']))
{ 
   $stop_date_5_Year=$_POST['stop_date_5_Year'];
}
if (!empty($_POST['stop_date_5_Month']))
{ 
  $stop_date_5_Month=$_POST['stop_date_5_Month'];
}
if (!empty($_POST['stop_date_5_Day']))
{ 
  $stop_date_5_Day=$_POST['stop_date_5_Day'];
}

if (!empty($_POST['stop_date_6_Year']))
{ 
   $stop_date_6_Year=$_POST['stop_date_6_Year'];
}
if (!empty($_POST['stop_date_6_Month']))
{ 
  $stop_date_6_Month=$_POST['stop_date_6_Month'];
}
if (!empty($_POST['stop_date_6_Day']))
{ 
  $stop_date_6_Day=$_POST['stop_date_6_Day'];
}

 



$table_year='year';
$table_school='school';
$table_term='term';

$addStmt = "Insert into $table_term(term,start_date,stop_date,locked,year_ref) values ('%s','%s','%s','%s','%d')";

$updateStmt = "Update $table_term set term='%s', start_date='%s',
stop_date='%s', locked='%s' where
$table_term.term_ref='%d'";

$deleteStmt = "DELETE from $table_term WHERE $table_term.term_ref='%d'";

$year_Stmt = "SELECT * from $table_school,$table_year where 
$table_school.school_ref=$table_year.school_ref and
$table_school.school='$school' and
$table_year.year='$school_year'";

$term_Stmt = "SELECT * from $table_term where 
$table_term.year_ref='%d' and $table_term.term='%d'
order by $table_term.term";

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

  if (!($result_year=mysql_query($year_Stmt,$link))) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", $term_Stmt)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
  }
  
  $field_year = mysql_fetch_object($result_year);
  $year_ref=$field_year->year_ref;
  mysql_free_result($result_year);

  
  $term_key=array_keys($term_list);
  $i=0;
  while ($i<sizeof($term_key)) // loop for $term_key
  { 
    $term_selected='';
    $lock_selected='';
    if (!empty($term[$term_key[$i]]))
    {
      $term_selected='on';
    }
    if (!empty($lock[$term_key[$i]]))
    {
      $lock_selected='on';
    }

    if ($term_key[$i]=='1') 
    {
      $start_date=sprintf("%s-%s-%s",$start_date_1_Year,$start_date_1_Month,$start_date_1_Day);
      $stop_date=sprintf("%s-%s-%s",$stop_date_1_Year,$stop_date_1_Month,$stop_date_1_Day);
    }
    if ($term_key[$i]=='2') 
    {
      $start_date=sprintf("%s-%s-%s",$start_date_2_Year,$start_date_2_Month,$start_date_2_Day);
      $stop_date=sprintf("%s-%s-%s",$stop_date_2_Year,$stop_date_2_Month,$stop_date_2_Day);
    }
    if ($term_key[$i]=='3') 
    {
      $start_date=sprintf("%s-%s-%s",$start_date_3_Year,$start_date_3_Month,$start_date_3_Day);
      $stop_date=sprintf("%s-%s-%s",$stop_date_3_Year,$stop_date_3_Month,$stop_date_3_Day);
    }
    if ($term_key[$i]=='4') 
    {
      $start_date=sprintf("%s-%s-%s",$start_date_4_Year,$start_date_4_Month,$start_date_4_Day);
      $stop_date=sprintf("%s-%s-%s",$stop_date_4_Year,$stop_date_4_Month,$stop_date_4_Day);
    }
    if ($term_key[$i]=='5') 
    {
      $start_date=sprintf("%s-%s-%s",$start_date_5_Year,$start_date_5_Month,$start_date_5_Day);
      $stop_date=sprintf("%s-%s-%s",$stop_date_5_Year,$stop_date_5_Month,$stop_date_5_Day);
    }
    if ($term_key[$i]=='6') 
    {
      $start_date=sprintf("%s-%s-%s",$start_date_6_Year,$start_date_6_Month,$start_date_6_Day);
      $stop_date=sprintf("%s-%s-%s",$stop_date_6_Year,$stop_date_6_Month,$stop_date_6_Day);
    }

    //verify if term excist
    
    if (!($result_term=mysql_query(sprintf($term_Stmt,$year_ref,$term_key[$i]),$link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $term_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit(); }
    $term_ref=-1;
    while ($field_term = mysql_fetch_object($result_term))
    {
      $term_ref=$field_term->term_ref;
    }
    mysql_free_result($result_term);
    
    if ($term_selected=='on') //update or create
    {    
      if ($term_ref>0) //update term
      {
        if(!(mysql_query(sprintf($updateStmt,$term_key[$i],$start_date,$stop_date,$lock_selected,$term_ref),$link)))
        {
          DisplayErrMsg(sprintf("Error in executing %s stmt", $term_Stmt)) ;
          DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
          exit();
        }
      } 
      if ($term_ref<0) //create term
      {
        if(!(mysql_query(sprintf($addStmt,$term_key[$i],$start_date,$stop_date,$lock_selected,$year_ref),$link)))
        {
          DisplayErrMsg(sprintf("Error in executing %s stmt", $addStmt)) ;
          DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
          exit();
        }
      }
    }
    if ($term_selected!='on') //delete
    {    
      if ($term_ref>0) //delete term
      {
        if (!(mysql_query(sprintf($deleteStmt,$term_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in executing %s stmt", $term_Stmt)) ;
          DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
          exit() ;
        }
      } 
    }
    $i++;
  }
  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("create_terms.php?school_year=$school_year&school=$school&t=%d",time());
  header($executestring);
  exit();

?>
