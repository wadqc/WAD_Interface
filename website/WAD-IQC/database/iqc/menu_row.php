<?php 

require("../globals.php") ;
require("./common.php") ;
require("./menu_structure.php") ;
//require("./../school_data.php") ;
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


$table_users='users';
$queryStmt_users = "Select * from $table_users where 
$table_users.login='$user'";

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


if (!($result_users= mysql_query($queryStmt_users, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_department)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$field_users = mysql_fetch_object($result_users);

$users_name=sprintf("%s
%s",$field_users->firstname,$field_users->lastname);

mysql_free_result($result_users);



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
    $bottom_frame=sprintf("../iqc/frontpage-bottom.html");
    $button->assign("bottom_frame","$bottom_frame");
    //navigator
    $button->assign("menu_target",'_parent');
    $button->assign("menu_name",$level_ref_key[$i]);
    $button_row.=$button->fetch("menu_item.tpl");
  }
  $i++;

}








$top_row=$button_row;

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
    $button_row.=$button->fetch("menu_item.tpl");
  }
  $i++;

}


$bottom_row=$button_row;

} //voorwaarde voor wel of geen bottom

//bottom row and top row are defined


//$menu=new Smarty_NM();

$top=new Smarty_NM();

$top->assign("user",$users_name);
$top->assign("application_picture","../../../WAD-logo_pictures/logo_iqc_70.jpg");
$top->assign("version",$version);

$top->assign("top_row",$top_row);
$top->assign("bottom_row",$bottom_row);
$top->display("frontpage_level_all.tpl"); 


?>