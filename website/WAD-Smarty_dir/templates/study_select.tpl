<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>IQC</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
  <script type="text/javascript" language="JavaScript" src="./java/scripts.js"></script> 
</head>
<body bgcolor="#F3F6FF">
<form action="{$form_action}" method="POST">
<br>
<br>

{$selection_list}

<br>
<br>

<table NOSAVE="true" class="table_general">
  {$study_list}
</table>

<table class="table_selectorbar">
<tr bgcolor="#B8E7FF">
  <td>&nbsp;&nbsp;Selectie
    &nbsp;&nbsp;<select name="transfer_action"><option value="reset">reset</option></select>
    &nbsp;&nbsp;<input type="submit" value="Go!">
  </td>
</tr>
</table>
</form>
</html>
