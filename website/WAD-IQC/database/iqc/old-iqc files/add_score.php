<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$v=$_GET['v'];
$mark_border=$_GET['mark_border'];
$subject=$_GET['subject'];
$cluster=$_GET['cluster'];
$school=$_GET['school'];
$department=$_GET['department'];
$grade=$_GET['grade'];
$class=$_GET['class'];
$school_year=$_GET['school_year'];
$term=$_GET['term'];
$default_selected_score=$_GET['default_selected_score'];

if (!empty($_POST['score']))
{
  $score=$_POST['score'];
}

if (!empty($_POST['code']))
{
  $code=$_POST['code'];
}

//$number=$_POST['number'];

$table_school='school';
$table_year='year';
$table_skill='skill';
$table_sub_skill='skill_sub';
$table_category='category';

$categories_Stmt="SELECT * from $table_category where
$table_category.subjects_ref='%d' and
$table_category.skill='%s' and
$table_category.term<='$term'"; 


$addStmt = "Insert into $table_category(term,skill,score,code,subjects_ref) values ('%s','%s','%s','%s','%d')";

$update_Stmt = "Update $table_category set score='%s', code='%s' where  
$table_category.subjects_ref='%d' and
$table_category.term='%s' and
$table_category.skill='%s'";

$deleteStmt = "DELETE from $table_category WHERE $table_category.subjects_ref='%d'
and $table_category.term='$term' and $table_category.skill='%s'";

$skill_Stmt="SELECT * from $table_year, $table_school, $table_skill 
where $table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_skill.year_ref and
$table_school.school='$school' and 
$table_year.year='$school_year'
order by $table_skill.number";

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

//define skill array
if (!($result_skill= mysql_query($skill_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
$j=0;
while ($field_skill = mysql_fetch_object($result_skill))
{
  $skill_array[$j]=$field_skill->skill;
  $skill_ref_array[$j]=$field_skill->skill_ref;
  $j++;
}
mysql_free_result($result_skill); 
$skill_number=count($skill_array);

  $subjects_ref_key=array_keys($score[0]); // 0 as the first value 
  $first_key_subjects_ref=$subjects_ref_key[0];
  
  //writing data to the database
  $i=0;
  while ($i<sizeof($subjects_ref_key)) // loop for $subjects_ref
  {
    $j=0;
    while ($j<$skill_number) //loop for skills
    {
      if (!($result_category=mysql_query(sprintf($categories_Stmt,$subjects_ref_key[$i],$skill_array[$j]),$link)))
      {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $categories_Stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
      }
      $k=0;
      // one row for each skill
      $default_term=0;
      while (($field_category = mysql_fetch_object($result_category)))
      {
        $k++;
        $default_score=$field_category->score;
        $default_code=$field_category->code;
        $default_term=$field_category->term;
      }
      if ($k==0) // no default values;
      {
        $default_score=$default_selected_score;
        $default_code='';
      }
      if ($default_code=='')
      {
        $default_code=' ';
      }
      mysql_free_result($result_category);
      //printf("k=%s default term %s",$k,$default_term);
      if (!empty($code[$j][$subjects_ref_key[$i]]))   //first part
      {
        $skill_score=$score[$j][$subjects_ref_key[$i]];
        $sub_skill_code=$code[$j][$subjects_ref_key[$i]];
                
        if ( ($default_score!=$skill_score)||($default_code!=$sub_skill_code) )
        {
          if ($default_term==$term) 
          {
            $category_deleted=0;
            if (($skill_score==$default_selected_score)&&($sub_skill_code==' '))
            {  //current category (default_term=term) will be deleted
              if (!(mysql_query(sprintf($deleteStmt,$subjects_ref_key[$i],$skill_array[$j]),$link))) 
              {
                DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
                exit() ;
              }
              $category_deleted=1;
            }
            if ($category_deleted==0) 
            {
              //update
              if (!(mysql_query(sprintf($update_Stmt,$skill_score,$sub_skill_code,$subjects_ref_key[$i],$term,$skill_array[$j]),$link))) 
              {
                DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
                exit() ;
              }
            } 
          }
          if ($default_term!=$term) 
          {
            //different category for non excistent row  
            if (!(mysql_query(sprintf($addStmt,$term,$skill_array[$j],$skill_score,$sub_skill_code,$subjects_ref_key[$i]),$link))) 
            {
              DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
              exit() ;
            }
          }
        } 
      }     //end first part    
      if (empty($code[$j][$subjects_ref_key[$i]]))   //second part
      {
        $skill_score=$score[$j][$subjects_ref_key[$i]];
        $sub_skill_code=' ';
          
        
        if ( ($default_score!=$skill_score) )
        {
          if ($default_term==$term) 
          {
            $category_deleted=0;
            if ( ($skill_score==$default_selected_score)&&($k==1) )//delete skill only if no previous skills are available
            {  //current category (default_term=term) will be deleted
              //printf($deleteStmt,$subjects_ref_key[$i],$skill_array[$j]);
              if (!(mysql_query(sprintf($deleteStmt,$subjects_ref_key[$i],$skill_array[$j]),$link))) 
              {
                DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
                exit() ;
              }
              $category_deleted=1; 
            }
            if ($category_deleted==0) 
            {
              //update
              if (!(mysql_query(sprintf($update_Stmt,$skill_score,$sub_skill_code,$subjects_ref_key[$i],$term,$skill_array[$j]),$link))) 
              {
                DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
                exit() ;
              }
            } 
          }
          if ($default_term!=$term) 
          {
            //different category for non excistent row  
            //printf($addStmt,$term,$skill_array[$j],$skill_score,$sub_skill_code,$subjects_ref_key[$i]);
            if (!(mysql_query(sprintf($addStmt,$term,$skill_array[$j],$skill_score,$sub_skill_code,$subjects_ref_key[$i]),$link))) 
            {
              DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
              exit() ;
            }
          }
        } 
      }   //end second part
      $j++;
    } //end of skill loop
    $i++;
  } //end of subjects_ref

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= sprintf("score_select.php?v=$v&subject=$subject&cluster=$cluster&school=$school&department=$department&mark_border=$mark_border&grade=$grade&class=$class&school_year=$school_year&term=$term&t=%d",time());
  header($executestring);
  exit();

?>