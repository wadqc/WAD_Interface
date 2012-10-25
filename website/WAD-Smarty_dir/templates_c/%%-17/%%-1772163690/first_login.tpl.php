<?php /* Smarty version 2.4.2, created on 2005-02-02 22:13:05
         compiled from first_login.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="../mpc/css/styles.css" type="text/css">
  <title>template verwijzer</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<img src="../mpc/pictures/logo_open_school.jpg" border="0">

<form action="<?php echo $this->_tpl_vars['login_action']; ?>
" method="POST">

<table>
<tr>
  <td class="template_data"> <?php echo $this->_tpl_vars['message']; ?>
</td>
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
  <td class="template_data"> <input type="submit" value="<?php echo $this->_tpl_vars['login_submit']; ?>
"> </td>
</tr>
</table>

</form>