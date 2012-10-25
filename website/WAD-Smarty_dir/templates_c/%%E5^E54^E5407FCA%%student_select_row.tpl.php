<?php /* Smarty version 2.6.7, created on 2007-06-01 10:25:01
         compiled from student_select_row.tpl */ ?>
<tr bgcolor="<?php echo $this->_tpl_vars['bgcolor']; ?>
">
  <td width="20 p">
    <input type="checkbox" name="<?php echo $this->_tpl_vars['checkbox_name']; ?>
" value="on">
  </td>
  <td width="200 p">
  </td>
  <td>
    <?php echo $this->_tpl_vars['web_lock']; ?>

  </td>
  <td > <a href="<?php echo $this->_tpl_vars['action_print']; ?>
" type="image/jpeg" target="_blank" class="table_data_select" onmouseover="javascript:document.images['<?php echo $this->_tpl_vars['print_image_name']; ?>
'].src = './logo_pictures/print_icon_selected.jpg'" onmouseout="javascript:document.images['<?php echo $this->_tpl_vars['print_image_name']; ?>
'].src = './logo_pictures/print_icon.jpg'"><img src="./logo_pictures/print_icon.jpg" name="<?php echo $this->_tpl_vars['print_image_name']; ?>
" align="left" border=0></a>         </td>
  <td> <a href="<?php echo $this->_tpl_vars['action_report']; ?>
" type="image/jpeg" class="table_data_select" onmouseover="javascript:document.images['<?php echo $this->_tpl_vars['report_image_name']; ?>
'].src = './logo_pictures/report_icon_selected.jpg'" onmouseout="javascript:document.images['<?php echo $this->_tpl_vars['report_image_name']; ?>
'].src = './logo_pictures/report_icon.jpg'"><img src="./logo_pictures/report_icon.jpg" name="<?php echo $this->_tpl_vars['report_image_name']; ?>
" align="left" border=0></a>         </td>
  <td>
     <a href="<?php echo $this->_tpl_vars['action']; ?>
" class="table_data_select"><?php echo $this->_tpl_vars['student_lname']; ?>
</a>
  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['student_fname']; ?>

  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['student_date_of_birth']; ?>

  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['student_gender']; ?>

  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['student_home_phone']; ?>

  </td>
  <td class="table_data">
    <?php echo $this->_tpl_vars['student_cell_phone']; ?>

  </td>
</tr>