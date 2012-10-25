<?php /* Smarty version 2.6.7, created on 2007-06-23 06:30:08
         compiled from skill_select_row.tpl */ ?>
<tr bgcolor="<?php echo $this->_tpl_vars['bgcolor']; ?>
">
  <td>
    <input type="checkbox" name="<?php echo $this->_tpl_vars['checkbox_name']; ?>
" value="on">
  </td>
  <td>
     <a href="<?php echo $this->_tpl_vars['action']; ?>
" class="table_data_select"><?php echo $this->_tpl_vars['skill_name']; ?>
</a>
  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['skill_abreviation']; ?>

  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['skill_number']; ?>

  </td>
</tr>