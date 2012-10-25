<?php /* Smarty version 2.4.2, created on 2005-02-02 21:22:10
         compiled from teacher_select_row.tpl */ ?>
<tr bgcolor="<?php echo $this->_tpl_vars['bgcolor']; ?>
">
  <td>
    <input type="checkbox" name="<?php echo $this->_tpl_vars['checkbox_name']; ?>
" value="on">
  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['firstname']; ?>

  </td>
  <td>
     <a href="<?php echo $this->_tpl_vars['action']; ?>
" class="table_data_select"><?php echo $this->_tpl_vars['lastname']; ?>
</a>
  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['initials']; ?>

  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['phone_home']; ?>

  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['phone_cell']; ?>

  </td>
</tr>