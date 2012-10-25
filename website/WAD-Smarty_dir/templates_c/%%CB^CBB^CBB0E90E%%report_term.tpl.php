<?php /* Smarty version 2.6.7, created on 2005-06-14 13:19:39
         compiled from report_term.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'report_term.tpl', 39, false),)), $this); ?>
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
<form action="<?php echo $this->_tpl_vars['report_action']; ?>
" method="POST" target="_blank">

<table>
<tr>
  <?php echo $this->_tpl_vars['term_factors']; ?>

</tr>

</table>

<table>
  <tr>
     <td colspan="2" align="left" class="template_data"> <input type="submit" value="<?php echo $this->_tpl_vars['report_name']; ?>
"> </td>
  </tr>
  <tr>
     <td colspan="2" align="left" class="template_data"> <br><br><br><br><br><br><br><br><br><br> </td>
  </tr>
  <tr>
      <td class="template_data"> Alternative tittle</td>
      <td class="template_data"> <input type="text" name="alternative_tittle" align="left"></td>
   </tr>
  <tr>
      <td class="template_data"> Show average</td>
      <td class="template_data"> <input type="checkbox" name="show_average" value="on" align="left"></td>
   </tr>
   <tr>
      <td class="template_data"> Honor Term</td>
	  <td class="template_data"> <select name="honor_term"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['term_honor_list'],'selected' => $this->_tpl_vars['term_honor_id']), $this);?>
 </select></td>
   </tr>
</table>







</form>