<?php /* Smarty version 2.6.7, created on 2007-08-05 11:03:06
         compiled from subject_data_select_all.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'subject_data_select_all.tpl', 3, false),)), $this); ?>
<td class="table_data_blue_header_scroll"> <input  type="checkbox"  <?php echo $this->_tpl_vars['subject_checked']; ?>
 name="<?php echo $this->_tpl_vars['subject_name']; ?>
" value="on"></td>
<td class="table_data_blue_header_scroll"><?php echo $this->_tpl_vars['subject']; ?>
</td>
<td class="table_data_blue_header_scroll"><select name=<?php echo $this->_tpl_vars['teacher_name']; ?>
><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['teacher_options'],'selected' => $this->_tpl_vars['teacher_id']), $this);?>
 </select> </td>
<td class="table_data_blue_header_scroll"><select name=<?php echo $this->_tpl_vars['cluster_name']; ?>
><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['cluster_options'],'selected' => $this->_tpl_vars['cluster_id']), $this);?>
 </select> </td>