<?php



function selector_function_pssi($pk,$selector_patient_pk,$selector_study_pk,$selector_series_pk,$selector_instance_pk,&$table_pssi)
{
    require("../globals.php") ;
    //require("./php/includes/setup.php");
    
    
    //Connect to the Database
    if (!($link=mysql_pconnect($hostName, $userName, $password))) {
       DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
       exit() ;
    }
  
    //Select the Database
    if (!mysql_select_db($databaseName, $link)) {
        DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
    }
    
    $patient_header="";
    $study_header="";
    $series_header="";
    $instance_header="";

   
    if ($selector_patient_pk>0)  //update patient
    { 
      $patient_header="Patient";

      $patient = new Smarty_NM();
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

      $table_patient=$patient->fetch("selector_patient.tpl");

      

    } 

    // end patient_ref



    if ($selector_study_pk>0)  //update study
    {
      $study_header="Study";      

            $study = new Smarty_NM();
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

      $table_study=$study->fetch("selector_study.tpl");
    } 

    // end study_ref
    if ($selector_series_pk>0)  //update series
    {
      $series_header="Series";      

      $series = new Smarty_NM();  
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

      $table_series=$series->fetch("selector_series.tpl");
    } 
    

    // end series_ref

    if ($selector_instance_pk>0)  //update instance
    {
      $instance_header="Instance";

      $instance = new Smarty_NM();
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

      $table_instance=$instance->fetch("selector_instance.tpl");
    } 

    // end instance_ref

    

    $selector_pssi = new Smarty_NM();
    $selector_pssi->assign("patient_header",$patient_header);
    $selector_pssi->assign("study_header",$study_header);
    $selector_pssi->assign("series_header",$series_header);
    $selector_pssi->assign("instance_header",$instance_header);
    $selector_pssi->assign("table_patient",$table_patient);
    $selector_pssi->assign("table_series",$table_series);
    $selector_pssi->assign("table_study",$table_study);
    $selector_pssi->assign("table_instance",$table_instance);

    $table_pssi=$selector_pssi->fetch("constraints_pssi.tpl");
   
}





?>