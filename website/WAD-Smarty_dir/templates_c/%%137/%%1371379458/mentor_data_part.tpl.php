<?php /* Smarty version 2.4.2, created on 2005-02-06 22:53:03
         compiled from mentor_data_part.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'mentor_data_part.tpl', 1, false),)); ?><td class="table_data"><select name=<?php echo $this->_tpl_vars['teacher_name']; ?>
><?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['teacher_options'],'selected' => $this->_tpl_vars['teacher_id']), $this) ; ?>
 </select> </td>
