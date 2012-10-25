<?php /* Smarty version 2.6.7, created on 2005-06-02 15:13:26
         compiled from new_credit.tpl */ ?>
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

<form action="<?php echo $this->_tpl_vars['action_new_credit']; ?>
" method="POST" >
<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
</h1>

<table border="1" frame="border">
  <tr>
    <td  class="table_data_blue_header"> Project </td>
    <td  class="table_data_blue_header"> Credits</td>
  </tr>
  <tr>
	<td class="table_data">
         <input   name="project" type="text" value="<?php echo $this->_tpl_vars['default_project']; ?>
" size="60"> </input>
    </td>
    <td align="center" class="table_data">
         <input   name="credits" type="text" value="<?php echo $this->_tpl_vars['default_credits']; ?>
" size="3"> </input>
    </td>
  </tr>
</table>

<input type="submit" name="action" value="<?php echo $this->_tpl_vars['submit_value']; ?>
">


</form>
</body>
</HTML>

