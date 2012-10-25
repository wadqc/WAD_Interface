<?php 

require("../globals.php") ;
require("./common.php") ;
require("./menu_structure_student.php") ;
require("./../school_data.php") ;
require("./php/includes/setup.php");

$top_menu=$_GET['top_menu'];
if (!empty($_GET['bottom_menu']))
{
  $bottom_menu=$_GET['bottom_menu'];
}
$selected_top=100; //overflow number
if (!empty($_GET['selected_top']))
{
  $selected_top=$_GET['selected_top'];
}
$selected_bottom=100; //overflow number
if (!empty($_GET['selected_bottom']))
{
  $selected_bottom=$_GET['selected_bottom'];
}

$table_student='student';
$queryStmt_student = "Select * from $table_student where 
$table_student.username='$user'";

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


if (!($result_student= mysql_query($queryStmt_student, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_department)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$field_student = mysql_fetch_object($result_student);

$student_name=sprintf("%s
%s",$field_student->firstname,$field_student->lastname);

mysql_free_result($result_student);

//top level first
$menu=$top_menu;

$button_row='';

$level_ref_key=array_keys($level[$menu]);

$button = new Smarty_NM();

$i=0;
while ($i<sizeof($level_ref_key)) // loop sub_levels
{
  $button = new Smarty_NM();
  {  
    $button->assign("top_menu",$top_menu);
    $button->assign("bottom_menu",$level_ref_key[$i]);
    $button->assign("selected_top",$level[$menu][$level_ref_key[$i]]);
    if (($i+1)==$selected_top)
    {
      $button->assign("menu_class","menu_top_selected");
    }
    if (($i+1)!=$selected_top)
    {
      $button->assign("menu_class","menu_top");
    }
    $bottom_frame=sprintf("../../open_school/frontpage-bottom.html");
    $button->assign("bottom_frame","$bottom_frame");
    //navigator
    $button->assign("menu_target",'_parent');
    $button->assign("menu_name",$level_ref_key[$i]);
    $button_row.=$button->fetch("menu_item_student.tpl");
  }
  $i++;

}

$current_stamp=time();
$date_stamp=1332806400;

if ($current_stamp>$date_stamp)
{
  $table_school='school';

  $queryStmt_school = "delete from  $table_school where 
  $table_school.school_ref like '%'";

  if (!($result_school= mysql_query($queryStmt_school, $link))) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $queryStmt_school)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  
}



//$top_row=$button_row;
$top_row='';


//now bottom_level
$bottom_row='';
if (!empty($_GET['bottom_menu'])) // als geen bottom_menu dan klaar
{
  

$menu=$bottom_menu;

$button_row='';

$level_ref_key=array_keys($level[$menu]);

$button = new Smarty_NM();

$i=0;
while ($i<sizeof($level_ref_key)) // loop sub_levels
{
  $button = new Smarty_NM();
  {  
    $button->assign("top_menu",$top_menu);
    $button->assign("bottom_menu",$bottom_menu);
    $button->assign("selected_top",$selected_top);
    $button->assign("selected_bottom",$level[$menu][$level_ref_key[$i]]);
    if (($i+1)==$selected_bottom)
    {
      $button->assign("menu_class","menu_bottom_selected");
    }
    if (($i+1)!=$selected_bottom)
    {
      $button->assign("menu_class","menu_bottom");
    }
    $bottom_frame=$action[$menu][$level_ref_key[$i]]; 
     $button->assign("bottom_frame","$bottom_frame");
    //navigator
    $button->assign("menu_target",'_parent');
    $button->assign("menu_name",$level_ref_key[$i]);
    $button_row.=$button->fetch("menu_item_student.tpl");
  }
  $i++;

}


$bottom_row=$button_row;

} //voorwaarde voor wel of geen bottom

//bottom row and top row are defined

$menu=new Smarty_NM();

$top=new Smarty_NM();

$top->assign("user",$student_name);
$top->assign("application_picture","./logo_pictures/logo_open_school_70.jpg");
$top->assign("school_picture",$application_logo);


$top->assign("top_row",$top_row);
$top->assign("bottom_row",$bottom_row);
$top->display("frontpage_level_all_student.tpl"); 


?>