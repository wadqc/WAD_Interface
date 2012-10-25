<?php /* Smarty version 2.4.2, created on 2005-02-06 22:50:52
         compiled from subject_data_part.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'subject_data_part.tpl', 3, false),)); ?><td class="table_data"> <input <?php echo $this->_tpl_vars['subject_checked']; ?>
="true" type="checkbox" name="<?php echo $this->_tpl_vars['subject_name']; ?>
" value="on"></td>
<td class="table_data"><?php echo $this->_tpl_vars['subject']; ?>
</td>
<td class="table_data"><select name=<?php echo $this->_tpl_vars['teacher_name']; ?>
><?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['teacher_options'],'selected' => $this->_tpl_vars['teacher_id']), $this) ; ?>
 </select> </td>
<td class="table_data"><select name=<?php echo $this->_tpl_vars['cluster_name']; ?>
><?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['cluster_options'],'selected' => $this->_tpl_vars['cluster_id']), $this) ; ?>
 </select> </td>