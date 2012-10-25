<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


  $school_table = new Smarty_NM();

  $school_table->assign("school_list",$list_year);
  $school_table->assign("school_id",$fixed_school);
 
  $school_table->assign("school_action","show_school_year.php?v=$v");
 
  $school_table->display("show_school_year.tpl"); 
?>
