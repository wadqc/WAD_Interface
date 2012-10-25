<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$data=new Smarty_NM();
$data->display("students_bottom.tpl");
?>
