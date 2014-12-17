<!-- source template: resultaten_result_object.tpl -->
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
<h1 class="table_data_blue" >{$header_result} </h1>
<hr>
<h1 class="table_data_blue" >{$header_char} </h1>
<table NOSAVE="true" width="100%" border="true" bgcolor="#f3f6ff" frame="border">
  {$resultaten_char_list}
</table>
<h1 class="table_data_blue" >{$header_floating} </h1>
<table NOSAVE="true" width="100%" border="true" bgcolor="#f3f6ff" frame="border">
  {$resultaten_floating_list}
</table>
<h1 class="table_data_blue" >{$header_object} </h1>
<table NOSAVE="true" width="100%" bgcolor="#f3f6ff">
   {$resultaten_object_list}
</table>



</body>
</html>
















