<?php /* Smarty version 2.6.7, created on 2005-02-21 12:20:25
         compiled from category.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'category.tpl', 2, false),)), $this); ?>
 <td class="table_data"> <?php echo $this->_tpl_vars['name']; ?>
 </td>
 <td class="table_data"> <select name="<?php echo $this->_tpl_vars['number']; ?>
"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['number_options'],'selected' => $this->_tpl_vars['default_number']), $this);?>
 </select></td>
 <td class="table_data"> <select name="<?php echo $this->_tpl_vars['code']; ?>
"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['code_options'],'selected' => $this->_tpl_vars['default_code']), $this);?>
 </select></td>