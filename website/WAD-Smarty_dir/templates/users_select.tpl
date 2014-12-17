<!-- source template: users_select.tpl -->
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

<br>
<br>

<table class="table_selectorbar">
<tr bgcolor="#B8E7FF">
  <td>&nbsp;&nbsp;Selectie
    &nbsp;&nbsp;<select name="transfer_action">
      <option value="reset_pwd">Wachtwoord reset</option>
      <option value="delete">User verwijderen</option></select>
    &nbsp;&nbsp;<input type="submit" value="Go!">
  </td>
</tr>
<tr bgcolor="#B8E7FF">
  <td colspan="2" align="left">
     &nbsp;&nbsp;{$new_users}&nbsp;&nbsp;
  </td>
</tr>
</table>


</form>

</body>
</html>
