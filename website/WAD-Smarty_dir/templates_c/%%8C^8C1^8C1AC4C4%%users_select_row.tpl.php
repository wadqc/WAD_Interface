<?php /* Smarty version 2.6.7, created on 2012-10-03 12:09:08
         compiled from users_select_row.tpl */ ?>
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
    <?php echo $this->_tpl_vars['phone']; ?>

  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['email']; ?>

  </td>
</tr>