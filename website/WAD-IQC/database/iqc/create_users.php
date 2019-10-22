<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



$table_users='users';


$users_Stmt = "SELECT * from $table_users 
order by $table_users.lastname, $table_users.firstname";


// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!($result_users= $link->query($users_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $users_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}


$users_row='';
 
$j=0;
while (($field_users = $result_users->fetch_object()))
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
     if (!empty($user_level_1))
     {
       $users_row=$table_data->fetch("users_select_header.tpl");
     }
     if ( (!empty($user_level_2))||(!empty($user_level_5)) ) 
     {
       $users_row=$table_data->fetch("users_header.tpl");
     }
   }
   $checkbox_name=sprintf("users[%d]",$field_users->pk);
   $action=sprintf("view_users.php?pk=%s&t=%d",$field_users->pk,time());
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("login",$field_users->login);
   $table_data->assign("firstname",$field_users->firstname);
   $table_data->assign("lastname",$field_users->lastname);
   $table_data->assign("initials",$field_users->initials);
   $table_data->assign("phone",$field_users->phone);
   $table_data->assign("email",$field_users->email);
   $table_data->assign("prefmodality",$field_users->prefmodality);
   
   $table_data->assign("action",$action);
   if (!empty($user_level_1))
   {
     $users_row.=$table_data->fetch("users_select_row.tpl");
   }
   if ( (!empty($user_level_2))||(!empty($user_level_5)) )
   {
     $users_row.=$table_data->fetch("users_row.tpl");
   }
   $j++;
}


$result_users->close();  




$data = new Smarty_NM();


$data->assign("form_action",sprintf("transfer_users.php?t=%d",time()));
$data->assign("users_list",$users_row);

$new_users=sprintf("<a href=\"new_users.php?users_pk=-1&t=%d\">Toevoegen nieuwe gebruiker</a>",time());

$data->assign("new_users",$new_users);

if (!empty($user_level_1))
{
  $data->display("users_select.tpl");
}

if ( (!empty($user_level_2))||(!empty($user_level_5)) )
{
  $data->display("users_view.tpl");
}





?>
 
  
