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



if( (!empty($_POST['action']) ) )
{
  $users_pk=$_GET['users_pk'];
  

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

	 // check if username (login) is already taken
	 $user_exists_Stmt = "SELECT count(*) from $table_users where login='%s'";
	 $user_exists_Stmt = sprintf($user_exists_Stmt,$users_login);
	 
     if (!($result= mysql_query($user_exists_Stmt, $link))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
     }
     
	 $user_exists = mysql_fetch_row($result);
	 if($user_exists[0]>0) {
		echo "Gebruikersnaam bestaat al!";
		echo '<FORM><INPUT Type="button" VALUE="Terug" onClick="history.go(-1);return true;"></FORM>';
		exit();
	 }
	 
     $addStmt = "Insert into $table_users(firstname,lastname,initials,phone,email,login_level_1,login_level_2,login_level_3,login_level_4,login_level_5,login,password) values ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')";

     $addStmt=sprintf($addStmt,$users_firstname,$users_lastname,$users_initials,$users_phone,$users_email,$login_level_1,$login_level_2,$login_level_3,$login_level_4,$login_level_5,$users_login,md5($first_login));
   
     if (!(mysql_query($addStmt,$link))) 
     {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $addStmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
     }


     $executestring.= sprintf("create_users.php?t=%d",time());
     header($executestring);
     exit();

  }
  if ($users_pk>0)   //update user
  {  
    
    $table_users='users';
    
    $updateStmt = "Update $table_users set  firstname='%s',lastname='%s',initials='%s',phone='%s',email='%s',login_level_1='%s',login_level_2='%s',login_level_3='%s',login_level_4='%s',login_level_5='%s',login='%s' where $table_users.pk='%d'";
    $updateStmt=sprintf($updateStmt,$users_firstname,$users_lastname,$users_initials,$users_phone,$users_email,$login_level_1,$login_level_2,$login_level_3,$login_level_4,$login_level_5,$users_login,$users_pk);
    
    if (!(mysql_query($updateStmt,$link))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
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


  if ($users_pk<0)  //add
  {
    $users->assign("users_value","Add");  
    $users->assign("message_lastname",$message_lastname);
    $users->assign("message_login",$message_login);
    $users->assign("message_level",$message_level);
  }  
  
  if ($users_pk>0)  //modify
  {
    $table_users='users';
     
    $users_Stmt = "SELECT * from $table_users where 
    $table_users.pk=$users_pk";
 
    if (!($result_users= mysql_query($users_Stmt, $link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
    }
  
    $field_users = mysql_fetch_object($result_users);


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

    mysql_free_result($result_users);

  } 



  $users->assign("action_new_users",sprintf("new_users.php?users_pk=$users_pk&t=%d",time()));

  $users->display("new_users.tpl");


?>





