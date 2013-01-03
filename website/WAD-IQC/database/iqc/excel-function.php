<?php
 function getExcelData($data){
    $retval = "";
    if (is_array($data)  && !empty($data))
    {
     $row = 0;
     foreach(array_values($data) as $_data){
      if (is_array($_data) && !empty($_data))
      {
          if ($row == 0)
          {
              // write the column headers
              $retval = implode("\t",array_keys($_data));
              $retval .= "\n";
          }
           //create a line of values for this row...
              //$retval .= implode("\t",array_values($_data));
              $retval .= str_replace(array("\r\n", "\r", "\n"),', ',implode("\t",array_values($_data)));
              $retval .= "\n";
              //increment the row so we don't create headers all over again
              $row++;
       }
       
     }
    }
  //$retval = str_replace(chr(10),' ',$retval); 
  //$retval = trim($retval,"\r");  

  return $retval;
 }
?>