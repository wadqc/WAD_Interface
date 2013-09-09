<?php 

require("../globals.php") ;
require("./common.php") ;
require("./selector_function.php") ;

require("./php/includes/setup.php");

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
 


// Connect to the Database
  if (!($link=@mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

// Select the Database
  if (!mysql_select_db($databaseName, $link)) {
    DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }


if( (!empty($_POST['action']))||(!empty($_POST['selector'])) )
{
  
  $pk=$_GET['pk'];

  $selector_patient_pk=$_GET['selector_patient_pk'];
  $selector_study_pk=$_GET['selector_study_pk'];
  $selector_series_pk=$_GET['selector_series_pk'];
  $selector_instance_pk=$_GET['selector_instance_pk'];

  $pk=$_GET['pk'];  
  $selector_name="";
  $selector_description="";

  //Selector
  if (!empty($_POST['selector_name']))
  {
    $selector_name=$_POST['selector_name'];
  }
  if (!empty($_POST['selector_description']))
  {
    $selector_description=$_POST['selector_description'];
  }
  
  //test and config files
  $analysemodule_fk=0;
  if (!empty($_POST['analysemodule_pk']))
  {
     $analysemodule_fk=$_POST['analysemodule_pk'];
  }
  
  $analysemodule_cfg_fk=0;
  if (!empty($_POST['analysemodule_cfg_pk']))
  {
     $analysemodule_cfg_fk=$_POST['analysemodule_cfg_pk'];
  }

   
  $table_selector='selector';
  $key=0;

  if ($pk==0) //Add Selector
  { 

   $add_Stmt = "Insert into $table_selector(name,description,analysemodule_fk,analysemodule_cfg_fk) values ('%s','%s','%s','%s')";

   if(!(mysql_query(sprintf($add_Stmt,$selector_name,$selector_description,$analysemodule_fk,$analysemodule_cfg_fk),$link))) 
   {
     DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($add_Stmt,$selector_name,$selector_description,$analysemodule_fk,$analysemodule_cfg_fk) )) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
   }
   
   printf($add_Stmt,$selector_name,$selector_description,$analysemodule_fk,$analysemodule_cfg_fk);
   exit();

  }//end if $pk==0



  if ($pk!=0)  
  { 
    $update_Stmt = "update $table_selector set name='%s',description='%s',analysemodule_fk='%s',analysemodule_cfg_fk='%s' where pk='%d' ";
  
    if(!(mysql_query(sprintf($update_Stmt,$selector_name,$selector_description,$analysemodule_fk,$analysemodule_cfg_fk,$pk),$link))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($update_Stmt,$selector_name,$selector_description,$analysemodule_fk,$analysemodule_cfg_fk,$pk) )) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
  }//end if pk!=0


} //action

if(!empty($_POST['selector'])) 
{
  $constraint=$_POST['selector'];
  //if (($constraint=='link_father')||($parental=='link_mother')||($parental=='link_parents')||($parental=='link_guardian')||($parental=='delete_father')||($parental=='delete_mother')||($parental=='delete_parents')||($parental=='delete_guardian'))
  //{
    //$executestring.=sprintf("parental_handling.php?parental=$parental&father_ref=$father_ref&mother_ref=$mother_ref&guardian_ref=$guardian_ref&new_selector_ref=$new_selector_ref&t=%d",time());
  //  header($executestring);
//    exit();

  //}
  //if (($constraint=='Add_Patient')||($constraint=='Modify_Patient')||($constraint=='Add_Study')||($constraint=='Modify_Study')||($constraint=='Add_Series')||($constraint=='Modify_Series')||($constraint=='Add_Instance')||($constraint=='Modify_Instance') )
  //{
     
     $executestring.=sprintf("constraint.php?constraint=$constraint&selector_patient_pk=$selector_patient_pk&selector_study_pk=$selector_study_pk&selector_series_pk=$selector_series_pk&selector_instance_pk=$selector_instance_pk&pk=$pk&t=%d",time());
  
     header($executestring);
     exit();
 // }
     
  

}



//////////////////////////////////////////////////////////////////////////////////////////
// if it will get to here it is either:
// the first time
// or it returned from criteria_handling  (criteria definded)
///////////////////////////////////////////////////////////////////////////////////////////


$selector = new Smarty_NM();

if (!empty($_GET['selector'])) 
{
  printf("not empty selector");
  exit();
}
 
if (empty($_GET['selectorl']))  //first visit
{
  $selector_patient_pk=$_GET['selector_patient_pk'];
  $selector_study_pk=$_GET['selector_study_pk'];
  $selector_series_pk=$_GET['selector_series_pk'];
  $selector_instance_pk=$_GET['selector_instance_pk'];

  $pk=$_GET['pk'];
  
  

  if ($pk==0)  // new selector
  {
      // no default values sofar
  }   

  if ($pk>0)  //update selector
  {
    $table_selector='selector';
    $table_analysemodule='analysemodule';
    $table_analysemodule_cfg='analysemodule_cfg';
  
    $selector_Stmt = "SELECT * from $table_selector where $table_selector.pk='%d'";
    


    if (!($result_selector= mysql_query(sprintf($selector_Stmt,$pk),$link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($selector_Stmt,$pk) )) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
    }
    
    
    if (!($field_selector = mysql_fetch_object($result_selector)))
    {
      DisplayErrMsg("Internal error: the entry does not not exist") ;
      exit() ;
    }
     
    
    $selector->assign("default_selector_name",$field_selector->name);
    $selector->assign("default_selector_description",$field_selector->description);


  

    $selector->assign("analysemodule_id",$field_selector->analysemodule_fk);
    $selector->assign("analysemodule_cfg_id",$field_selector->analysemodule_cfg_fk);


     
     mysql_free_result($result_selector);
  }
} 


$table_pssi='';


$selector_buttons='';

if ($selector_patient_pk==0)
{ 
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Add_Patient');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
}
if ($selector_patient_pk>0)
{
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Modify_Patient');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Delete_Patient');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
}
if ($selector_study_pk==0)
{ 
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Add_Study');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
}
if ($selector_study_pk>0)
{
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Modify_Study');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Delete_Study');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
}
if ($selector_series_pk==0)
{ 
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Add_Series');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
}
if ($selector_series_pk>0)
{
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Modify_Series');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Delete_Series');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
  
}
if ($selector_instance_pk==0)
{ 
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Add_Instance');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
}
if ($selector_instance_pk>0)
{
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Modify_Instance');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Delete_Instance');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
}




$table_selector_buttons='';
$buttons = new Smarty_NM();

$buttons->assign("selector_buttons",$selector_buttons);

$table_selector_buttons=$buttons->fetch("pssi_buttons.tpl");


$selector->assign("submit_value","Insert");

if ($pk>0)
{
  if ( ($selector_patient_pk>0)||($selector_study_pk>0)||($selector_series_pk>0)||($selector_instance_pk>0))  //get selector data
  {
     selector_function_pssi($pk,$selector_patient_pk,$selector_study_pk,$selector_series_pk,$selector_instance_pk,$table_pssi);
  }
  $selector->assign("submit_value","Update");
}








if ($pk!=0)
{
  $selector->assign("table_buttons",$table_selector_buttons);
  $selector->assign("table_pssi",$table_pssi);
}


 
$selector->assign("action_new_selector",sprintf("new_selector.php?pk=$pk&selector_patient_pk=$selector_patient_pk&selector_study_pk=$selector_study_pk&selector_series_pk=$selector_series_pk&selector_instance_pk=$selector_instance_pk&new_selector_ref=$new_selector_ref&t=%d",time()));


  //drop_down_data analysemodule

  
  $table_analysemodule='analysemodule';
  $analysemodule_Stmt = "SELECT * from $table_analysemodule order by $table_analysemodule.filename";

  
  if (!($result_analysemodule= mysql_query($analysemodule_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $analysemodule_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  $analysemodule_list["0"]=" ";  
  while($field_analysemodule = mysql_fetch_object($result_analysemodule)) 
  {
    $analysemodule_name=sprintf("%s",$field_analysemodule->filename);
    $analysemodule_list[$field_analysemodule->pk]=sprintf("%s",$analysemodule_name);
  }
  mysql_free_result($result_analysemodule);
  $selector->assign("analysemodule_options",$analysemodule_list);

  //drop_down_data analysemodule_cfg

  
  $table_analysemodule_cfg='analysemodule_cfg';
  $analysemodule_cfg_Stmt = "SELECT * from $table_analysemodule_cfg order by $table_analysemodule_cfg.filename";

  
  if (!($result_analysemodule_cfg= mysql_query($analysemodule_cfg_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $analysemodule_cfg_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  $analysemodule_cfg_list["0"]=" ";  
  while($field_analysemodule_cfg = mysql_fetch_object($result_analysemodule_cfg)) 
  {
    $analysemodule_cfg_name=sprintf("%s",$field_analysemodule_cfg->filename);
    $analysemodule_cfg_list[$field_analysemodule_cfg->pk]=sprintf("%s",$analysemodule_cfg_name);
  }
  mysql_free_result($result_analysemodule_cfg);
  $selector->assign("analysemodule_cfg_options",$analysemodule_cfg_list);

    
  $selector->display("new_selector.tpl");
    
?>












