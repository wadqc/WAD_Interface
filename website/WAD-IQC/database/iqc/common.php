<?php

function GenerateHTMLHeader($message)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
  <title>Main page neuro modulatie</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff">

<?php
printf("<font color=\"red\" class=\"keuze_data\">%s
</font><br></body>",$message);
}


function ReturnToMain() {
printf("
<table>
  <tr>
    <td class=\"button_data\"><a href=\"./frontpage-bottom.html\"
    class=\"href_table_data\">Return to Main</a></td>
  </tr>
</table>");
}

// Display error messages
function DisplayErrMsg( $message ) {

printf("<BLOCKQUOTE><BLOCKQUOTE><BLOCKQUOTE><H3><FONT COLOR=\"#CC0000\">
         %s</FONT></H3></BLOCKQUOTE></BLOCKQUOTE></BLOCKQUOTE>\n", $message);
}




?>