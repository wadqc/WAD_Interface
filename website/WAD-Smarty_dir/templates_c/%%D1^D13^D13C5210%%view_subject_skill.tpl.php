<?php /* Smarty version 2.6.7, created on 2006-05-17 15:31:37
         compiled from view_subject_skill.tpl */ ?>
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
<table>
  <tr>
    <td class="keuze_data"> skill </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['skill']; ?>

    </td>
  </tr>
  <tr>
    <td class="keuze_data"> Number </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['number']; ?>
 </td>
  </tr>
  </tr>
  <tr>
    <td> <a HREF="<?php echo $this->_tpl_vars['action_modify']; ?>
" class="table_data_select">Modify</a> /
    <a HREF="<?php echo $this->_tpl_vars['action_delete']; ?>
" class="table_data_select">Delete</a>
    </td>
  </tr>
</table>
<br><hr>
<p class="table_data_blue">Sub Skills</p>
<table>
  <?php echo $this->_tpl_vars['table_sub_skill']; ?>

</table>
<table>
<tr>
  <td> <a HREF="<?php echo $this->_tpl_vars['action_add_sub_skill']; ?>
" class="table_data_select">add Sub Skill</a>
  </td>
</tr>
</table>