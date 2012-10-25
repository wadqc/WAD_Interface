<?php /* Smarty version 2.4.2, created on 2005-02-09 12:20:35
         compiled from report_term_factor.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'report_term_factor.tpl', 1, false),)); ?><td class="template_data"> <select name=<?php echo $this->_tpl_vars['factor_name']; ?>
><?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['factor_options'],'selected' => $this->_tpl_vars['factor_id']), $this) ; ?>
 </select></td>