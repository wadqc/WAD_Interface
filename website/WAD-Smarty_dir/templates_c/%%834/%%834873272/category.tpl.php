<?php /* Smarty version 2.4.2, created on 2005-02-06 23:03:44
         compiled from category.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'category.tpl', 2, false),)); ?> <td class="table_data"> <?php echo $this->_tpl_vars['name']; ?>
 </td>
 <td class="table_data"> <select name="<?php echo $this->_tpl_vars['number']; ?>
"><?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['number_options'],'selected' => $this->_tpl_vars['default_number']), $this) ; ?>
 </select></td>
 <td class="table_data"> <select name="<?php echo $this->_tpl_vars['code']; ?>
"><?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['code_options'],'selected' => $this->_tpl_vars['default_code']), $this) ; ?>
 </select></td>