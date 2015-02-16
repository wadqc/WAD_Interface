<?php 

require("../globals.php") ;
require("./common.php") ;
require("./selector_function.php") ;

require("./php/includes/setup.php");

require_once "Mail.php";



$table_study='study';
$table_series='series';
$table_instance='instance';



$table_resultaten_floating='resultaten_floating';
$table_resultaten_char='resultaten_char';
$table_resultaten_boolean='resultaten_boolean';
$table_resultaten_object='resultaten_object';
$table_gewenste_processen='gewenste_processen';
$table_selector='selector';
$table_resultaten_status='resultaten_status';


$table_users='users';









  //Selector
  if (!empty($_GET['selector_fk']))
  {
    $selector_fk=$_GET['selector_fk'];
  }
  if (!empty($_GET['analyse_level']))
  {
    $analyse_level=$_GET['analyse_level'];
  }
  if (!empty($_GET['gewenste_processen_id']))
  {
    $gewenste_processen_id=$_GET['gewenste_processen_id'];
  }
  if (!empty($_POST['gewenste_processen_id']))
  {
    $gewenste_processen_id=$_POST['gewenste_processen_id'];
  }
  if (!empty($_GET['v']))
  {
    $v=$_GET['v'];
  }
  
  if (!empty($_POST['action_result']))
  {
    $action_result=$_POST['action_result'];
  }
  if (!empty($_GET['action_result']))
  {
    $action_result=$_GET['action_result'];
  }

  if (!empty($_POST['initialen']))
  {
    $initialen=$_POST['initialen'];
  }
  if (!empty($_POST['status']))
  {
    $status=$_POST['status'];
  }
  if (!empty($_GET['status']))
  {
    $status=$_GET['status'];
  }




$year_Stmt_study="SELECT $table_gewenste_processen.pk as 'pk', $table_study.study_datetime as 'date_time' from $table_gewenste_processen inner join $table_study on $table_gewenste_processen.study_fk=$table_study.pk where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%d'";

$year_Stmt_series="SELECT $table_gewenste_processen.pk as 'pk', $table_series.pps_start as 'date_time' from $table_gewenste_processen inner join $table_series on $table_gewenste_processen.series_fk=$table_series.pk where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%d'";

$year_Stmt_instance="SELECT $table_gewenste_processen.pk as 'pk', $table_instance.content_datetime as 'date_time' from $table_gewenste_processen inner join $table_instance on $table_gewenste_processen.study_fk=$table_instance.pk where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%d'";

$selector_Stmt="SELECT * from $table_selector
where $table_selector.pk=$selector_fk"; 

//$gewenste_processen_Stmt="SELECT * from $table_gewenste_processen 
//where $table_gewenste_proecessen.pk=$selector_fk";

$update_Stmt="update $table_gewenste_processen set status='%d' where $table_gewenste_processen.pk='%d'";

$update_resultaten_status_Stmt="update $table_resultaten_status set $table_resultaten_status.gebruiker='%s',$table_resultaten_status.omschrijving='%s',$table_resultaten_status.initialen='%s' where $table_resultaten_status.pk='%d'";

$add_Stmt = "Insert into $table_resultaten_status(gewenste_processen_fk,gebruiker,omschrijving,initialen) 
values ('%d','%s','%s','%s')";

$select_recover_Stmt= "select * from $table_resultaten_status where $table_resultaten_status.gewenste_processen_fk='%d'";

$delete_recover_Stmt = "delete from  $table_resultaten_status where $table_resultaten_status.gewenste_processen_fk='%d'";


$users_Stmt = "SELECT * from $table_users where 
$table_users.login='$user'";



// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


  if ($analyse_level=='study')
  {
    if (!($result_year= $link->query(sprintf($year_Stmt_study,$gewenste_processen_id)))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
    }
  }
  if ($analyse_level=='series')
  {
    if (!($result_year= $link->query(sprintf($year_Stmt_series,$gewenste_processen_id)))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
    }
  } 
  if ($analyse_level=='instance')
  {
    if (!($result_year= $link->query(sprintf($year_Stmt_instance,$gewenste_processen_id)))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
    }
  }
  $field = $result_year->fetch_object();
  $date_result=$field->date_time;
  $result_year->close();


switch ($action_result):
    
case Delete:
  {




  
  //description
  $delete_description='';
  if (!empty($_POST['delete_description']))
  {
    $delete_description=$_POST['delete_description'];
  }

  if ($delete_description=='')
  {

    if (!($result_selector= $link->query($selector_Stmt))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt)) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
    }


    $field_results = $result_selector->fetch_object();
    $header_delete_result=sprintf("Verwijderen resultaat van Selector: %s, analyse level: %s datum: %s",$field_results->name,$field_results->analyselevel,$date_result);
    $result_selector->close();  

    $data= new Smarty_NM();
    $data->assign("header_delete_result",$header_delete_result);
    $data->assign("action_delete_results",sprintf("validate_results.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=%d&status=%d&action_result=%s&v=%d&t=%d",$selector_fk,$analyse_level,$gewenste_processen_id,$status,$action_result,$v,time()) );
    $data->assign("submit_value","Delete");
    $data->display("delete_results.tpl");
    exit();
  }
 
  if ($delete_description!='')
  {

        
    $resultaten_status_id=-1;
    if (!($result_select= $link->query(sprintf($select_recover_Stmt,$gewenste_processen_id)))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($select_recover_Stmt,$gewenste_processen_id) )) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
    }
  
    if ($field_results = $result_select->fetch_object() )
    {
      $resultaten_status_id=$field_results->pk;
    }
   
    $result_select->close();  

    
    $status=20;
    
    //update 
    if (!$link->query(sprintf($update_Stmt,$status,$gewenste_processen_id))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $update_Stmt)) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
    }



    if ($resultaten_status_id==-1) //no row available, add a new one
    {
      $initialen='';
      if(!$link->query(sprintf($add_Stmt,$gewenste_processen_id,$user,$delete_description,$initialen))) 
      {
        DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($add_Stmt,$gewenste_processen_id,$user,$delete_description,$initialen)  )) ;
        DisplayErrMsg(sprintf("error: %s", $link->error)) ;
        exit() ;
      } 
    }
    if ($resultaten_status_id!=-1) //row available, update row
    {
      if (!$link->query(sprintf($update_resultaten_status_Stmt,$user,$delete_description,$initialen,$resultaten_status_id))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($update_resultaten_status_Stmt,$user,$delete_description,$initialen,$resultaten_status_id) )) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
      }
    }
    $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));

    $executestring.= sprintf("show_results.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=-1&status=%s&v=%d&t=%d",$selector_fk,$analyse_level,$status,$v,time());
    header($executestring);
    exit();

  }   

}// end case delete

case Herstel:
  {

  
 
  $status=5;
  
  //update 
  if (!$link->query(sprintf($update_Stmt,$status,$gewenste_processen_id))) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($update_Stmt,$status,$gewenste_processen_id)  )) ;
  DisplayErrMsg(sprintf("error: %s", $link->error)) ;
  exit() ;
  }

  //delete
  if(!$link->query(sprintf($delete_recover_Stmt,$gewenste_processen_id))) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($delete_recover_Stmt,$gewenste_processen_id) )) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
  } 

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= sprintf("show_results.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=-1&status=%s&v=%d&t=%d",$selector_fk,$analyse_level,$status,$v,time());
  header($executestring);
  exit();

} // end case herstel

case Valideer:
{
   
  if ($initialen!='')
  {  
 
    $status=30;
    //update 
    if (!$link->query(sprintf($update_Stmt,$status,$gewenste_processen_id))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $update_Stmt)) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
    }
    //add
  
    if(!$link->query(sprintf($add_Stmt,$gewenste_processen_id,$user,$delete_description,$initialen))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt",sprintf($add_Stmt,$gewenste_processen_id,$user,$delete_description,$initialen)  )) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
    } 

    if (!empty($user_level_3)) //vendor
    {
      if (!($result_users= $link->query(sprintf($users_Stmt)))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $users_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
      }
      $field_users = $result_users->fetch_object();
 
      $to=$field_users->email;
      $vendor_name=$field_users->lastname;
  
      $result_users->close(); 

      //////////////////////
      if (!($result_selector= $link->query($selector_Stmt))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt )) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
      }
      $field_selector = $result_selector->fetch_object();
 
      $selector_name=$field_selector->name;
  
      $result_selector->close(); 
      
      
      $from = "Anne Talsma <talsma.anne@gekooooomail.com>";
      $subject = sprintf("QC klinische vrijgave %s",$selector_name);
      
      $body = sprintf("Toestel %s ,QC datum: %s, is klinisch vrijgegeven door leverancier: %s met initialen: %s",$selector_name, $date_result,$vendor_name,$initialen);
      
      


      $headers = array ('From' => $from,
      'To' => $to,
      'Subject' => $subject);
      $smtp = Mail::factory('smtp',
      array ('host' => $mail_host,
      'port' => $mail_port,
      'auth' => $mail_auth,
      'username' => $mail_username,
      'password' => $mail_password));

      $mail = $smtp->send($to, $headers, $body);
       
      //if (PEAR::isError($mail)) {
      //echo("<p>" . $mail->getMessage() . "</p>");
      //} else {
      //echo("<p>Message successfully sent!</p>");
      //}

      


    }

    

   

  }
    $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
    $executestring.= sprintf("show_results.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=%d&status=%d&v=%d&t=%d",$selector_fk,$analyse_level,$gewenste_processen_id,$status,$v,time());
    header($executestring);
    exit();

}   


endswitch;


?>