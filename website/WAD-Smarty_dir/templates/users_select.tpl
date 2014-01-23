<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>show_patient_template</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#F3F6FF">
<h1 class="table_data_blue" >{$header} </h1>

<form action="{$form_action}" method="POST">


<table NOSAVE="true" class="table_general">
  {$users_list}
</table>
<table bgcolor="#6767ff">
<tr>
  <td bgcolor="#F3F6FF" class="template_data">Selection</td>
  <td bgcolor="#f3f6ff" class="template_data"> <select name="transfer_action">
    <option value="reset_pwd" >reset_pwd</option>
    <option value="delete" >delete</option>
    </select><input type="submit" value="Go!">
  </td>
</tr>
</table>


{$new_users}


</form>

</body>
</html>
