<!-- source template: dashboard.tpl -->
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>{$Title}</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <link rel="stylesheet" type="text/css" media="all" href="./java/js/tablekit/css/style.css"/>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
  <script type="text/javascript" language="JavaScript" src="./java/scripts.js"></script>
  <!-- tbv tablekit (sorteerbare tabellen); zet refresh uit bij aanpassing sortering -->
  <script type="text/javascript" src="./java/js/prototype.js"></script>
  <script type="text/javascript" src="./java/js/tablekit/fabtabulous.js"></script>
  <script type="text/javascript" src="./java/js/tablekit/tablekit.js"></script>
</head>
<body bgcolor="#F3F6FF">
<form action="{$form_action}" method="POST">
<br>
<br>

{$dashboard_filter}

<br>
<br>
<!-- <h1 class="table_data_blue" >{$header} </h1> -->
<table NOSAVE="true" class="table_general sortable">
  {$selector_list}
</table>

<script>disable_refresh_on_click();</script>

</body>
</html>
