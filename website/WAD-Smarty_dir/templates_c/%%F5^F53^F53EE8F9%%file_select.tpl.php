<?php /* Smarty version 2.6.7, created on 2012-07-17 21:56:51
         compiled from file_select.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title><?php echo $this->_tpl_vars['Title']; ?>
</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#F3F6FF">
<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
 </h1>

<form action="<?php echo $this->_tpl_vars['form_action']; ?>
" method="POST">

<table NOSAVE="true" width="100%" border="true" bgcolor="#f3f6ff" frame="border">
  <?php echo $this->_tpl_vars['file_list']; ?>

</table>
<table bgcolor="#6767ff">
<tr>
  <td bgcolor="#F3F6FF" class="template_data">Selectie</td>
  <td bgcolor="#f3f6ff" class="template_data"> <select name="transfer_action">
    <option value="delete" >delete</option>
    </select><input type="submit" value="Go!">
  </td>
</tr>

</table>
<?php echo $this->_tpl_vars['new_file']; ?>


</form>
</body>
</html>