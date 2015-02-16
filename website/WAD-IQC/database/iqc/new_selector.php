<?php 

require("../globals.php") ;
require("./common.php") ;
require("./selector_function.php") ;

require("./php/includes/setup.php");

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
$title = "New Selector"; 


// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



//drop_down_data categorie

$table_selector_categorie = 'selector_categorie';
$category_list = array();
$category_list[' '] = '';

$category_list_Stmt = "select * from $table_selector_categorie order by omschrijving";

if (!($result_category = $link->query($category_list_Stmt)))
{
   DisplayErrMsg(sprintf("Error in executing %s stmt",$category_list_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}

while ($field_category = $result_category->fetch_object())
{
   $category_list[$field_category->pk] = $field_category->omschrijving;
}

$default_category = ' ';



//action (aanmaken of update van selector)
if( (!empty($_POST['action']))||(!empty($_POST['selector'])) )
{
  
  $pk=$_GET['pk'];

  $selector_patient_fk=$_GET['selector_patient_fk'];
  $selector_study_fk=$_GET['selector_study_fk'];
  $selector_series_fk=$_GET['selector_series_fk'];
  $selector_instance_fk=$_GET['selector_instance_fk'];

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
  if (!empty($_POST['selector_analyselevel']))
  {
    $selector_analyselevel=$_POST['selector_analyselevel'];
  }
  if (!empty($_POST['selector_category']))
  {
    $selector_category_fk=$_POST['selector_category'];
  }
  if (!empty($_POST['selector_modality']))
  {
    $selector_modality=$_POST['selector_modality'];
  }
  if (!empty($_POST['selector_location']))
  {
    $selector_location=$_POST['selector_location'];
  }
  if (!empty($_POST['selector_qc_frequency']))
  {
    $selector_qc_frequency=$_POST['selector_qc_frequency'];
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

   $add_Stmt = "Insert into $table_selector(name,description,analysemodule_fk,analysemodule_cfg_fk,analyselevel,selector_categorie_fk,modaliteit,lokatie,qc_frequentie) values ('%s','%s','%s','%s','%s','%s','%s','%s','%s')";

   if(!($link->query(sprintf($add_Stmt,$selector_name,$selector_description,$analysemodule_fk,$analysemodule_cfg_fk,$selector_analyselevel,$selector_category_fk,$selector_modality,$selector_location,$selector_qc_frequency)))) 
   {
     DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($add_Stmt,$selector_name,$selector_description,$analysemodule_fk,$analysemodule_cfg_fk,$selector_analyselevel,$selector_category_fk,$selector_modality,$selector_location,$selector_qc_frequency) )) ;
     DisplayErrMsg(sprintf("error: %s", $link->error)) ;
     exit() ;
   }
   $executestring.=sprintf("create_selector.php?t=%d",time());
  
   header($executestring);
   exit();
      

  }//end if $pk==0



  if ($pk>0)  
  { 
    $update_Stmt = "update $table_selector set name='%s',description='%s',analysemodule_fk='%s',analysemodule_cfg_fk='%s', analyselevel='%s', selector_categorie_fk='%s', modaliteit='%s', lokatie='%s', qc_frequentie='%s' where pk='%d' ";
  
    if(!($link->query(sprintf($update_Stmt,$selector_name,$selector_description,$analysemodule_fk,$analysemodule_cfg_fk,$selector_analyselevel,$selector_category_fk,$selector_modality,$selector_location,$selector_qc_frequency,$pk)))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($update_Stmt,$selector_name,$selector_description,$analysemodule_fk,$analysemodule_cfg_fk,$selector_analyselevel,$selector_category_fk,$selector_modality,$selector_location,$selector_qc_frequency,$pk) )) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
    }
  }//end if pk!=0


  if ($pk==-1)         //delete
  {
  
  if (!empty($_POST['transfer_action']))
  {
    $transfer_action=$_POST['transfer_action'];
  }


  $table_selector="selector";
  $table_selector_patient="selector_patient";
  $table_selector_study="selector_study";
  $table_selector_series="selector_series";
  $table_selector_instance="selector_instance";  
  

  $selector_Stmt = "SELECT * from $table_selector where $table_selector.pk='%d'";
  $del_selector_Stmt = "delete from  $table_selector where $table_selector.pk='%d'";
  $del_selector_patient_Stmt = "delete from  $table_selector_patient where $table_selector_patient.pk='%d'";
  $del_selector_study_Stmt = "delete from  $table_selector_study where $table_selector_study.pk='%d'";
  $del_selector_series_Stmt = "delete from  $table_selector_series where $table_selector_series.pk='%d'";
  $del_selector_instance_Stmt = "delete from  $table_selector_instance where $table_selector_instance.pk='%d'";

  $limit=0;
  if (!empty($_POST['selector']))
  {
    $selector=$_POST['selector'];
    $selector_ref_key=array_keys($selector);
    $limit=sizeof($selector_ref_key);
  } 
  $i=0;

  while ($i<$limit) // loop for $pk
  {
    if ($selector[$selector_ref_key[$i]]=='on')
    {
    
      if (!($result_Selector= $link->query(sprintf($selector_Stmt,$selector_ref_key[$i])))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($selector_Stmt,$selector_ref_key[$i]) )) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
      }
      $field_selector = $result_Selector->fetch_object();
      
      //selector
      if (!($result_Selector= $link->query(sprintf($del_selector_Stmt,$selector_ref_key[$i])))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($del_selector_Stmt,$selector_ref_key[$i]) )) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;}
      //patient 
      if ($field_selector->selector_patient_fk>0)
      {
        if (!($result_Selector= $link->query(sprintf($del_selector_patient_Stmt,$field_selector->selector_patient_fk)))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($del_selector_patient_Stmt,$field_selector->selector_patient_fk) )) ;
        DisplayErrMsg(sprintf("error: %s", $link->error)) ;
        exit() ;}
      } 
      //study
      if ($field_selector->selector_study_fk>0)
      {
        if (!($result_Selector= $link->query(sprintf($del_selector_study_Stmt,$field_selector->selector_study_fk)))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($del_selector_study_Stmt,$field_selector->selector_study_fk) )) ;
        DisplayErrMsg(sprintf("error: %s", $link->error)) ;
        exit() ;}
      }
      //series
      if ($field_selector->selector_series_fk>0)
      {
        if (!($result_Selector= $link->query(sprintf($del_selector_series_Stmt,$field_selector->selector_series_fk)))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($del_selector_series_Stmt,$field_selector->selector_series_fk) )) ;
        DisplayErrMsg(sprintf("error: %s", $link->error)) ;
        exit() ;}
      }
      //instance
      if ($field_selector->selector_instance_fk>0)
      { 
        if (!($result_Selector= $link->query(sprintf($del_selector_instance_Stmt,$field_selector->selector_instance_fk)))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($del_selector_instance_Stmt,$field_selector->selector_instance_fk) )) ;
        DisplayErrMsg(sprintf("error: %s", $link->error)) ;
        exit() ;}
      }
    
      
      //$result_selector->close();


    }
    $i++;
  }

  $executestring.=sprintf("create_selector.php?t=%d",time());
  header($executestring);
  exit();
  } 




}



if(!empty($_POST['constraint'])) 
{
  $pk=$_GET['pk'];

  $selector_patient_fk=$_GET['selector_patient_fk'];
  $selector_study_fk=$_GET['selector_study_fk'];
  $selector_series_fk=$_GET['selector_series_fk'];
  $selector_instance_fk=$_GET['selector_instance_fk'];

  $constraint=$_POST['constraint'];
   
  $executestring.=sprintf("constraint.php?constraint=$constraint&selector_pk=$pk&selector_patient_fk=$selector_patient_fk&selector_study_fk=$selector_study_fk&selector_series_fk=$selector_series_fk&selector_instance_fk=$selector_instance_fk&pk=$pk&t=%d",time());

  header($executestring);
  exit();

}



//////////////////////////////////////////////////////////////////////////////////////////
// if it will get to here it is either:
// the first time
// or it returned from criteria_handling  (criteria defined)
///////////////////////////////////////////////////////////////////////////////////////////



$selector = new Smarty_NM();



if (!empty($_GET['selector'])) 
{
  printf("not empty selector");
  exit();
}
 
if (empty($_GET['selectorl']))  //first visit
{
  $selector_patient_fk=$_GET['selector_patient_fk'];
  $selector_study_fk=$_GET['selector_study_fk'];
  $selector_series_fk=$_GET['selector_series_fk'];
  $selector_instance_fk=$_GET['selector_instance_fk'];

  $pk=$_GET['pk'];
  
  

  if ($pk==0)  // new selector
  {
      // no default values sofar

     $selector->assign("analyselevel_options",$analyselevel_list);
     $selector->assign("category_options",$category_list);
     $selector->assign("qc_frequency_options",$qc_frequency_list);

  }   

  if ($pk>0)  //update selector
  {
    $table_selector='selector';
    $table_analysemodule='analysemodule';
    $table_analysemodule_cfg='analysemodule_cfg';
  
    $selector_Stmt = "SELECT * from $table_selector where $table_selector.pk='%d'";
    


    if (!($result_selector= $link->query(sprintf($selector_Stmt,$pk)))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($selector_Stmt,$pk) )) ;
       DisplayErrMsg(sprintf("error: %s", $link->error)) ;
       exit() ;
    }
    
    
    if (!($field_selector = $result_selector->fetch_object()))
    {
      DisplayErrMsg("Internal error: the entry does not not exist") ;
      exit() ;
    }
     
    
    $selector->assign("default_selector_name",$field_selector->name);
    $selector->assign("default_selector_description",$field_selector->description);
    
    $selector->assign("analyselevel_options",$analyselevel_list);
    $selector->assign("analyselevel_id",$field_selector->analyselevel);

    $selector->assign("category_options",$category_list);
    $selector->assign("category_id",$field_selector->selector_categorie_fk);

    $selector->assign("default_selector_modality",$field_selector->modaliteit);
    $selector->assign("default_selector_location",$field_selector->lokatie);

    $selector->assign("qc_frequency_options",$qc_frequency_list);
    $selector->assign("qc_frequency_id",$field_selector->qc_frequentie);

    $selector->assign("analysemodule_id",$field_selector->analysemodule_fk);
    $selector->assign("analysemodule_cfg_id",$field_selector->analysemodule_cfg_fk);


     
     $result_selector->close();
  }
} 


$table_pssi='';


$selector_buttons='';

if ($selector_patient_fk==0)
{ 
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Add_Patient');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
}
if ($selector_patient_fk>0)
{
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Modify_Patient');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Delete_Patient');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
}
if ($selector_study_fk==0)
{ 
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Add_Study');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
}
if ($selector_study_fk>0)
{
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Modify_Study');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Delete_Study');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
}
if ($selector_series_fk==0)
{ 
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Add_Series');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
}
if ($selector_series_fk>0)
{
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Modify_Series');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Delete_Series');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
  
}
if ($selector_instance_fk==0)
{ 
  $buttons = new Smarty_NM();
  $buttons->assign("patient_button",'Add_Instance');
  $selector_buttons.=$buttons->fetch("pssi_button.tpl");
}
if ($selector_instance_fk>0)
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
  $title = "Edit Selector";
  if ( ($selector_patient_fk>0)||($selector_study_fk>0)||($selector_series_fk>0)||($selector_instance_fk>0))  //get selector data
  {
     selector_function_pssi($pk,$selector_patient_fk,$selector_study_fk,$selector_series_fk,$selector_instance_fk,$table_pssi);
  }
  $selector->assign("submit_value","Update");
}








if ($pk!=0)
{
  $selector->assign("table_buttons",$table_selector_buttons);
  $selector->assign("table_pssi",$table_pssi);
}


 
$selector->assign("action_new_selector",sprintf("new_selector.php?pk=$pk&selector_patient_fk=$selector_patient_fk&selector_study_fk=$selector_study_fk&selector_series_fk=$selector_series_fk&selector_instance_fk=$selector_instance_fk&new_selector_ref=$new_selector_ref&t=%d",time()));


  //drop_down_data analysemodule

  
  $table_analysemodule='analysemodule';
  $analysemodule_Stmt = "SELECT * from $table_analysemodule order by $table_analysemodule.filename";

  
  if (!($result_analysemodule= $link->query($analysemodule_Stmt))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $analysemodule_Stmt)) ;
     DisplayErrMsg(sprintf("error: %s", $link->error)) ;
     exit() ;
  }
  $analysemodule_list["0"]=" ";  
  while($field_analysemodule = $result_analysemodule->fetch_object()) 
  {
    $analysemodule_name=sprintf("%s",$field_analysemodule->filename);
    $analysemodule_list[$field_analysemodule->pk]=sprintf("%s",$analysemodule_name);
  }
  $result_analysemodule->close();
  $selector->assign("analysemodule_options",$analysemodule_list);

  //drop_down_data analysemodule_cfg

  
  $table_analysemodule_cfg='analysemodule_cfg';
  $analysemodule_cfg_Stmt = "SELECT * from $table_analysemodule_cfg order by $table_analysemodule_cfg.filename";

  
  if (!($result_analysemodule_cfg= $link->query($analysemodule_cfg_Stmt))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $analysemodule_cfg_Stmt)) ;
     DisplayErrMsg(sprintf("error: %s", $link->error)) ;
     exit() ;
  }
  $analysemodule_cfg_list["0"]=" ";  
  while($field_analysemodule_cfg = $result_analysemodule_cfg->fetch_object()) 
  {
    $analysemodule_cfg_name=sprintf("%s",$field_analysemodule_cfg->filename);
    $analysemodule_cfg_list[$field_analysemodule_cfg->pk]=sprintf("%s",$analysemodule_cfg_name);
  }
  $result_analysemodule_cfg->close();
  $selector->assign("analysemodule_cfg_options",$analysemodule_cfg_list);
  $selector->assign("title",$title);
    
  $selector->display("new_selector.tpl");
    
?>












