<?

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$dir=$_GET['dir'];
$v=$_GET['v'];
$page=$_GET['page'];
$picture_offset=$_GET['picture_offset'];
$new_student_ref='';
if (!empty($_GET['new_student_ref']))
{
  $new_student_ref=$_GET['new_student_ref'];
}


$year_ref=-1; //just a value, in case used by student
if (!empty($_GET['year_ref']))
{
  $year_ref=$_GET['year_ref'];
}

$picture_folder=sprintf("%s%s",$picture_root,$dir);

$dh=opendir($picture_folder);

$counter=0;
$count=0;
$path='.';
$directory_array =array();
$file_array=array(); 
while (false!== ($filename=readdir($dh)))   
{
  $dir_vol=sprintf("%s/%s",$picture_folder,$filename);  
  
  //directory
  if (is_dir($dir_vol))
  {
    if (($filename!='.')&&($filename!='..'))
    {
      $directory_array[$count]=$filename;
      $count++; 
    }
    if (($filename=='..')&&($dir!=$picture_offset))
    {
      $directory_array[$count]=$filename;
      $count++; 
    }
  }
  
  //pictures
  if (!(is_dir($dir_vol)))
  {
    $file_array[$counter]=$filename;
    $counter++; 
  }
}
if( is_dir($dh) ) closedir( $dh );
sort( $directory_array ); reset( $directory_array );
sort( $file_array ); reset( $file_array );


$dir_content='';
$dir_naam = new Smarty_NM(); 
$k=0;
while($k<$count)
{
  $dir_name=$directory_array[$k];
  $new_dir=sprintf("%s%s/",$dir,$dir_name);
  
  if ($dir_name=='.')
  {
    $new_dir=$dir;
  } 
  
  if ($dir_name=='..')
  {
    $kill    = 0;    // Kills while loop when changed
    $offset  = 0;    // Offset for strpos()
    $i       = 0;    // Counter, not iterator
    $previous=0;
    while ($kill == 0) 
    {
      $i++;
      $result = strpos($dir,'/',$offset);
      if ($result == FALSE) 
      {
          $kill = 1;
      }
      else
      {
         $previous=$offset;
         $offset = $result + 1;    // Offset is set 1 character after previous occurence
      }
    }  
    $dir_temp=substr($dir,0,$previous);
    $new_dir=sprintf("%s",$dir_temp);
  }
  
  $dir_action=sprintf("insert_picture.php?dir=$new_dir&picture_offset=$picture_offset&school=$school&school_year=$school_year&page=$page&new_student_ref=$new_student_ref&v=$v&t=%d",time());
  $dir_naam->assign("dir_action",$dir_action);
  $dir_naam->assign("dir_name",$dir_name);
  $dir_content.=$dir_naam->fetch("directory_row.tpl");
  $k++;
}

$j=0;
$i=0;
$picture_content='';
$picture = new Smarty_NM();
$name = new Smarty_NM(); 
$picture_row='';
$name_row='';
$table_content='';
$b=0;
while($j<$counter)
{
  $filename=$file_array[$j];
  $full_picture=sprintf("%s%s",$picture_folder,$filename);
  $database_picture=sprintf("%s%s",$dir,$filename);
  $picture_action=sprintf("%s?picture=$database_picture&school=$school&school_year=$school_year&year_ref=$year_ref&new_student_ref=$new_student_ref&t=%d",$page,time());
  
  $picture_src=sprintf("image_resize.php?f_name=$full_picture&height=80");
  $picture->assign("picture_src",$picture_src);
  $picture->assign("picture_action",$picture_action);
  $name->assign("picture_name",$filename);  
  $picture_row.=$picture->fetch("insert_picture_row.tpl");
  $name_row.=$name->fetch("insert_picture_name_row.tpl");
   
  $j++;
  $b=($j%8);
  if (($b==0)&&($j>0))
  {
    $table_content.=sprintf("<tr>%s</tr>",$picture_row);
    $table_content.=sprintf("<tr>%s</tr>",$name_row);
    $picture_row='';
    $name_row='';
  }
}  

if ($b!=0)
{
  while ($b<8)
  {
    $picture_row.=sprintf("<td></td>");
    $name_row.=sprintf("<td></td>");
    $b++;
  }
  $table_content.=sprintf("<tr>%s</tr>",$picture_row);
  $table_content.=sprintf("<tr>%s</tr>",$name_row);
}

$start_year=substr($school_year,0,4);
$stop_year=substr($school_year,5,4);




if ($v==0) //student
{
   $picture_folder=sprintf("%s%s%s_%s",$picture_root,$picture_student_dir,$start_year,$stop_year);
} 
if ($v==1) //teacher
{
   $picture_folder=sprintf("%s%s%s_%s",$picture_root,$picture_teacher_dir,$start_year,$stop_year);
} 

$upload_action=sprintf("file_upload_body.php?school=$school&school_year=$school_year&year_ref=$year_ref&new_student_ref=$new_student_ref&picture_folder=$picture_folder&v=$v&t=%d",time());


$pic = new Smarty_NM();
$pic->assign("header",$dir);
$pic->assign("dir_content",$dir_content);
$pic->assign("table_rows",$table_content);
$pic->assign("upload_action",$upload_action);



$pic->display("insert_picture_form.tpl");


?>

