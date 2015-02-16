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


$results_floating_Stmt="SELECT $table_resultaten_floating.volgnummer as 'waarde', $table_resultaten_char.volgnummer as 'waarde', $table_resultaten_floating.omschrijving as 'omschrijving', $table_resultaten_char.omschrijving as 'omschrijving'
from $table_gewenste_processen inner join $table_resultaten_char on $table_gewenste_processen.pk=$table_resultaten_char.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk 
and $table_gewenste_processen.pk='%s' 
order by 'waarde'";
//inner join $table_resultaten_object on $table_gewenste_processen.pk=$table_resultaten_object.gewenste_processen_fk 

//$results_floating_Stmt="SELECT * from $table_gewenste_processen inner join $table_resultaten_floating on $table_gewenste_processen.pk=$table_resultaten_floating.gewenste_processen_fk 
//where $table_gewenste_processen.selector_fk=$selector_fk 
//and $table_gewenste_processen.pk='%s' 
//and $table_resultaten_floating.omschrijving like '$omschrijving'
//and $table_resultaten_floating.grootheid like '$grootheid' 
//and $table_resultaten_floating.eenheid like '$eenheid' 
//order by $table_gewenste_processen.pk, $table_resultaten_floating.volgnummer";
  
$results_char_Stmt="SELECT  * from $table_gewenste_processen inner join $table_resultaten_char on $table_gewenste_processen.pk=$table_resultaten_char.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%s' 
and $table_resultaten_char.omschrijving like '$omschrijving_char'
order by $table_gewenste_processen.pk, $table_resultaten_char.volgnummer";

$results_object_Stmt="SELECT  $table_resultaten_object.object_naam_pad as 'object_naam_pad', $table_resultaten_object.omschrijving as 'omschrijving', $table_resultaten_object.pk as 'pk' from $table_gewenste_processen inner join $table_resultaten_object on $table_gewenste_processen.pk=$table_resultaten_object.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%s' 
order by $table_gewenste_processen.pk, $table_resultaten_object.volgnummer";
//and $table_resultaten_object.omschrijving like '$omschrijving_object'

$year_Stmt="SELECT * from $table_gewenste_processen where $table_gewenste_processen.selector_fk=$selector_fk
order by $table_gewenste_processen.creation_time";


$selector_Stmt="SELECT * from $table_selector
where $table_selector.pk=$selector_fk"; 

$gewenste_processen_Stmt="SELECT * from $table_gewenste_processen
where $table_gewenste_processen.selector_fk=$selector_fk
order by $table_gewenste_processen.pk";

// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


if ($gewenste_processen_id==-1) //first visit, id will be changed to most recent id of table_gewenste_processen
{

  if (!($result_gewenste_processen= $link->query($gewenste_processen_Stmt))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $gewenste_processen_Stmt)) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
  }

  while (($field_results = $result_gewenste_processen->fetch_object()))
  {
    $gewenste_processen_id=$field_results->pk;
  }
  $result_gewenste_processen->close(); 
} 

//if ($gewenste_processen_id==0) //wildcard on gewenste_processen_id
//{
//  $gewenste_processen_id="%";
//}
//printf($results_floating_Stmt,$gewenste_processen_id);

printf($results_floating_Stmt,$gewenste_processen_id);
if (!($result_floating= $link->query(sprintf($results_floating_Stmt,$gewenste_processen_id)))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_floating_Stmt,$gewenste_processen_id)) );
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}

if (!($result_char= $link->query(sprintf($results_char_Stmt,$gewenste_processen_id)))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_char_Stmt,$gewenste_processen_id)) );
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}

if (!($result_object= $link->query(sprintf($results_object_Stmt,$gewenste_processen_id)))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_object_Stmt,$gewenste_processen_id)) );
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}


if (!($result_selector= $link->query($selector_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}

if (!($result_year= $link->query($year_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}



$field_results = $result_selector->fetch_object();
$header_result=sprintf("Selector: %s, analyse level: %s",$field_results->name,$field_results->analyselevel);
$result_selector->close();  





$list_year='';
while($field = $result_year->fetch_object())
{
  $list_year["$field->pk"]="$field->creation_time";
} 
$result_year->close();

$table_data = new Smarty_NM();
$table_data->assign("year_options",$list_year);
$selector_list=$table_data->fetch("selector_select.tpl");




$table_resultaten_floating='';


$j=0;
while (($field_results = $result_floating->fetch_object()))
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

   $action_floating=sprintf("show_floating_value.php?selector_fk=%d&gewenste_processen_id=0&omschrijving=%s&grootheid=%s&eenheid=%s&t=%d",$selector_fk,$field_results->omschrijving,$field_results->grootheid,$field_results->eenheid ,time()); 

     
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
   
}


$result_floating->close();  

$table_resultaten_char='';


$j=0;
while (($field_results = $result_char->fetch_object()))
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

   $action_char=sprintf("show_char_value.php?selector_fk=%d&gewenste_processen_id=0&omschrijving_char=%s&t=%d",$selector_fk,$field_results->omschrijving,time()); 

     
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("datum",$field_results->creation_time);
   $table_data->assign("omschrijving",$field_results->omschrijving);
   $table_data->assign("waarde",$field_results->waarde);
   
   $table_data->assign("action_char",$action_char);
      
   $table_resultaten_char.=$table_data->fetch("resultaten_char_row.tpl");

   $j++;
}


$result_char->close(); 




$table_resultaten_object='';
$name_row='';
$picture_row='';
$b=0;

$j=0;
while (($field_results = $result_object->fetch_object()))
{
  
   $b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }   

   $picture = new Smarty_NM();
   $description_name = new Smarty_NM();

      
   $action_object=sprintf("show_object.php?pk=%d&t=%d",$field_results->pk,time()); 

     
   

   $picture_src=sprintf("image_resize.php?f_name=$field_results->object_naam_pad&height=120");
   $picture->assign("picture_src",$picture_src);
   $picture->assign("picture_action",$action_object);
   $picture_row.=$picture->fetch("insert_picture_row.tpl");
   

   $description_name->assign("picture_name",$field_results->omschrijving);
   $name_row.=$description_name->fetch("insert_picture_name_row.tpl");


   $j++;
   $b=($j%8);
   if (($b==0)&&($j>0))
   {
     $table_resultaten_object.=sprintf("<tr>%s</tr>",$picture_row);
     $table_resultaten_object.=sprintf("<tr>%s</tr>",$name_row);
     $picture_row='';
     $name_row='';
   }
      

}


$result_object->close(); 


if ($b!=0)
{
  while ($b<8)
  {
    $picture_row.=sprintf("<td></td>");
    $name_row.=sprintf("<td></td>");
    $b++;
  }
  $table_resultaten_object.=sprintf("<tr>%s</tr>",$picture_row);
  $table_resultaten_object.=sprintf("<tr>%s</tr>",$name_row);
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