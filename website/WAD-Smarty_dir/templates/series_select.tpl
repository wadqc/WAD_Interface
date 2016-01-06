<!-- source template: series_select.tpl -->
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

<button onclick="location.href='status-collector.php';">Terug</button>

<form action="{$form_action}" method="POST">

<br>

{$selection_list}

<br>
<br>

<h1 class="table_data_blue" >Patient: {$patient_name}, Patient ID: {$patient_id}, study description: {$study_description} </h1> 

<table NOSAVE="true" class="table_general">
  {$series_list}
</table>

<script>disable_refresh_on_click();</script>

<br>
<br>

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
