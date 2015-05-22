<!-- source template: resultaten_result.tpl -->
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>{$Title}</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="GENERATOR" content="Quanta Plus">
  <script type="text/javascript" language="JavaScript" src="./java/scripts.js"></script>
</head>
<body bgcolor="#F3F6FF">
<form action="{$action_result}" method="POST" >
<h1 class="table_data_blue" >&nbsp;&nbsp; {$header_result} </h1>

{$selection_list}

<!-- <h1 class="table_data_blue" >{$header_floating} </h1> -->
<br>

<table NOSAVE="true" class="table_general">
  {$resultaten_floating_list}
</table>

<h1 class="table_data_blue" >{$header_object} </h1>

<table NOSAVE="true" class="table_general">
   {$resultaten_object_list}
</table>


</form>
</body>
</html>
















