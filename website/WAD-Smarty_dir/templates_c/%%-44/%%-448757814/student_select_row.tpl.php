<?php /* Smarty version 2.4.2, created on 2005-02-04 20:19:22
         compiled from student_select_row.tpl */ ?>
<tr bgcolor="<?php echo $this->_tpl_vars['bgcolor']; ?>
">
  <td width="20 p">
    <input type="checkbox" name="<?php echo $this->_tpl_vars['checkbox_name']; ?>
" value="on">
  </td>
  <td width="200 p">
  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['student_number']; ?>

  </td>
  <td>
     <a href="<?php echo $this->_tpl_vars['action']; ?>
" class="table_data_select"><?php echo $this->_tpl_vars['student_fname']; ?>
</a>
  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['student_lname']; ?>

  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['student_date_of_birth']; ?>

  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['student_gender']; ?>

  </td>
</tr>