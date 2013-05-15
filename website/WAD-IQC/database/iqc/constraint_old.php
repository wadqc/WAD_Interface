<?php 

require("../globals.php") ;
require("./common.php") ;
//require("./drop_down_student.php") ;
//require("./add_parent_function.php") ;
require("./php/includes/setup.php");

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));

$constraint=$_GET['constraint'];

$selector_patient_pk=$_GET['selector_patient_pk'];
$selector_study_pk=$_GET['selector_study_pk'];
$selector_series_pk=$_GET['selector_series_pk'];
$selector_instance_pk=$_GET['selector_instance_pk'];

$pk=$_GET['pk'];  

// Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
     DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }


if( (!empty($_POST['action'])))
{
    
  //patient
  if ( ($constraint=='Add_Patient')||($constraint=='Modify_Patient') )
  {
    $pat_id=$_POST['pat_id'];
    $pat_id_issuer=$_POST['pat_id_issuer'];
    $pat_name=$_POST['pat_name'];
    $pat_fn_sx=$_POST['pat_fn_sx'];
    $pat_gn_sx=$_POST['pat_gn_sx'];
    $pat_i_name=$_POST['pat_i_name'];
    $pat_p_name=$_POST['pat_p_name'];
    $pat_birthdate=$_POST['pat_birthdate'];
    $pat_sex=$_POST['pat_sex'];
    $pat_custom1=$_POST['pat_custom1'];
    $pat_custom2=$_POST['pat_custom2'];
    $pat_custom3=$_POST['pat_custom3'];
    
    $table_patient="selector_patient";
    $addStmt = "Insert into $table_patient(selector_fk,pat_id,pat_id_issuer,pat_name,pat_fn_sx,pat_gn_sx,pat_i_name,pat_p_name,pat_birthdate,pat_sex,pat_custom1,pat_custom2,pat_custom3) values ('%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')";
    $updateStmt = "update $table_patient set selector_fk='%d',pat_id='%s',pat_id_issuer='%s',pat_name='%s',pat_fn_sx='%s',pat_gn_sx='%s',pat_i_name='%s',pat_p_name='%s',pat_birthdate='%s',pat_sex='%s',pat_custom1='%s',pat_custom2='%s',pat_custom3='%s' where pk='%s' ";
    
    

    if ($constraint=='Add_Patient')
    {
      $qStmt=sprintf($addStmt,$pk,$pat_id,$pat_id_issuer,$pat_name,$pat_fn_sx,$pat_gn_sx,$pat_i_name,$pat_p_name,$pat_birthdate,$pat_sex,$pat_custom1,$pat_custom2,$pat_custom3);
    }

    if ($constraint=='Modify_Patient')
    {
      $qStmt=sprintf($updateStmt,$pk,$pat_id,$pat_id_issuer,$pat_name,$pat_fn_sx,$pat_gn_sx,$pat_i_name,$pat_p_name,$pat_birthdate,$pat_sex,$pat_custom1,$pat_custom2,$pat_custom3,$selector_patient_pk);
    }

    

    if
    (!(mysql_query($qStmt,$link))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $qStmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
    if ($constraint=='Add_Patient')
    {
      $selector_patient_pk=mysql_insert_id();
    }
  }

  //Study
  if ( ($constraint=='Add_Study')||($constraint=='Modify_Study') )
  {
    

    $study_iuid=$_POST['study_iuid'];
    $study_id=$_POST['study_id'];
    $study_datetime=$_POST['study_datetime'];
    $accession_no=$_POST['accession_no'];
    $ref_physician=$_POST['ref_physician'];
    $ref_phys_fn_sx=$_POST['ref_phys_fn_sx'];
    $ref_phys_gn_sx=$_POST['ref_phys_gn_sx'];
    $ref_phys_i_name=$_POST['ref_phys_i_name'];
    $ref_phys_p_name=$_POST['ref_phys_p_name'];
    $study_desc=$_POST['study_desc'];
    $study_custom1=$_POST['study_custom1'];
    $study_custom2=$_POST['study_custom2'];
    $study_custom3=$_POST['study_custom3'];
    $study_status_id=$_POST['study_status_id'];
    $mods_in_study=$_POST['mods_in_study'];
    $cuids_in_study=$_POST['cuids_in_study'];
    $num_series=$_POST['num_series'];
    $num_instances=$_POST['num_instances'];
    $ext_retr_aet=$_POST['ext_retr_aet'];
    $retrieve_aets=$_POST['retrieve_aets'];
    $fileset_iuid=$_POST['fileset_iuid'];
    $fileset_id=$_POST['fileset_id'];
    $availability=$_POST['availability'];
    $study_status=$_POST['study_status'];
    $checked_time=$_POST['checked_time'];
    $updated_time=$_POST['updated_time'];
    $created_time=$_POST['created_time'];
    

    $table_study="selector_study";
    $addStmt = "Insert into $table_study(selector_fk,study_iuid,study_id,study_datetime,accession_no,ref_physician,ref_phys_fn_sx,ref_phys_gn_sx,ref_phys_i_name,ref_phys_p_name,study_desc,study_custom1,study_custom2,study_custom3,study_status_id,mods_in_study,cuids_in_study,num_series,num_instances,ext_retr_aet,retrieve_aets,fileset_iuid,fileset_id,availability,study_status,checked_time,updated_time,created_time) values ('%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')";
    $updateStmt = "update $table_study set selector_fk='%d',study_iuid='%s',study_id='%s',study_datetime='%s',accession_no='%s',ref_physician='%s',ref_phys_fn_sx='%s',ref_phys_gn_sx='%s',ref_phys_i_name='%s',ref_phys_p_name='%s',study_desc='%s',study_custom1='%s',study_custom2='%s',study_custom3='%s',study_status_id='%s',mods_in_study='%s',cuids_in_study='%s',num_series='%s',num_instances='%s',ext_retr_aet='%s',retrieve_aets='%s',fileset_iuid='%s',fileset_id='%s',availability='%s',study_status='%s',checked_time='%s',updated_time='%s',created_time='%s' where pk='%s' ";
    
    

    if ($constraint=='Add_Study')
    {
      $qStmt=sprintf($addStmt,$pk,$study_iuid,$study_id,$study_datetime,$accession_no,$ref_physician,$ref_phys_fn_sx,$ref_phys_gn_sx,$ref_phys_i_name,$ref_phys_p_name,$study_desc,$study_custom1,$study_custom2,$study_custom3,$study_status_id,$mods_in_study,$cuids_in_study,$num_series,$num_instances,$ext_retr_aet,$retrieve_aets,$fileset_iuid,$fileset_id,$availability,$study_status,$checked_time,$updated_time,$created_time);
    }

    if ($constraint=='Modify_Study')
    {
      $qStmt=sprintf($updateStmt,$pk,$study_iuid,$study_id,$study_datetime,$accession_no,$ref_physician,$ref_phys_fn_sx,$ref_phys_gn_sx,$ref_phys_i_name,$ref_phys_p_name,$study_desc,$study_custom1,$study_custom2,$study_custom3,$study_status_id,$mods_in_study,$cuids_in_study,$num_series,$num_instances,$ext_retr_aet,$retrieve_aets,$fileset_iuid,$fileset_id,$availability,$study_status,$checked_time,$updated_time,$created_time,$selector_study_pk);
    }

    

    if
    (!(mysql_query($qStmt,$link))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $qStmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
    if ($constraint=='Add_Study')
    {
      
      $selector_study_pk=mysql_insert_id();
    }
  }


  //series
  if ( ($constraint=='Add_Series')||($constraint=='Modify_Series') )
  {
    $series_iuid=$_POST['series_iuid']; 			
    $series_no=$_POST['series_no']; 			
    $modality=$_POST['modality']; 			
    $body_part=$_POST['body_part']; 			
    $laterality=$_POST['laterality']; 			
    $series_desc=$_POST['series_desc']; 			
    $institution=$_POST['institution']; 			
    $station_name=$_POST['station_name']; 			
    $department=$_POST['department']; 			
    $perf_physician=$_POST['perf_physician']; 			
    $perf_phys_fn_sx=$_POST['perf_phys_fn_sx']; 			
    $perf_phys_gn_sx=$_POST['perf_phys_gn_sx']; 			
    $perf_phys_i_name=$_POST['perf_phys_i_name']; 			
    $perf_phys_p_name=$_POST['perf_phys_p_name']; 			
    $pps_start=$_POST['pps_start'];
    $pps_iuid=$_POST['pps_iuid']; 			
    $series_custom1=$_POST['series_custom1']; 			
    $series_custom2=$_POST['series_custom2']; 			
    $series_custom3=$_POST['series_custom3']; 			
    $num_instances=$_POST['num_instances']; 			
    $src_aet=$_POST['src_aet']; 			
    $ext_retr_aet=$_POST['ext_retr_aet']; 			
    $retrieve_aets=$_POST['retrieve_aets']; 			
    $fileset_iuid=$_POST['fileset_iuid']; 			
    $fileset_id=$_POST['fileset_id']; 			
    $availability=$_POST['availability']; 			
    $series_status=$_POST['series_status']; 			
    $created_time=$_POST['created_time'];
    $updated_time=$_POST['updated_time'];
    $series_attrs=$_POST['series_attrs'];   
   
    
    $table_series="selector_series";
    $addStmt = "Insert into $table_series(selector_fk,series_iuid,series_no,modality,body_part,laterality,series_desc,institution,station_name,department,perf_physician,perf_phys_fn_sx,perf_phys_gn_sx,perf_phys_i_name,perf_phys_p_name,pps_start,pps_iuid,series_custom1,series_custom2,series_custom3,num_instances,src_aet,ext_retr_aet,retrieve_aets,fileset_iuid,fileset_id,availability,series_status,created_time,updated_time,series_attrs) values ('%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')";
    $updateStmt = "update $table_series set selector_fk='%d',series_iuid='%s',series_no='%s',modality='%s',body_part='%s',laterality='%s',series_desc='%s',institution='%s',station_name='%s',department='%s',perf_physician='%s',perf_phys_fn_sx='%s',perf_phys_gn_sx='%s',perf_phys_i_name='%s',perf_phys_p_name='%s',pps_start='%s',pps_iuid='%s',series_custom1='%s',series_custom2='%s',series_custom3='%s',num_instances='%s',src_aet='%s',ext_retr_aet='%s',retrieve_aets='%s',fileset_iuid='%s',fileset_id='%s',availability='%s',series_status='%s',created_time='%s',updated_time='%s',series_attrs='%s' where pk='%s' ";
    
    
    
    

    if ($constraint=='Add_Series')
    {
      $qStmt=sprintf($addStmt,$pk,$series_iuid,$series_no,$modality,$body_part,$laterality,$series_desc,$institution,$station_name,$department,$perf_physician,$perf_phys_fn_sx,$perf_phys_gn_sx,$perf_phys_i_name,$perf_phys_p_name,$pps_start,$pps_iuid,$series_custom1,$series_custom2,$series_custom3,$num_instances,$src_aet,$ext_retr_aet,$retrieve_aets,$fileset_iuid,$fileset_id,$availability,$series_status,$created_time,$updated_time,$series_attrs);
    }

    if ($constraint=='Modify_Series')
    {
      $qStmt=sprintf($updateStmt,$pk,$series_iuid,$series_no,$modality,$body_part,$laterality,$series_desc,$institution,$station_name,$department,$perf_physician,$perf_phys_fn_sx,$perf_phys_gn_sx,$perf_phys_i_name,$perf_phys_p_name,$pps_start,$pps_iuid,$series_custom1,$series_custom2,$series_custom3,$num_instances,$src_aet,$ext_retr_aet,$retrieve_aets,$fileset_iuid,$fileset_id,$availability,$series_status,$created_time,$updated_time,$series_attrs,$selector_series_pk);
    }

    

    if
    (!(mysql_query($qStmt,$link))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $qStmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
    if ($constraint=='Add_Series')
    {
      $selector_series_pk=mysql_insert_id();
    }
  }


 //Instance
  if ( ($constraint=='Add_Instance')||($constraint=='Modify_Instance') )
  {
    $sop_iuid=$_POST['sop_iuid']; 			
    $sop_cuid=$_POST['sop_cuid']; 			
    $inst_no=$_POST['inst_no']; 			
    $content_datetime=$_POST['content_datetime'];
    $sr_complete=$_POST['sr_complete']; 			
    $sr_verified=$_POST['sr_verified']; 			
    $inst_custom1=$_POST['inst_custom1']; 			
    $inst_custom2=$_POST['inst_custom2']; 			
    $inst_custom3=$_POST['inst_custom3'];			
    $ext_retr_aet=$_POST['ext_retr_aet']; 			
    $retrieve_aets=$_POST['retrieve_aets']; 			
    $availability=$_POST['availability']; 			
    $inst_status=$_POST['inst_status']; 			
    $all_attrs=$_POST['all_attrs']; 			
    $commitment=$_POST['commitment']; 			
    $archived=$_POST['archived']; 			
    $updated_time=$_POST['updated_time'];
    $created_time=$_POST['created_time'];
    $inst_attrs=$_POST['inst_attrs'];  
   
    
    $table_instance="selector_instance";
    $addStmt = "Insert into $table_instance(selector_fk,sop_iuid,sop_cuid,inst_no,content_datetime,sr_complete,sr_verified,inst_custom1,inst_custom2,inst_custom3,ext_retr_aet,retrieve_aets,availability,inst_status,all_attrs,commitment,archived,updated_time,created_time,inst_attrs) values ('%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')";
    $updateStmt = "update $table_instance set selector_fk='%d',sop_iuid='%s',sop_cuid='%s',inst_no='%s',content_datetime='%s',sr_complete='%s',sr_verified='%s',inst_custom1='%s',inst_custom2='%s',inst_custom3='%s',ext_retr_aet='%s',retrieve_aets='%s',availability='%s',inst_status='%s',all_attrs='%s',commitment='%s',archived='%s',updated_time='%s',created_time='%s',inst_attrs='%s' where pk='%s' ";
   

    if ($constraint=='Add_Instance')
    {
      $qStmt=sprintf($addStmt,$pk,$sop_iuid,$sop_cuid,$inst_no,$content_datetime,$sr_complete,$sr_verified,$inst_custom1,$inst_custom2,$inst_custom3,$ext_retr_aet,$retrieve_aets,$availability,$inst_status,$all_attrs,$commitment,$archived,$updated_time,$created_time,$inst_attrs);
    }

    if ($constraint=='Modify_Instance')
    {
      $qStmt=sprintf($updateStmt,$pk,$sop_iuid,$sop_cuid,$inst_no,$content_datetime,$sr_complete,$sr_verified,$inst_custom1,$inst_custom2,$inst_custom3,$ext_retr_aet,$retrieve_aets,$availability,$inst_status,$all_attrs,$commitment,$archived,$updated_time,$created_time,$inst_attrs,$selector_instance_pk);
    }

    
    if
    (!(mysql_query($qStmt,$link))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $qStmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
    if ($constraint=='Add_Instance')
    {
      $selector_instance_pk=mysql_insert_id();
    }
  }
  
  

  $executestring.=sprintf("new_selector.php?pk=$pk&selector_patient_pk=$selector_patient_pk&selector_study_pk=$selector_study_pk&selector_series_pk=$selector_series_pk&selector_instance_pk=$selector_instance_pk&new_selector_ref=$new_selector_ref&t=%d",time() );

  //printf("new_selector.php?pk=$pk&selector_patient_pk=$selector_patient_pk&selector_study_pk=$selector_study_pk&selector_series_pk=$selector_series_pk&selector_instance_pk=$selector_instance_pk&new_selector_ref=$new_selector_ref&t=%d",time() );
  //exit();
  

  header($executestring);
  exit();
  

}


//////////////////////////////////////////////////////////////////////////////////////////
// if it will get to here it is either the first time or it returned from add/modify picture
///////////////////////////////////////////////////////////////////////////////////////////


if ( ($constraint=='Delete_Patient')||($constraint=='Delete_Study')||($constraint=='Delete_Series')||($constraint=='Delete_Instance') )
{
   if ($constraint=='Delete_Patient')
   {
     $table_delete="selector_patient";
     $del_Stmt = "delete from  $table_delete where $table_delete.pk='%d'";
     $del_Stmt = sprintf($del_Stmt,$selector_patient_pk);
     $selector_patient_pk=0;
   }
   if ($constraint=='Delete_Study')
   {
     $table_delete="selector_study";
     $del_Stmt = "delete from  $table_delete where $table_delete.pk='%d'";
     $del_Stmt = sprintf($del_Stmt,$selector_study_pk);
     $selector_study_pk=0;
   }
   if ($constraint=='Delete_Series')
   {
     $table_delete="selector_series";
     $del_Stmt = "delete from  $table_delete where $table_delete.pk='%d'";
     $del_Stmt = sprintf($del_Stmt,$selector_series_pk);
     $selector_series_pk=0;
   }
   if ($constraint=='Delete_Instance')
   {
     $table_delete="selector_instance";
     $del_Stmt = "delete from  $table_delete where $table_delete.pk='%d'";
     $del_Stmt = sprintf($del_Stmt,$selector_instance_pk);
     $selector_instance_pk=0;
   }
   

   
    if (!($result_analysemodule= mysql_query($del_Stmt,$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}

    $executestring.=sprintf("new_selector.php?pk=$pk&selector_patient_pk=$selector_patient_pk&selector_study_pk=$selector_study_pk&selector_series_pk=$selector_series_pk&selector_instance_pk=$selector_instance_pk&new_selector_ref=$new_selector_ref&t=%d",time() );

    header($executestring);
    exit();

}





$constraint_pssi=new Smarty_NM();


if ( ($constraint=='Add_Patient')||($constraint=='Modify_Patient') )
{
 

  $patient = new Smarty_NM();
  
  if ($selector_patient_pk<=0)  //new patient
  {
    $table_patient=$patient->fetch("constraint_patient.tpl");
  }

  if ($selector_patient_pk>0)  //update patient
  {
    $table_patient='selector_patient';
  
    $patient_Stmt = "SELECT * from $table_patient where
    $table_patient.pk='$selector_patient_pk'";

   
    if (!($result_patient= mysql_query($patient_Stmt,$link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $student_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
    }

    if (!($field_patient = mysql_fetch_object($result_patient)))
    {
       DisplayErrMsg("Internal error: the entry does not exist") ;
       exit() ;
    }
  
    //personal_patient
    $table_patient='';
    $patient->assign("default_pat_id",$field_patient->pat_id);
    $patient->assign("default_pat_id_issuer",$field_patient->pat_id_issuer);
    $patient->assign("default_pat_name",$field_patient->pat_name);
    $patient->assign("default_pat_fn_sx",$field_patient->pat_fn_sx);
    $patient->assign("default_pat_gn_sx",$field_patient->pat_gn_sx);
    $patient->assign("default_pat_i_name",$field_patient->pat_i_name);
    $patient->assign("default_pat_p_name",$field_patient->pat_p_name);
    $patient->assign("default_pat_birthdate",$field_patient->pat_birthdate);
    $patient->assign("default_pat_sex",$field_patient->pat_sex);
    $patient->assign("default_pat_custom1",$field_patient->pat_custom1);
    $patient->assign("default_pat_custom2",$field_patient->pat_custom2);
    $patient->assign("default_pat_custom3",$field_patient->pat_custom3);
    mysql_free_result($result_patient);

    $table_patient=$patient->fetch("constraint_patient.tpl");
  } 
  if ($selector_patient_pk<=0)
  {
    $constraint_pssi->assign("submit_value","Add_Patient");
  }
  if ($selector_patient_pk>0)
  {
    $constraint_pssi->assign("submit_value","Modify_Patient");
  }
  $constraint_pssi->assign("table_patient",$table_patient);
  $constraint_pssi->assign("header",sprintf("%s",$constraint)); 
  
   
  //$constraint_pssi->display("constraint_patient.tpl");
  //exit();

} 



if ( ($constraint=='Add_Study')||($constraint=='Modify_Study') )
{
 

  $study = new Smarty_NM();
  
  if ($selector_study_pk<=0)  //new study
  {
    $table_study=$study->fetch("constraint_study.tpl");
  }

  if ($selector_study_pk>0)  //update study
  {
    $table_study='selector_study';
  
    $study_Stmt = "SELECT * from $table_study where
    $table_study.pk='$selector_study_pk'";

   
    if (!($result_study= mysql_query($study_Stmt,$link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $student_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
    }

    if (!($field_study = mysql_fetch_object($result_study)))
    {
       DisplayErrMsg("Internal error: the entry does not exist") ;
       exit() ;
    }
  
    //personal_study
    $table_study='';
    $study->assign("default_series_iuid",$field_study->series_iuid); 			
    $study->assign("default_series_no",$field_study->series_no); 			
    $study->assign("default_modality",$field_study->modality); 			
    $study->assign("default_body_part",$field_study->body_part); 			
    $study->assign("default_laterality",$field_study->laterality); 			
    $study->assign("default_series_desc",$field_study->series_desc); 			
    $study->assign("default_institution",$field_study->institution); 			
    $study->assign("default_station_name",$field_study->station_name); 			
    $study->assign("default_department",$field_study->department); 			
    $study->assign("default_perf_physician",$field_study->perf_physician); 			
    $study->assign("default_perf_phys_fn_sx",$field_study->perf_phys_fn_sx); 			
    $study->assign("default_perf_phys_gn_sx",$field_study->perf_phys_gn_sx); 			
    $study->assign("default_perf_phys_i_name",$field_study->perf_phys_i_name); 			
    $study->assign("default_perf_phys_p_name",$field_study->perf_phys_p_name); 			
    $study->assign("default_pps_start",$field_study->pps_start);
    $study->assign("default_pps_iuid",$field_study->pps_iuid); 			
    $study->assign("default_series_custom1",$field_study->series_custom1); 			
    $study->assign("default_series_custom2",$field_study->series_custom2); 			
    $study->assign("default_series_custom3",$field_study->series_custom3); 			
    $study->assign("default_num_instances",$field_study->num_instances); 			
    $study->assign("default_src_aet",$field_study->src_aet); 			
    $study->assign("default_ext_retr_aet",$field_study->ext_retr_aet); 			
    $study->assign("default_retrieve_aets",$field_study->retrieve_aets); 			
    $study->assign("default_fileset_iuid",$field_study->fileset_iuid); 			
    $study->assign("default_fileset_id",$field_study->fileset_id); 			
    $study->assign("default_availability",$field_study->availability); 			
    $study->assign("default_series_status",$field_study->series_status); 			
    $study->assign("default_created_time",$field_study->created_time);
    $study->assign("default_updated_time",$field_study->updated_time);
    $study->assign("default_series_attrs",$field_study->series_attrs);     

    mysql_free_result($result_study);

    $table_study=$study->fetch("constraint_study.tpl");
  } 
  if ($selector_study_pk<=0)
  {
    $constraint_pssi->assign("submit_value","Add_Study");
  }
  if ($selector_study_pk>0)
  {
    $constraint_pssi->assign("submit_value","Modify_Study");
  }
  $constraint_pssi->assign("table_study",$table_study);
  $constraint_pssi->assign("header",sprintf("%s",$constraint)); 
  
   
  //$constraint_pssi->display("constraint_study.tpl");
  //exit();
} 


//series
if ( ($constraint=='Add_Series')||($constraint=='Modify_Series') )
{
 $series = new Smarty_NM();
  
  if ($selector_series_pk<=0)  //new series
  {
    $table_series=$series->fetch("constraint_series.tpl");
  }

  if ($selector_series_pk>0)  //update series
  {
    $table_series='selector_series';
  
    $series_Stmt = "SELECT * from $table_series where
    $table_series.pk='$selector_series_pk'";

   
    if (!($result_series= mysql_query($series_Stmt,$link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $student_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
    }

    if (!($field_series = mysql_fetch_object($result_series)))
    {
       DisplayErrMsg("Internal error: the entry does not exist") ;
       exit() ;
    }
  
    //personal_series
    $table_series='';
    $series->assign("default_series_iuid",$field_series->series_iuid); 			
    $series->assign("default_series_no",$field_series->series_no); 			
    $series->assign("default_modality",$field_series->modality); 			
    $series->assign("default_body_part",$field_series->body_part); 			
    $series->assign("default_laterality",$field_series->laterality); 			
    $series->assign("default_series_desc",$field_series->series_desc); 			
    $series->assign("default_institution",$field_series->institution); 			
    $series->assign("default_station_name",$field_series->station_name); 			
    $series->assign("default_department",$field_series->department); 			
    $series->assign("default_perf_physician",$field_series->perf_physician); 			
    $series->assign("default_perf_phys_fn_sx",$field_series->perf_phys_fn_sx); 			
    $series->assign("default_perf_phys_gn_sx",$field_series->perf_phys_gn_sx); 			
    $series->assign("default_perf_phys_i_name",$field_series->perf_phys_i_name); 			
    $series->assign("default_perf_phys_p_name",$field_series->perf_phys_p_name); 			
    $series->assign("default_pps_start",$field_series->pps_start);
    $series->assign("default_pps_iuid",$field_series->pps_iuid); 			
    $series->assign("default_series_custom1",$field_series->series_custom1); 			
    $series->assign("default_series_custom2",$field_series->series_custom2); 			
    $series->assign("default_series_custom3",$field_series->series_custom3); 			
    $series->assign("default_num_instances",$field_series->num_instances); 			
    $series->assign("default_src_aet",$field_series->src_aet); 			
    $series->assign("default_ext_retr_aet",$field_series->ext_retr_aet); 			
    $series->assign("default_retrieve_aets",$field_series->retrieve_aets); 			
    $series->assign("default_fileset_iuid",$field_series->fileset_iuid); 			
    $series->assign("default_fileset_id",$field_series->fileset_id); 			
    $series->assign("default_availability",$field_series->availability); 			
    $series->assign("default_series_status",$field_series->series_status); 			
    $series->assign("default_created_time",$field_series->created_time);
    $series->assign("default_updated_time",$field_series->updated_time);
    $series->assign("default_series_attrs",$field_series->series_attrs);   

    mysql_free_result($result_series);

    $table_series=$series->fetch("constraint_series.tpl");
  } 
  if ($selector_series_pk<=0)
  {
    $constraint_pssi->assign("submit_value","Add_series");
  }
  if ($selector_series_pk>0)
  {
    $constraint_pssi->assign("submit_value","Modify_series");
  }
  $constraint_pssi->assign("table_series",$table_series);
  $constraint_pssi->assign("header",sprintf("%s",$constraint)); 
  
   
  //$constraint_pssi->display("constraint_series.tpl");
  //exit();
} 

//Instance

if ( ($constraint=='Add_Instance')||($constraint=='Modify_Instance') )
{
 $instance = new Smarty_NM();
  
  if ($selector_instance_pk<=0)  //new instance
  {
    $table_instance=$instance->fetch("constraint_instance.tpl");
  }

  if ($selector_instance_pk>0)  //update instance
  {
    $table_instance='selector_instance';
  
    $instance_Stmt = "SELECT * from $table_instance where
    $table_instance.pk='$selector_instance_pk'";

   
    if (!($result_instance= mysql_query($instance_Stmt,$link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $student_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
    }

    if (!($field_instance = mysql_fetch_object($result_instance)))
    {
       DisplayErrMsg("Internal error: the entry does not exist") ;
       exit() ;
    }
  
    //personal_instance
    $table_instance='';
    $instance->assign("default_sop_iuid",$field_instance->sop_iuid); 			
    $instance->assign("default_sop_cuid",$field_instance->sop_cuid); 			
    $instance->assign("default_inst_no",$field_instance->inst_no); 			
    $instance->assign("default_content_datetime",$field_instance->content_datetime);
    $instance->assign("default_sr_complete",$field_instance->sr_complete); 			
    $instance->assign("default_sr_verified",$field_instance->sr_verified); 			
    $instance->assign("default_inst_custom1",$field_instance->inst_custom1); 			
    $instance->assign("default_inst_custom2",$field_instance->inst_custom2); 			
    $instance->assign("default_inst_custom3",$field_instance->inst_custom3);			
    $instance->assign("default_ext_retr_aet",$field_instance->ext_retr_aet); 			
    $instance->assign("default_retrieve_aets",$field_instance->retrieve_aets); 			
    $instance->assign("default_availability",$field_instance->availability); 			
    $instance->assign("default_inst_status",$field_instance->inst_status); 			
    $instance->assign("default_all_attrs",$field_instance->all_attrs); 			
    $instance->assign("default_commitment",$field_instance->commitment); 			
    $instance->assign("default_archived",$field_instance->archived); 			
    $instance->assign("default_updated_time",$field_instance->updated_time);
    $instance->assign("default_created_time",$field_instance->created_time);
    $instance->assign("default_inst_attrs",$field_instance->inst_attrs);  

    mysql_free_result($result_instance);

    $table_instance=$instance->fetch("constraint_instance.tpl");
  } 
  if ($selector_instance_pk<=0)
  {
    $constraint_pssi->assign("submit_value","Add_instance");
  }
  if ($selector_instance_pk>0)
  {
    $constraint_pssi->assign("submit_value","Modify_instance");
  }
  $constraint_pssi->assign("table_instance",$table_instance);
  $constraint_pssi->assign("header",sprintf("%s",$constraint)); 
  
   
  //$constraint_pssi->display("constraint_instance.tpl");
  //exit();
} 




$start_self = sprintf("http://%s",$_SERVER['HTTP_HOST']);

$start_self = sprintf("http://%s",$_SERVER['HTTP_HOST']);
$constraint_pssi->assign("action_constraint",sprintf("constraint.php?constraint=$constraint&selector_patient_pk=$selector_patient_pk&selector_study_pk=$selector_study_pk&selector_series_pk=$selector_series_pk&selector_instance_pk=$selector_instance_pk&pk=$pk&t=%d",time()) );

 
$constraint_pssi->display("constraint.tpl");
  
?>












