<?php /* Smarty version 2.6.7, created on 2012-10-03 09:53:42
         compiled from new_selector.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'new_selector.tpl', 33, false),)), $this); ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>New Selector</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<form action="<?php echo $this->_tpl_vars['action_new_selector']; ?>
" method="POST" >

<font class="table_data_blue_header">New Selector</font>
<hr>
<table>
  <tr>
    <td class="table_data_blue"> Name </td>
    <td class="table_data">
      <input   name="selector_name" type="text" value="<?php echo $this->_tpl_vars['default_selector_name']; ?>
" size="50"> </input>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Description</td>
    <td class="table_data">
      <textarea name="selector_description" cols="50" rows="5"><?php echo $this->_tpl_vars['default_selector_description']; ?>
</textarea>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Analyse Level </td>
    <td class="table_data">
         <select name="selector_analyselevel">
           <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['analyselevel_options'],'selected' => $this->_tpl_vars['analyselevel_id']), $this);?>

         </select>
    </td>
  </tr>

</table>
     
<hr>
<font class="table_data_blue_header">Selector files</font>
<table> 
  <tr>
    <td class="table_data_blue"> Analysemodule </td>
    <td class="table_data">
         <select name="analysemodule_pk">
           <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['analysemodule_options'],'selected' => $this->_tpl_vars['analysemodule_id']), $this);?>

         </select>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Analysemodule config </td>
    <td class="table_data">
         <select name="analysemodule_cfg_pk">
           <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['analysemodule_cfg_options'],'selected' => $this->_tpl_vars['analysemodule_cfg_id']), $this);?>

         </select>
    </td>
  </tr>
</table>
<hr>
<input type="submit" name="action" value="<?php echo $this->_tpl_vars['submit_value']; ?>
">
<hr>
<font class="table_data_blue_header">Constraints</font>
<?php echo $this->_tpl_vars['table_buttons']; ?>

<?php echo $this->_tpl_vars['table_pssi']; ?>


</form>
</body>
</HTML>

