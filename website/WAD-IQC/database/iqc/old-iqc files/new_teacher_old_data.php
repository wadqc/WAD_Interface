$teacher = new Smarty_NM();


if (!empty($_POST['picture'])) //returns from add/modify picture
{
  $school=$_GET['school'];
  $school_year=$_GET['school_year']; 
  $picture=$_POST['picture'];
  
  $table_new_teacher='new_teacher';
  $new_teacher_Stmt = "SELECT * from $table_new_teacher";

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
  
  if (!($result_new_teacher= mysql_query($new_teacher_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  //$picture_path=sprintf("%s%s",$picture_dir,$picture);
  //if (($picture==".")||($picture==".."))
  //{
  //  $picture=sprintf("%s",'logo_shirt.jpg');
  //}
  //$picture_path=sprintf("%s%s",$picture_dir,$picture);

  //$picture_path=sprintf("%s%s",$picture_dir,$picture);
  if (($picture==".")||($picture==".."))
  {
    $picture=sprintf("%s%s",$picture_teacher_dir,$logo_shirt);
  }
  //$picture_path=sprintf("%s%s",$picture_dir,$picture);
  $picture_path=sprintf("%s",$picture);
  //printf("path=%s", $picture_path);



  $teacher->assign("teacher_value","Add");  
  $teacher->assign("default_picture",$picture_path);
  
  $new = mysql_fetch_object($result_new_teacher);

  $teacher->assign("default_title",$new->title);
  $teacher->assign("default_fname",$new->firstname);
  $teacher->assign("default_lname",$new->lastname);
  $teacher->assign("sex_id",$new->sex);
  $teacher->assign("time_teacher",$new->date_of_birth);
  $teacher->assign("default_address",$new->address);
  $teacher->assign("default_phone",$new->phone);
  $teacher->assign("default_initials",$new->initials);
  $teacher->assign("default_login",$new->login);

  $checked1='';
  $checked2='';
  $checked3='';

  if ($new->level_1=='on')
  {
     $checked1='checked';
  }
  if ($new->level_2=='on')
  {
     $checked2='checked';
  }
  if ($new->level_3=='on')
  {
     $checked3='checked';
  }

  $teacher->assign("checked_level_1",$checked1);
  $teacher->assign("checked_level_2",$checked2);
  $teacher->assign("checked_level_3",$checked3);



  mysql_free_result($result_new_teacher);
}

if (empty($_POST['picture']))
{
  //$picture=sprintf("%s",'logo_shirt.jpg');
  $picture_path=sprintf("%s%s",$picture_teacher_dir,$logo_shirt);

  $teacher->assign("teacher_value","Add");  
  $teacher->assign("default_picture",$picture_path);
  
}
  $picture_path=sprintf("%s%s",$picture_teacher_dir,$logo_shirt);
  $teacher->assign("submit_value","Insert");
  
  $teacher->assign("action_new_teacher",sprintf("new_teacher.php?school=$school&school_year=$school_year&picture=$picture_path&t=%d",time()));

  $list_sex["m"]="m";
  $list_sex["v"]="v";
  $teacher->assign("sex_options",$list_sex);

  $header=sprintf("%s %s",$school,$school_year);
  $teacher->assign("header",$header);

  $teacher->display("new_teacher.tpl");

  ReturnToMain();
 