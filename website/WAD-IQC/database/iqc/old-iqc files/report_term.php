<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



$v=$_GET['v'];
$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$grade=$_GET['grade'];
$school_year=$_GET['school_year'];
$term=$_POST['term'];

$table_school='school';
$table_year='year';
$table_term='term';

$term_Stmt = "SELECT * from $table_school, $table_year, $table_term where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_term.year_ref and
$table_school.school='$school' and
$table_year.year='$school_year'
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

if (!($result_term= mysql_query($term_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$term_honor_list='';
while($field = mysql_fetch_object($result_term))
{
  $term_honor_list["$field->term"]="$field->term";
} 
mysql_free_result($result_term);

$term_number=$term;


$report_counter=1;

$term_header=sprintf("<tr><td class=\"template_data\"> Report</td>");
$factor_header='';
$average_header='';
$factor = new Smarty_NM();

while ($report_counter<($term_number+2))
{
  if ($report_counter<($term_number+1))
  {
    $term_header.=sprintf("<td class=\"template_data\">Term %s</td>",$report_counter);
  }
  if ($report_counter!=($term_number+1))
  {
    $factor_header.=sprintf("<tr><td class=\"template_data\">%s</td>",$report_counter);
  }
  if ($report_counter==($term_number+1))
  {
    $factor_header.=sprintf("<tr><td class=\"template_data\">%s</td>",'Average');
  }
  $term_counter=1;
  while (($term_counter<($report_counter+1))&&($term_counter<($term_number+1)) )
  {
    $factor_name=sprintf("factor[%s][%s]",$report_counter,$term_counter);   
    $factor->assign("factor_name",$factor_name);
    $factor->assign("factor_options",$list_factor);
    $factor_header.= $factor->fetch("report_term_factor.tpl"); 
    $term_counter++;
  }
  while ($term_counter<($term_number+1))
  {
    $factor_header.=sprintf("<td></td>");
    $term_counter++;
  }
  $factor_header.=sprintf("</tr>");
  $list_term["$report_counter"]=$report_counter;
  $report_counter++;
}
$term_header.=sprintf("</tr>");


$term_factors=$term_header;
$term_factors.=$factor_header;



$data = new Smarty_NM();

$data->assign("header",sprintf("%s %s department:%s",$school,$school_year,$department));
$report_name=sprintf("Create report");

$data->assign("term_options",$list_term);
$data->assign("term_factors",$term_factors);
$data->assign("report_name",$report_name);

$data->assign("term_honor_list",$term_honor_list);
$data->assign("term_honor_id",$term);

if ($v==401)//Term (* main menu reports)
{ 
   $data->assign("report_action",sprintf("report_creation.php?school=%s&department=%s&class=%s&grade=%s&school_year=%s&v=%d&term=$term&t=%d",$school,$department,$class,$grade,$school_year,$v,time()));
}
if ($v==402)//Meeting (* main menu reports)
{ 
   $data->assign("report_action",sprintf("report_selection.php?school=%s&department=%s&class=%s&grade=%s&school_year=%s&v=%d&term=$term&t=%d",$school,$department,$class,$grade,$school_year,$v,time()));
}


$data->display("report_term.tpl");



?>
