<?php /* Smarty version 2.6.7, created on 2007-08-07 07:14:17
         compiled from mentor_data_part.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'mentor_data_part.tpl', 1, false),)), $this); ?>
<td class="table_data"><select name=<?php echo $this->_tpl_vars['teacher_name']; ?>
><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['teacher_options'],'selected' => $this->_tpl_vars['teacher_id']), $this);?>
 </select> </td>
