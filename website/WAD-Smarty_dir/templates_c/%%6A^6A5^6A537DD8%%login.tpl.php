<?php /* Smarty version 2.6.7, created on 2012-05-20 20:31:52
         compiled from login.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="../iqc/css/styles.css" type="text/css">
  <title>Image Quality Control</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body onLoad="javascript:document.first.user_name.focus();" bgcolor="#F3F6FF">
<img src="<?php echo $this->_tpl_vars['login_picure_src']; ?>
" border="0">

<form name="first" action="<?php echo $this->_tpl_vars['login_action']; ?>
" method="POST">

<table>
<tr>
  <td class="template_data"> <?php echo $this->_tpl_vars['message']; ?>
</td>
</tr>

<tr>
  <td class="template_data"> Gebruikersnaam</td>
  <td class="template_data"> <input type="text" name="user_name" value="<?php echo $this->_tpl_vars['default_login']; ?>
" size="16" maxlength="20"></td>
</tr>
<tr>
  <td class="template_data"> Wachtwoord</td>
  <td class="template_data"><input type="password" name="user_password" size=16 maxlength=20></td>
</tr>

<tr>
  <td class="template_data"> <input type="submit" value="<?php echo $this->_tpl_vars['login_submit']; ?>
"> </td>
  <td></td>
</tr>
</table>

</form>