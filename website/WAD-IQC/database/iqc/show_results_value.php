<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_resultaten_floating='resultaten_floating';
$table_resultaten_char='resultaten_char';
$table_resultaten_object='resultaten_object';
$table_gewenste_processen='gewenste_processen';
$table_selector='selector';


$v=$_GET['v'];
$selector_fk=0;
if (!empty($_GET['selector_fk']))
{
  $selector_fk=$_GET['selector_fk'];
}
$omschrijving="%%";
if (!empty($_GET['omschrijving']))
{
  $omschrijving=$_GET['omschrijving'];
}
$grootheid="%%";
if (!empty($_GET['grootheid']))
{
  $grootheid=$_GET['grootheid'];
}
$eenheid="%%";
if (!empty($_GET['eenheid']))
{
  $eenheid=$_GET['eenheid'];
}

$omschrijving_char="%%";
if (!empty($_GET['omschrijving_char']))
{
  $omschrijving_char=$_GET['omschrijving_char'];
}

//$omschrijving_object="%";
//if (!empty($_GET['omschrijving_object']))
//{
//  $omschrijving_object=$_GET['omschrijving_object'];
//}


$analyse_level='';
if (!empty($_GET['analyse_level']))
{
  $analyse_level=$_GET['analyse_level'];
}



$gewenste_processen_id=0;
if (!empty($_POST['gewenste_processen_id']))
{
  $gewenste_processen_id=$_POST['gewenste_processen_id'];
}
if (!empty($_GET['gewenste_processen_id']))
{
  $gewenste_processen_id=$_GET['gewenste_processen_id'];
}

printf("gewenste processen id: %s",$gewenste_processen_id);



$results_floating_Stmt="SELECT * from $table_gewenste_processen inner join $table_resultaten_floating on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk 
and $table_resultaten_floating.omschrijving like '$omschrijving'
and $table_resultaten_floating.grootheid like '$grootheid' 
and $table_resultaten_floating.eenheid like '$eenheid' 
order by $table_gewenste_processen.pk, $table_resultaten_floating.volgnummer";
//and $table_gewenste_processen.pk='%s'

  
$results_char_Stmt="SELECT  * from $table_gewenste_processen inner join $table_resultaten_char on $table_gewenste_processen.pk=$table_resultaten_char.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk
and $table_resultaten_char.omschrijving like '$omschrijving_char'
order by $table_gewenste_processen.pk, $table_resultaten_char.volgnummer";
//and $table_gewenste_processen.pk='%s'

//$results_object_Stmt="SELECT  $table_resultaten_object.object_naam_pad as 'object_naam_pad', $table_resultaten_object.omschrijving as 'omschrijving', $table_resultaten_object.pk as 'pk' from $table_gewenste_processen inner join $table_resultaten_object on $table_gewenste_processen.pk=$table_resultaten_object.gewenste_processen_fk 
//where $table_gewenste_processen.selector_fk=$selector_fk
//and $table_gewenste_processen.pk='%s' 
//order by $table_gewenste_processen.pk, $table_resultaten_object.volgnummer";
//and $table_resultaten_object.omschrijving like '$omschrijving_object'

//$year_Stmt="SELECT * from $table_gewenste_processen where $table_gewenste_processen.selector_fk=$selector_fk
//order by $table_gewenste_processen.creation_time";


$selector_Stmt="SELECT * from $table_selector
where $table_selector.pk=$selector_fk"; 

$gewenste_processen_Stmt="SELECT * from $table_gewenste_processen
where $table_gewenste_processen.selector_fk=$selector_fk
order by $table_gewenste_processen.pk";

// Connect to the Database
if (!($link=@mysql_pconnect($hostName, $userName, $password))) {
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


//if ($gewenste_processen_id==-1) //first visit, id will be changed to most recent id of table_gewenste_processen
//{
//
//  if (!($result_gewenste_processen= mysql_query($gewenste_processen_Stmt, $link))) {
//    DisplayErrMsg(sprintf("Error in executing %s stmt", $gewenste_processen_Stmt)) ;
//    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
//    exit() ;
//  }
//
//  while (($field_results = mysql_fetch_object($result_gewenste_processen)))
//  {
//    $gewenste_processen_id=$field_results->pk;
//  }
//  mysql_free_result($result_gewenste_processen); 
//} 

if ($gewenste_processen_id==0) //wildcard on gewenste_processen_id
{
  $gewenste_processen_id="%";
}
printf($results_floating_Stmt,$gewenste_processen_id);


if (!($result_floating= mysql_query(sprintf($results_floating_Stmt,$gewenste_processen_id), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_floating_Stmt,$gewenste_processen_id)) );
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_char= mysql_query(sprintf($results_char_Stmt,$gewenste_processen_id), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_char_Stmt,$gewenste_processen_id)) );
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

//if (!($result_object= mysql_query(sprintf($results_object_Stmt,$gewenste_processen_id), $link))) {
//   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_object_Stmt,$gewenste_processen_id)) );
//   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
//   exit() ;
//}


if (!($result_selector= mysql_query($selector_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

//if (!($result_year= mysql_query($year_Stmt, $link))) {
//   DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
//   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
//   exit() ;
//}



$field_results = mysql_fetch_object($result_selector);
$header_result=sprintf("Selector: %s, analyse level: %s",$field_results->name,$field_results->analyselevel);
mysql_free_result($result_selector);  


@@@@@@@@@@@@@@@@


//$list_year='';
//while($field = mysql_fetch_object($result_year))
//{
//  $list_year["$field->pk"]="$field->creation_time";
//} 
//mysql_free_result($result_year);
//
//$table_data = new Smarty_NM();
//$table_data->assign("year_options",$list_year);
//$selector_list=$table_data->fetch("selector_select.tpl");








@@@@@@@@@@@@@@@@



$table_resultaten_floating='';


$j=0;
while (($field_results = mysql_fetch_object($result_floating)))
{
  
   $b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }   

   $table_data = new Smarty_NM();
   
   if ($j==0) //define header data
   {
     $table_resultaten_floating=$table_data->fetch("resultaten_floating_header.tpl");
   }

   $action_floating=sprintf("show_results.php?selector_fk=%d&gewenste_processen_id=0&omschrijving=%s&grootheid=%s&eenheid=%s&t=%d",$selector_fk,$field_results->omschrijving,$field_results->grootheid,$field_results->eenheid ,time()); 

     
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("datum",$field_results->creation_time);
   $table_data->assign("omschrijving",$field_results->omschrijving);
   $table_data->assign("grootheid",$field_results->grootheid);
   $table_data->assign("eenheid",$field_results->eenheid);
   $table_data->assign("waarde",$field_results->waarde);
   $table_data->assign("waarde_class","table_data");
   if ( ($field_results->waarde > $field_results->grens_kritisch_boven) or ($field_results->waarde < $field_results->grens_kritisch_onder) )
   {
     $table_data->assign("waarde_class","table_data_red");
   } 
   if ( ($field_results->waarde > $field_results->grens_acceptabel_boven) and ($field_results->waarde < $field_results->grens_kritisch_boven) )
   {
     $table_data->assign("waarde_class","table_data_orange");
   }
   if ( ($field_results->waarde > $field_results->grens_kritisch_onder) and ($field_results->waarde < $field_results->grens_acceptabel_onder) )
   {
     $table_data->assign("waarde_class","table_data_orange");
   }




   $table_data->assign("kritisch_onder",$field_results->grens_kritisch_onder);
   $table_data->assign("kritisch_boven",$field_results->grens_kritisch_boven);
   $table_data->assign("acceptabel_onder",$field_results->grens_acceptabel_onder);
   $table_data->assign("acceptabel_boven",$field_results->grens_acceptabel_boven);


   $table_data->assign("action_floating",$action_floating);
      
   $table_resultaten_floating.=$table_data->fetch("resultaten_floating_row.tpl");

   $j++;
   printf("j=%d",$j);
}


mysql_free_result($result_floating);  

$table_resultaten_char='';


$j=0;
while (($field_results = mysql_fetch_object($result_char)))
{
  
   $b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }   

   $table_data = new Smarty_NM();
   
   if ($j==0) //define header data
   {
     $table_resultaten_char=$table_data->fetch("resultaten_char_header.tpl");
   }

   $action_char=sprintf("show_results.php?selector_fk=%d&gewenste_processen_id=0&omschrijving_char=%s&t=%d",$selector_fk,$field_results->omschrijving,time()); 

     
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("datum",$field_results->creation_time);
   $table_data->assign("omschrijving",$field_results->omschrijving);
   $table_data->assign("waarde",$field_results->waarde);
   $table_data->assign("waarde_class","table_data");
   $table_data->assign("criterium",$field_results->criterium);
   $table_data->assign("action_char",$action_char);
      
   $table_data->assign("waarde_class","table_data_green"); // default is green
   if ( ($field_results->criterium=='') and ($field_results->waarde!=$field_results->criterium) )
   {
     $table_data->assign("waarde_class","table_data_orange"); // assign is criterium not given, but value is
   } 
   if ( ($field_results->criterium!='') and ($field_results->waarde!=$field_results->criterium) )
   {
     $table_data->assign("waarde_class","table_data_red");
   } 

   $table_resultaten_char.=$table_data->fetch("resultaten_char_row.tpl");

   $j++;
}


$data = new Smarty_NM();
$data->assign("Title","Results");
$data->assign("selection_list",$selector_list);
$data->assign("header_result",$header_result);
$data->assign("header_floating","Resultaten floating");
if ($table_resultaten_floating!='')
{
  $data->assign("header_floating","Resultaten floating");
  $data->assign("resultaten_floating_list",$table_resultaten_floating);
}
if ($table_resultaten_char!='')
{
  $data->assign("header_char","Resultaten char");
  $data->assign("resultaten_char_list",$table_resultaten_char);
}
if ($table_resultaten_object!='')
{
  $data->assign("header_object","Resultaten Object");
  $data->assign("resultaten_object_list",$table_resultaten_object);
}

$action_result=sprintf("show_results.php?selector_fk=%d&analyse_level=%s&t=%d",$selector_fk,$analyselevel,time()); 
$data->assign("action_result",$action_result);



$data->display("resultaten_result.tpl");





?>
