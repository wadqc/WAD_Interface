<?php 

require("../globals.php") ;
require("./common.php") ;
require("../iqc_data.php") ;
require("./php/includes/setup.php");

$users_pk=$_GET['users_pk'];


$message_lastname='';
$message_login='';
$message_level='';


if( (!empty($_GET['message_lastname']) ) )
{
  $message_lastname=$_GET['message_lastname'];
}
if( (!empty($_GET['message_login']) ) )
{
  $message_login=$_GET['message_login'];
}
if( (!empty($_GET['message_level']) ) )
{
  $message_level=$_GET['message_level'];
}



$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));

// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



if( (!empty($_POST['action']) ) )
{
  //$users_pk=$_GET['users_pk'];

  //Personal
  $message1='';
  $amount=0;
  $users_firstname=$_POST['users_firstname'];
  $users_lastname=$_POST['users_lastname'];
  if (empty($users_lastname))
  {
    $amount++;
  }
  if ($amount>0)
  {
    $message1=sprintf("Achternaam is een verplicht veld");
  }
  $users_initials=$_POST['users_initials'];
  $users_phone=$_POST['users_phone'];
  $users_email=$_POST['users_email'];
  
  //priveleges
  $message2=''; 
  $amount=0;
  $users_login=$_POST['users_login'];
  if (empty($users_lastname))
  {
    $amount++;
  }
  if ($amount>0)
  {
    $message2=sprintf("Login is een verplicht veld");
  }
  $message3='';
  $amount=0;
  $login_level_1='';
  $login_level_2='';
  $login_level_3='';
  $login_level_4='';
  $login_level_5='';
  if (!empty($_POST['login_level_1']))
  {
     $login_level_1=$_POST['login_level_1'];
     $amount++;
  }
  if (!empty($_POST['login_level_2']))
  {
     $login_level_2=$_POST['login_level_2'];
     $amount++;
  }
  if (!empty($_POST['login_level_3']))
  {
     $login_level_3=$_POST['login_level_3'];
     $amount++;
  }
  if (!empty($_POST['login_level_4']))
  {
     $login_level_4=$_POST['login_level_4'];
     $amount++;
  }
  if (!empty($_POST['login_level_5']))
  {
     $login_level_5=$_POST['login_level_5'];
     $amount++;
  }
  

  if ($amount<1)
  {
    $message3=sprintf("Geen user level geselecteerd");
  }
  if ($amount>1)
  {
    $message3=sprintf("Slechts een user level mogelijk");
  } 

  if (  (!empty($message1) )||(!empty($message2) )||(!empty($message3) ) )
  {
     $executestring.= sprintf("new_users.php?users_pk=$users_pk&message_lastname=$message1&message_login=$message2&message_level=$message3&t=%d",time());
     header($executestring);
     exit();
  }   



  if ($users_pk<0)  //new user
  {  
     $table_users='users';
     $table_selector_user='selector_user';

	 // check if username (login) is already taken
	 $user_exists_Stmt = "SELECT count(*) from $table_users where login='%s'";
	 $user_exists_Stmt = sprintf($user_exists_Stmt,$users_login);
	 
     if (!($result= $link->query($user_exists_Stmt))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt)) ;
        DisplayErrMsg(sprintf("error: %s", $link->error)) ;
        exit() ;
     }
     
	 $user_exists = $result->fetch_row();
	 if($user_exists[0]>0) {
		echo "Gebruikersnaam bestaat al!";
		echo '<FORM><INPUT Type="button" VALUE="Terug" onClick="history.go(-1);return true;"></FORM>';
		exit();
	 }
	 
     $addStmt = "Insert into $table_users(firstname,lastname,initials,phone,email,login_level_1,login_level_2,login_level_3,login_level_4,login_level_5,login,password) values ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')";
     $addStmt=sprintf($addStmt,$users_firstname,$users_lastname,$users_initials,$users_phone,$users_email,$login_level_1,$login_level_2,$login_level_3,$login_level_4,$login_level_5,$users_login,md5($first_login));

     $add_selector_user_Stmt = "insert into $table_selector_user (selector_pk, user_pk) VALUES ('%d', '%d')";
   
     if (!($link->query($addStmt))) 
     {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $addStmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
     }
     $last_id = $link->insert_id;
     
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
         if (!($link->query(sprintf($add_selector_user_Stmt,$selector_ref_key[$i],$last_id)))) {
         DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($add_selector_user_Stmt,$selector_ref_key[$i],$users_pk) )) ;
         DisplayErrMsg(sprintf("error: %s", $link->error)) ;
         exit() ;
         }
       }
       $i++;
     }

     $executestring.= sprintf("create_users.php?t=%d",time());
     header($executestring);
     exit();

  }
  if ($users_pk>0)   //update user
  {  
    
    $table_users='users';
    $table_selector_user='selector_user';

    $update_users_Stmt = "Update $table_users set  firstname='%s',lastname='%s',initials='%s',phone='%s',email='%s',login_level_1='%s',login_level_2='%s',login_level_3='%s',login_level_4='%s',login_level_5='%s',login='%s' where $table_users.pk='%d'";
    $update_users_Stmt = sprintf($update_users_Stmt,$users_firstname,$users_lastname,$users_initials,$users_phone,$users_email,$login_level_1,$login_level_2,$login_level_3,$login_level_4,$login_level_5,$users_login,$users_pk);

    $add_selector_user_Stmt = "insert into $table_selector_user (selector_pk, user_pk) VALUES ('%d', '%d')";
    $del_selector_user_Stmt = "delete FROM $table_selector_user WHERE user_pk='%d'"; 
    $del_selector_user_Stmt = sprintf($del_selector_user_Stmt,$users_pk);

   

    if (!($link->query($update_users_Stmt))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $update_users_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
    }

    if (!($link->query($del_selector_user_Stmt))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_selector_user_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
    }

   
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
    
        if (!($link->query(sprintf($add_selector_user_Stmt,$selector_ref_key[$i],$users_pk)))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($add_selector_user_Stmt,$selector_ref_key[$i],$users_pk) )) ;
        DisplayErrMsg(sprintf("error: %s", $link->error)) ;
        exit() ;
        }
      }
      $i++;
    }



    $executestring.= sprintf("create_users.php?t=%d",time());
    header($executestring);
    exit();
  }
  
}



//////////////////////////////////////////////////////////////////////////////////////////
// if it will get to here it is the first time
///////////////////////////////////////////////////////////////////////////////////////////



    

  $users = new Smarty_NM();

  $table_selector='selector';
  $table_selector_user='selector_user';
  $table_analysemodule='analysemodule';
  $table_analysemodule_cfg='analysemodule_cfg';
  $table_selector_category='selector_categorie';    
  $table_users='users';
    
     
  $users_Stmt = "SELECT * from $table_users where $table_users.pk=$users_pk";
 

  $selector_Stmt="SELECT $table_selector.pk as 'pk', $table_selector.name as 'name',$table_selector.description as 'description', $table_selector.analyselevel as 'analyselevel',  
  $table_selector.analysemodule_fk as 'analysemodule_fk', $table_selector.analysemodule_cfg_fk as 'analysemodule_cfg_fk',
  $table_selector.modaliteit as 'modaliteit', $table_selector.lokatie as 'lokatie', $table_selector.qc_frequentie as 'qc_frequentie',
  $table_selector_user.selector_pk     as 'selector_pk',$table_selector_category.omschrijving as 'omschrijving' from ($table_selector left join $table_selector_category on $table_selector.selector_categorie_fk=$table_selector_category.pk) left join                 $table_selector_user on $table_selector.pk=$table_selector_user.selector_pk and $table_selector_user.user_pk='%d' order by $table_selector.name"; 

  $module_file_Stmt = "SELECT * from $table_analysemodule 
  where $table_analysemodule.pk='%d'";

  $config_file_Stmt = "SELECT * from $table_analysemodule_cfg 
  where $table_analysemodule_cfg.pk='%d'";


  if ($users_pk<0)  //add
  {
    $users->assign("users_value","Add");  
    $users->assign("message_lastname",$message_lastname);
    $users->assign("message_login",$message_login);
    $users->assign("message_level",$message_level);
  }  
  
  if ($users_pk>0)  //modify
  {
    

    if (!($result_users= $link->query($users_Stmt))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt)) ;
       DisplayErrMsg(sprintf("error: %s", $link->error)) ;
       exit() ;
    }
  
    $field_users = $result_users->fetch_object();


    $users->assign("users_value","Modify");

    $users->assign("default_users_firstname",$field_users->firstname);
    $users->assign("default_users_middlename",$field_users->middlename);
    $users->assign("default_users_lastname",$field_users->lastname);
    $users->assign("default_users_phone",$field_users->phone);
    $users->assign("default_users_email",$field_users->email);
    $users->assign("default_users_initials",$field_users->initials);
    $users->assign("default_users_login",$field_users->login);
    $checked1='';
    $checked2='';
    $checked3='';
    $checked4='';
    $checked5='';

    if ($field_users->login_level_1=='on')
    {
      $checked1='checked';
    }
    if ($field_users->login_level_2=='on')
    {
      $checked2='checked';
    }
    if ($field_users->login_level_3=='on')
    {
      $checked3='checked';
    }
    if ($field_users->login_level_4=='on')
    {
      $checked4='checked';
    }
    if ($field_users->login_level_5=='on')
    {
      $checked5='checked';
    }

    $users->assign("checked_login_level_1",$checked1);
    $users->assign("checked_login_level_2",$checked2);
    $users->assign("checked_login_level_3",$checked3);
    $users->assign("checked_login_level_4",$checked4);
    $users->assign("checked_login_level_5",$checked5);
    $users->assign("message_lastname",$message_lastname);
    $users->assign("message_login",$message_login);
    $users->assign("message_level",$message_level);

    //printf($selector_Stmt, $field_users->pk);
    //exit();

    $result_users->close();
  }
  
    if (!($result_selector= $link->query(sprintf($selector_Stmt, $users_pk)))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($selector_Stmt, $field_users->pk))) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
    }

    $table_selector='';
   
    $j=0;
    while ($field_selector = $result_selector->fetch_object())
    {
      //$selector_patient_fk=$field_selector->selector_patient_fk;
      //$selector_study_fk=$field_selector->selector_study_fk;
      //$selector_series_fk=$field_selector->selector_series_fk;
      //$selector_instance_fk=$field_selector->selector_instance_fk;
      $selector_category=$field_selector->omschrijving;

      if (!($result_analysemodule= $link->query(sprintf($module_file_Stmt,$field_selector->analysemodule_fk)))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($module_file_Stmt,$field_selector->analysemodule_fk))) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;}

      $field_analysemodule = $result_analysemodule->fetch_object();
      $analysemodule_name=$field_analysemodule->description;
      $result_analysemodule->close();

      if (!($result_analysemodule_cfg= $link->query(sprintf($config_file_Stmt,$field_selector->analysemodule_cfg_fk)))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($configfile_Stmt,$field_selector->analysemodule_cfg_fk))) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ; }

      $field_analysemodule_cfg = $result_analysemodule_cfg->fetch_object();
      $analysemodule_cfg_name=$field_analysemodule_cfg->description;
      $result_analysemodule_cfg->close();


      $b=($j%2);
      $bgcolor=''; 
      if ($b==0)
      {
        $bgcolor='#B8E7FF';
      }   

      $table_data = new Smarty_NM();
   
      if ($j==0) //define header data
      {
        $table_selector=$table_data->fetch("selector_select_header.tpl");
      }

      $action=sprintf("new_selector.php?pk=%d&selector_patient_fk=%d&selector_study_fk=%d&selector_series_fk=%d&selector_instance_fk=%d&t=%d",$field_selector->pk,$selector_patient_fk,$selector_study_fk,$selector_series_fk,$selector_instance_fk,time()); 
      $checkbox_name=sprintf("selector[%d]",$field_selector->pk);
      $table_data->assign("bgcolor",$bgcolor);
      $table_data->assign("checkbox_name",$checkbox_name);
      $table_data->assign("name",$field_selector->name);
      $table_data->assign("analysemodule",$analysemodule_name);
      $table_data->assign("analysemodule_cfg",$analysemodule_cfg_name);
      $table_data->assign("category",$selector_category);
      $table_data->assign("modality",$field_selector->modaliteit);
      $table_data->assign("location",$field_selector->lokatie);
      $table_data->assign("qc_frequency",$qc_frequency_list[$field_selector->qc_frequentie]);
      if (!is_null($field_selector->selector_pk))
      {
          $table_data->assign("checked","checked");
      } 
      $table_data->assign("action",$action);
      
      $table_selector.=$table_data->fetch("selector_selector_select_row.tpl");

      $j++;
    }

    $result_selector->close(); 
    

//  } 



  $users->assign("action_new_users",sprintf("new_users.php?users_pk=$users_pk&t=%d",time()));
  $users->assign("selector_list",$table_selector);

  $users->display("new_users.tpl");


?>





