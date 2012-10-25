<?

require("../globals.php");
require("./common.php") ;
require("./delete_student_function.php");
require("./php/includes/setup.php");


$class_ref=$_GET['class_ref'];

delete_student($class_ref);

GenerateHTMLHeader("The entry was removed succesfully");
ReturnToMain();

?>





