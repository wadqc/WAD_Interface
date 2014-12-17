<!-- source template: first_login.tpl -->
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="../open_school/css/styles.css" type="text/css">
  <title>template verwijzer</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<img src="{$login_picure_src}" border="0">

<form action="{$login_action}" method="POST">

<table>
<tr>
  <td class="template_data"> {$message}</td>
</tr>
<tr>
  <td class="template_data"> Insert Password (first time)</td>
  <td class="template_data"><input type="password" name="user_password1" size=16 maxlength=20></td>
</tr>
<tr>
  <td class="template_data"> Insert Password (second time)</td>
  <td class="template_data"><input type="password" name="user_password2" size=16 maxlength=20></td>
</tr>
<tr>
  <td class="template_data"> <input type="submit" value="{$login_submit}"> </td>
</tr>
</table>

</form>
