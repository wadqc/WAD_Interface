<?php

function sanitize($array_input)
{
   $result=array();
   foreach($array_input as $key=>$value)
   {
     if (is_array($value))
     {
        $result[$key]=sanitize($value);
     }
     else
     {
         $result[$key]=trim(htmlentities($value));
     }  
   }
   return($result);
}


function sanitize_var($var)
{
  $result=trim(htmlentities($var));
  return($result);   
}


?>