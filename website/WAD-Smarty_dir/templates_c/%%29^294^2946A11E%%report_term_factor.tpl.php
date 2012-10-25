<?php /* Smarty version 2.6.7, created on 2007-08-17 10:04:51
         compiled from report_term_factor.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'report_term_factor.tpl', 1, false),)), $this); ?>
<td class="template_data"> <select name=<?php echo $this->_tpl_vars['factor_name']; ?>
><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['factor_options'],'selected' => $this->_tpl_vars['factor_id']), $this);?>
 </select></td>