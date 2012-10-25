<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$subject=$_GET['subject'];
$cluster=$_GET['cluster'];
$term=$_GET['term'];

$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$v=$_GET['v'];
$offset=0;
if (!empty($_GET['offset']))
{
  $offset=$_GET['offset'];
}

$left_frame=sprintf("marks_select_left.php?school_year=$school_year&school=$school&department=$department&class=$class&term=$term&subject=$subject&cluster=$cluster&v=$v&t=%d",time());
$right_frame=sprintf("marks_select_right.php?school_year=$school_year&school=$school&department=$department&class=$class&term=$term&subject=$subject&cluster=$cluster&v=$v&t=%d",time());

$start_page = new Smarty_NM();

$start_page->assign("left_frame",$left_frame);
$start_page->assign("right_frame",$right_frame);

$start_page->display("left_right_page.tpl");

?>
