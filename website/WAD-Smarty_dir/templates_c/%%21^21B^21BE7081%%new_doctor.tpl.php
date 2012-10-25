<?php /* Smarty version 2.6.7, created on 2007-08-07 05:28:24
         compiled from new_doctor.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>template verwijzer</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
</h1>

<form action="<?php echo $this->_tpl_vars['action_new_doctor']; ?>
" method="POST" >
<table>
  <tr>
    <td class="table_data_blue"> title</td>
    <td class="table_data">
         <input   name="title" type="text" value="<?php echo $this->_tpl_vars['default_title']; ?>
" size="30"> </input>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Firstname </td>
    <td class="table_data">
         <input   name="firstname" type="text" value="<?php echo $this->_tpl_vars['default_fname']; ?>
" size="30"> </input>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Lastname </td>
    <td class="table_data">
         <input   name="lastname" type="text" value="<?php echo $this->_tpl_vars['default_lname']; ?>
" size="30"> </input>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Address </td>
    <td class="table_data">
         <input   name="address" type="text" value="<?php echo $this->_tpl_vars['default_address']; ?>
" size="30"> </input>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Phone </td>
    <td class="table_data">
         <input   name="phone" type="text" value="<?php echo $this->_tpl_vars['default_phone']; ?>
" size="30"> </input>
    </td>
  </tr>
</table>
<input type="submit" name="action" value="<?php echo $this->_tpl_vars['submit_value']; ?>
">


</form>
</body>
</HTML>

