<!-- source template: constraint.tpl -->
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>template verwijzer</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<form action="{$action_constraint}" method="POST" >
<h1 class="table_data_blue" >{$header}</h1>

<h2 style="font-size:small;font-style:italic;font-weight:normal;">N.B. Eventueel kan een ";" worden gebruikt als "OR" parameter. Ondersteunde wildcards zijn "*" en "?"</h2>

<table valign="top" align="left">
  <tr>
    <td>
      {$table_patient}
	</td>
    <td>
      {$table_study}
	</td>
    <td>
      {$table_series}
	</td>
    <td>
      {$table_instance}
	</td>

  </tr>


  <tr>
   <td>
      <input type="submit" name="action" value="{$submit_value}">
   </td>
  </tr>
</table>

</form>
</body>
</HTML>
