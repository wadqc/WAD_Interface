<?php /* Smarty version 2.6.7, created on 2005-04-06 09:26:28
         compiled from new_skill_sub.tpl */ ?>
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

<form action="<?php echo $this->_tpl_vars['action_new_skill_sub']; ?>
" method="POST" >
<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
</h1>

<table>
  <tr>
    <td class="table_data_blue"> sub Skill </td>
    <td class="table_data">
         <input   name="skill_sub" type="text" value="<?php echo $this->_tpl_vars['default_skill_sub']; ?>
" size="30"> </input>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Code</td>
    <td class="table_data">
         <input   name="code" type="text" value="<?php echo $this->_tpl_vars['default_code']; ?>
" size="30"> </input>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Number</td>
    <td class="table_data">
         <input   name="number" type="text" value="<?php echo $this->_tpl_vars['default_number']; ?>
" size="30"> </input>
    </td>
  </tr>

</table>

<input type="submit" name="action" value="<?php echo $this->_tpl_vars['submit_value']; ?>
">


</form>
</body>
</HTML>

