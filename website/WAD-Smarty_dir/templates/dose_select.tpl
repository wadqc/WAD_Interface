<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>show_patient_template</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  {* <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> *}
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="GENERATOR" content="Quanta Plus">
  <script type="text/javascript" language="JavaScript" src="./java/scripts.js"></script> 
</head>
<body bgcolor="#F3F6FF">
<h1 class="table_data_blue" >{$header} </h1>

<form action="{$form_action}" method="POST">

{$selector_list}

<br>
<br>

<a href="{$export_action}" target="_blank"><img src="{$picture_src}" border=0></a>
<table NOSAVE="true" class="table_general">
  {$dose_list}
</table>

<br>



</form>

</body>
</html>
