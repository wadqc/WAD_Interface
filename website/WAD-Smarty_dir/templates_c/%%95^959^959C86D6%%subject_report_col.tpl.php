<?php /* Smarty version 2.6.7, created on 2007-08-17 10:16:05
         compiled from subject_report_col.tpl */ ?>
<tr bgcolor="<?php echo $this->_tpl_vars['bgcolor']; ?>
">
    <td class="table_data_blue">
      <?php echo $this->_tpl_vars['category']; ?>

    </td>
	<td class="table_data">
      <input type="checkbox"<?php echo $this->_tpl_vars['name']; ?>
="subject[<?php echo $this->_tpl_vars['abreviation']; ?>
]" value="on">
    </td>
	<td class="table_data">
      <?php echo $this->_tpl_vars['abreviation']; ?>

    </td>
    <td class="table_data">
	  <input type="text" name="number[<?php echo $this->_tpl_vars['abreviation']; ?>
]" value="<?php echo $this->_tpl_vars['default_number']; ?>
" size=5 maxlength=5>
    </td>
</tr>
