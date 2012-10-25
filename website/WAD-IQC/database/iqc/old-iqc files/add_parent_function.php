<?php

function add_father($father_firstname,$father_middlename,$father_lastname,$father_profession,$father_home_address,$father_work_address,$father_neighbourhood,$father_home_phone,$father_work_phone,$father_cell_phone,$father_email_address,$father_ref)
{
  require("../globals.php") ;

  $table_father='father';
  $table_student='student';
  $addStmt = "Insert into $table_father(firstname,middlename,lastname,profession,home_address,work_address,neighbourhood,home_phone,work_phone,cell_phone,email_address) values ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')";

  $delStmt_father = "delete from  $table_father where $table_father.father_ref='%d'";

  $query_Stmt_father ="Select * from $table_father, $table_student where 
  $table_father.father_ref=$table_student.father_ref and
  $table_father.father_ref='$father_ref'";

  $query_Stmt_father_ref ="Select * from $table_father where 
  $table_father.firstname='$father_firstname' and
  $table_father.middlename='$father_middlename' and
  $table_father.lastname='$father_lastname' and
  $table_father.profession='$father_profession' and
  $table_father.home_address='$father_home_address' and
  $table_father.work_address='$father_work_address' and
  $table_father.neighbourhood='$father_neighbourhood' and
  $table_father.home_phone='$father_home_phone' and
  $table_father.work_phone='$father_work_phone' and
  $table_father.cell_phone='$father_cell_phone' and
  $table_father.email_address='$father_email_address'";


  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
     DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  if (!($result_father=mysql_query($query_Stmt_father,$link))) {
    DisplayErrMsg(sprintf("Error in delete patient")) ;
    exit() ;
  }
  $students_father=0;
  while ($field_father=mysql_fetch_object($result_father))
  {
    $students_father++;
  }  
  if ($students_father==1)
  {
    //delete father in case of new father
  }

  //if (!(mysql_query(sprintf($delStmt,0), $link))) {
  //  DisplayErrMsg(sprintf("Error in delete patient")) ;
  //  exit() ;
  //}

  $qStmt=sprintf($addStmt,$father_firstname,$father_middlename,$father_lastname,$father_profession,$father_home_address,$father_work_address,$father_neighbourhood,$father_home_phone,$father_work_phone,$father_cell_phone,$father_email_address);

  if
  (!(mysql_query($qStmt,$link))) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $qStmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  $father_ref=mysql_insert_id($link);
  //if (!($result_father_ref=mysql_query($query_Stmt_father_ref,$link))) {
  //  DisplayErrMsg(sprintf("Error in delete patient")) ;
  //  exit() ;
  //}
  //$field_father_ref=mysql_fetch_object($result_father_ref);
  //$father_ref=$field_father_ref->father_ref;
  //mysql_free_result($result_father_ref);
   
}  

function update_father($father_firstname,$father_middlename,$father_lastname,$father_profession,$father_home_address,$father_work_address,$father_neighbourhood,$father_home_phone,$father_work_phone,$father_cell_phone,$father_email_address,$father_ref)
{
  require("../globals.php") ;

  $table_father='father';
  $table_student='student';
  $update_Stmt = "update $table_father set firstname='%s', middlename='%s', lastname='%s', profession='%s', home_address='%s', work_address='%s', neighbourhood='%s', home_phone='%s', work_phone='%s', cell_phone='%s', email_address='%s' where father_ref='%d'";

  


  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
     DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  $update_Stmt=sprintf($update_Stmt,$father_firstname,$father_middlename,$father_lastname,$father_profession,$father_home_address,$father_work_address,$father_neighbourhood,$father_home_phone,$father_work_phone,$father_cell_phone,$father_email_address,$father_ref);

  if
  (!(mysql_query($update_Stmt,$link))) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $qStmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  
   
}  

function delete_father($father_ref)
{
  require("../globals.php") ;

  $table_father='father';
  $table_student='student';

  $query_Stmt_father ="Select * from $table_father, $table_student where 
  $table_father.father_ref=$table_student.father_ref and
  $table_father.father_ref='$father_ref'";

  $delStmt_father = "delete from  $table_father where $table_father.father_ref='%d'";

  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
     DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  if (!($result_father=mysql_query($query_Stmt_father,$link))) {
     DisplayErrMsg(sprintf("Error in delete patient")) ;
     exit() ;
  }
  $students_father=0;
  while ($field_father=mysql_fetch_object($result_father))
  {
    $students_father++;
  }  
  mysql_free_result($result_father);
 
  if ($students_father<2) //only 1 student, delete father from database
  {
      if (!(mysql_query(sprintf($delStmt_father,$father_ref),$link))) {
      DisplayErrMsg(sprintf("Error in delete patient")) ;
      exit() ;
    }
  }
   
}  


function add_mother($mother_firstname,$mother_middlename,$mother_lastname,$mother_profession,$mother_home_address,$mother_work_address,$mother_neighbourhood,$mother_home_phone,$mother_work_phone,$mother_cell_phone,$mother_email_address,$mother_ref)
{
  require("../globals.php") ;

  $table_mother='mother';
  $table_student='student';
  $addStmt = "Insert into $table_mother(firstname,middlename,lastname,profession,home_address,work_address,neighbourhood,home_phone,work_phone,cell_phone,email_address) values ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')";

  $delStmt_mother = "delete from  $table_mother where $table_mother.mother_ref='%d'";

  $query_Stmt_mother ="Select * from $table_mother, $table_student where 
  $table_mother.mother_ref=$table_student.mother_ref and
  $table_mother.mother_ref='$mother_ref'";

  $query_Stmt_mother_ref ="Select * from $table_mother where 
  $table_mother.firstname='$mother_firstname' and
  $table_mother.middlename='$mother_middlename' and
  $table_mother.lastname='$mother_lastname' and
  $table_mother.profession='$mother_profession' and
  $table_mother.home_address='$mother_home_address' and
  $table_mother.work_address='$mother_work_address' and
  $table_mother.neighbourhood='$mother_neighbourhood' and
  $table_mother.home_phone='$mother_home_phone' and
  $table_mother.work_phone='$mother_work_phone' and
  $table_mother.cell_phone='$mother_cell_phone' and
  $table_mother.email_address='$mother_email_address'";


  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
     DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  if (!($result_mother=mysql_query($query_Stmt_mother,$link))) {
    DisplayErrMsg(sprintf("Error in delete patient")) ;
    exit() ;
  }
  $students_mother=0;
  while ($field_mother=mysql_fetch_object($result_mother))
  {
    $students_mother++;
  }  
  if ($students_mother==1)
  {
    //delete mother in case of new mother
  }

  //if (!(mysql_query(sprintf($delStmt,0), $link))) {
  //  DisplayErrMsg(sprintf("Error in delete patient")) ;
  //  exit() ;
  //}

  $qStmt=sprintf($addStmt,$mother_firstname,$mother_middlename,$mother_lastname,$mother_profession,$mother_home_address,$mother_work_address,$mother_neighbourhood,$mother_home_phone,$mother_work_phone,$mother_cell_phone,$mother_email_address);

  if
  (!(mysql_query($qStmt,$link))) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $qStmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  $mother_ref=mysql_insert_id($link);
  //if (!($result_mother_ref=mysql_query($query_Stmt_mother_ref,$link))) {
  //  DisplayErrMsg(sprintf("Error in delete patient")) ;
  //  exit() ;
  //}
  //$field_mother_ref=mysql_fetch_object($result_mother_ref);
  //$mother_ref=$field_mother_ref->mother_ref;
  //mysql_free_result($result_mother_ref);
   
}  

function update_mother($mother_firstname,$mother_middlename,$mother_lastname,$mother_profession,$mother_home_address,$mother_work_address,$mother_neighbourhood,$mother_home_phone,$mother_work_phone,$mother_cell_phone,$mother_email_address,$mother_ref)
{
  require("../globals.php") ;

  $table_mother='mother';
  $table_student='student';
  $update_Stmt = "update $table_mother set firstname='%s', middlename='%s', lastname='%s', profession='%s', home_address='%s', work_address='%s', neighbourhood='%s', home_phone='%s', work_phone='%s', cell_phone='%s', email_address='%s' where mother_ref='%d'";

  


  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
     DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  $update_Stmt=sprintf($update_Stmt,$mother_firstname,$mother_middlename,$mother_lastname,$mother_profession,$mother_home_address,$mother_work_address,$mother_neighbourhood,$mother_home_phone,$mother_work_phone,$mother_cell_phone,$mother_email_address,$mother_ref);

  if
  (!(mysql_query($update_Stmt,$link))) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $qStmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  
   
}  

function delete_mother($mother_ref)
{
  require("../globals.php") ;

  $table_mother='mother';
  $table_student='student';

  $query_Stmt_mother ="Select * from $table_mother, $table_student where 
  $table_mother.mother_ref=$table_student.mother_ref and
  $table_mother.mother_ref='$mother_ref'";

  $delStmt_mother = "delete from  $table_mother where $table_mother.mother_ref='%d'";

  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
     DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  if (!($result_mother=mysql_query($query_Stmt_mother,$link))) {
     DisplayErrMsg(sprintf("Error in delete patient")) ;
     exit() ;
  }
  $students_mother=0;
  while ($field_mother=mysql_fetch_object($result_mother))
  {
    $students_mother++;
  }  
  mysql_free_result($result_mother);

  if ($students_mother<2) //only 1 student, delete mother from database
  {
    if (!(mysql_query(sprintf($delStmt_mother,$mother_ref),$link))) {
      DisplayErrMsg(sprintf("Error in delete patient")) ;
      exit() ;
    }
  }
   
}  



function add_guardian($guardian_relation,$guardian_firstname,$guardian_middlename,$guardian_lastname,$guardian_profession,$guardian_home_address,$guardian_work_address,$guardian_neighbourhood,$guardian_home_phone,$guardian_work_phone,$guardian_cell_phone,$guardian_email_address,$guardian_ref)
{
  require("../globals.php") ;

  $table_guardian='guardian';
  $table_student='student';
  $addStmt = "Insert into $table_guardian(relation,firstname,middlename,lastname,profession,home_address,work_address,neighbourhood,home_phone,work_phone,cell_phone,email_address) values ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')";

  $delStmt_guardian = "delete from  $table_guardian where $table_guardian.guardian_ref='%d'";

  $query_Stmt_guardian ="Select * from $table_guardian, $table_student where 
  $table_guardian.guardian_ref=$table_student.guardian_ref and
  $table_guardian.guardian_ref='$guardian_ref'";

  $query_Stmt_guardian_ref ="Select * from $table_guardian where 
  $table_guardian.relation='$guardian_relation' and
  $table_guardian.firstname='$guardian_firstname' and
  $table_guardian.middlename='$guardian_middlename' and
  $table_guardian.lastname='$guardian_lastname' and
  $table_guardian.profession='$guardian_profession' and
  $table_guardian.home_address='$guardian_home_address' and
  $table_guardian.work_address='$guardian_work_address' and
  $table_guardian.neighbourhood='$guardian_neighbourhood' and
  $table_guardian.home_phone='$guardian_home_phone' and
  $table_guardian.work_phone='$guardian_work_phone' and
  $table_guardian.cell_phone='$guardian_cell_phone' and
  $table_guardian.email_address='$guardian_email_address'";


  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
     DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  if (!($result_guardian=mysql_query($query_Stmt_guardian,$link))) {
    DisplayErrMsg(sprintf("Error in delete patient")) ;
    exit() ;
  }
  $students_guardian=0;
  while ($field_guardian=mysql_fetch_object($result_guardian))
  {
    $students_guardian++;
  }  
  if ($students_guardian==1)
  {
    //delete guardian in case of new guardian
  }

  //if (!(mysql_query(sprintf($delStmt,0), $link))) {
  //  DisplayErrMsg(sprintf("Error in delete patient")) ;
  //  exit() ;
  //}

  $qStmt=sprintf($addStmt,$guardian_relation,$guardian_firstname,$guardian_middlename,$guardian_lastname,$guardian_profession,$guardian_home_address,$guardian_work_address,$guardian_neighbourhood,$guardian_home_phone,$guardian_work_phone,$guardian_cell_phone,$guardian_email_address);

  if
  (!(mysql_query($qStmt,$link))) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $qStmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  $guardian_ref=mysql_insert_id($link);
  //if (!($result_guardian_ref=mysql_query($query_Stmt_guardian_ref,$link))) {
  //  DisplayErrMsg(sprintf("Error in delete patient")) ;
  //  exit() ;
  //}
  //$field_guardian_ref=mysql_fetch_object($result_guardian_ref);
  //$guardian_ref=$field_guardian_ref->guardian_ref;
  //mysql_free_result($result_guardian_ref);
   
}  

function update_guardian($guardian_relation,$guardian_firstname,$guardian_middlename,$guardian_lastname,$guardian_profession,$guardian_home_address,$guardian_work_address,$guardian_neighbourhood,$guardian_home_phone,$guardian_work_phone,$guardian_cell_phone,$guardian_email_address,$guardian_ref)
{
  require("../globals.php") ;

  $table_guardian='guardian';
  $table_student='student';
  $update_Stmt = "update $table_guardian set relation='%s', firstname='%s', middlename='%s', lastname='%s', profession='%s', home_address='%s', work_address='%s', neighbourhood='%s', home_phone='%s', work_phone='%s', cell_phone='%s', email_address='%s' where guardian_ref='%d'";

  


  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
     DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  $update_Stmt=sprintf($update_Stmt,$guardian_relation,$guardian_firstname,$guardian_middlename,$guardian_lastname,$guardian_profession,$guardian_home_address,$guardian_work_address,$guardian_neighbourhood,$guardian_home_phone,$guardian_work_phone,$guardian_cell_phone,$guardian_email_address,$guardian_ref);

  if
  (!(mysql_query($update_Stmt,$link))) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $qStmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  
   
}  

function delete_guardian($guardian_ref)
{
  require("../globals.php") ;

  $table_guardian='guardian';
  $table_student='student';

  $query_Stmt_guardian ="Select * from $table_guardian, $table_student where 
  $table_guardian.guardian_ref=$table_student.guardian_ref and
  $table_guardian.guardian_ref='$guardian_ref'";

  $delStmt_guardian = "delete from  $table_guardian where $table_guardian.guardian_ref='%d'";

  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
     DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  if (!($result_guardian=mysql_query($query_Stmt_guardian,$link))) {
     DisplayErrMsg(sprintf("Error in delete patient")) ;
     exit() ;
  }
  $students_guardian=0;
  while ($field_guardian=mysql_fetch_object($result_guardian))
  {
    $students_guardian++;
  }  
  mysql_free_result($result_guardian);

  if ($students_guardian<1) //only 1 student, delete guardian from database
  {
    if (!(mysql_query(sprintf($delStmt_guardian,$guardian_ref),$link))) {
      DisplayErrMsg(sprintf("Error in delete patient")) ;
      exit() ;
    }
  }
   
}  














?>