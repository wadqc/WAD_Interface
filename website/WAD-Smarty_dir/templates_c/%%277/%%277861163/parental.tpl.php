<?php /* Smarty version 2.4.2, created on 2005-02-04 19:52:31
         compiled from parental.tpl */ ?>
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

<form action="<?php echo $this->_tpl_vars['action_new_student']; ?>
" method="POST" >
<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
</h1>

<table valign="top" align="left">
  <tr>
    <td>
      <?php echo $this->_tpl_vars['table_father']; ?>

	</td>
    <td>
      <?php echo $this->_tpl_vars['table_mother']; ?>

	</td>
    <td>
      <?php echo $this->_tpl_vars['table_guardian']; ?>

	</td>
  </tr>


  <tr>
   <td>
      <input type="submit" name="action" value="<?php echo $this->_tpl_vars['submit_value']; ?>
">
   </td>
  </tr>
</table>

</form>
</body>
</HTML>