<?php /* Smarty version 2.6.7, created on 2006-11-11 15:37:59
         compiled from term_select_junior.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'term_select_junior.tpl', 15, false),)), $this); ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>show_patient_template</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#F3F6FF">


<form action="<?php echo $this->_tpl_vars['form_action']; ?>
" method="POST">
<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
 </h1><select name="year_color">
              <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['year_color_options'],'selected' => $this->_tpl_vars['default_color']), $this);?>

            </select>

<table border  bgcolor="#f3f6ff" frame="border" NOSAVE>
  <?php echo $this->_tpl_vars['term_list']; ?>

</table>
<input type="submit" name="submit" value="submit"> 
</form>
</body>
</html>