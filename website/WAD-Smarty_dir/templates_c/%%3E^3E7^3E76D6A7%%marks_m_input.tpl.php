<?php /* Smarty version 2.6.7, created on 2007-06-01 09:44:17
         compiled from marks_m_input.tpl */ ?>
<td class="table_data_blue_scroll">
  <input return="true" enter(event)"="true" type="text" name="<?php echo $this->_tpl_vars['mark_name']; ?>
" value="<?php echo $this->_tpl_vars['mark_value']; ?>
" size="3" maxlength="3" align="middle" id="<?php echo $this->_tpl_vars['id_name']; ?>
" onkeypress="return enter(event)" onkeydown="return goodchars_mark(event,this.value,'<?php echo $this->_tpl_vars['id_name']; ?>
',<?php echo $this->_tpl_vars['row_max']; ?>
,<?php echo $this->_tpl_vars['col_max']; ?>
) ">
</td>
