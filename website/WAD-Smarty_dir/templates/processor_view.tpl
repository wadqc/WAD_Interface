<!-- source template: processor_view.tpl -->
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>IQC</title>
  <link rel="StyleSheet" href="./css/styles.css" type="text/css">
  <link rel="stylesheet" type="text/css" media="all" href="./java/js/tablekit/css/style.css"/>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
  <script type="text/javascript" language="JavaScript" src="./java/scripts.js"></script> 
  <script type="text/javascript" src="./java/js/prototype.js"></script>
  <script type="text/javascript" src="./java/js/tablekit/fabtabulous.js"></script>
  <script type="text/javascript" src="./java/js/tablekit/tablekit.js"></script>
</head>
<body bgcolor="#F3F6FF">

<br>
<br>

<!-- <h1 class="table_data_blue" >{$header} </h1> -->
<form action="{$form_action}" method="POST">
{$selection_list}

<br>
<br>

<table NOSAVE="true" class="table_general sortable"">
  {$processor_list}
</table>

</form>

</html>
