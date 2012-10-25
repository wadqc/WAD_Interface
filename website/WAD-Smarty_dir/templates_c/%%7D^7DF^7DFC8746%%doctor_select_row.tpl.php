<?php /* Smarty version 2.6.7, created on 2007-06-27 09:34:45
         compiled from doctor_select_row.tpl */ ?>
<tr bgcolor="<?php echo $this->_tpl_vars['bgcolor']; ?>
">
  <td>
    <input type="checkbox" name="<?php echo $this->_tpl_vars['checkbox_name']; ?>
" value="on">
  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['title']; ?>

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
    <?php echo $this->_tpl_vars['address']; ?>

  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['phone']; ?>

  </td>
</tr>