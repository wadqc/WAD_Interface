<?php /* Smarty version 2.6.7, created on 2005-02-24 12:02:50
         compiled from subject_exam_col.tpl */ ?>
<tr bgcolor="<?php echo $this->_tpl_vars['bgcolor']; ?>
">
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
