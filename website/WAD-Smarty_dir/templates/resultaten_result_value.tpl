<!-- source template: resultaten_result_value.tpl -->
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>{$Title}</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#F3F6FF">
<h1 class="table_data_blue" >&nbsp;&nbsp; {$header_result} </h1>
<br>
<h1 class="table_data_blue" >{$header_value} </h1>

<!-- Export to excel not supported for char type data
<a href="{$export_action}" target="_blank"><img src="{$picture_src}" border=0></a>
-->

<table NOSAVE="true" class="table_general">
  {$resultaten_value_list}
</table>


</body>
</html>
















