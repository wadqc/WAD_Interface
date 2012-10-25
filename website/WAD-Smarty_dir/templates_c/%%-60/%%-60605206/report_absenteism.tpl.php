<?php /* Smarty version 2.4.2, created on 2005-02-09 12:20:45
         compiled from report_absenteism.tpl */ ?>
<table>
<TR <?php echo $this->_tpl_vars['bg_color']; ?>
>
  <td class="report_results_data" colspan="2">
     Tardiness
  </td>
  <td class="report_row_data">
     <?php echo $this->_tpl_vars['late']; ?>

  </td>
</tr>
<tr>
  <td rowspan="3" valign="top" class="report_results_data">
     Absenteism
  </td>
  <td class="report_results_data">
     Absent/no letter
  </td>
  <td class="report_row_data">
     <?php echo $this->_tpl_vars['absent']; ?>

  </td>
</tr>
<tr>
  <td class="report_results_data">
     Absent/letter
  </td>
  <td class="report_row_data">
     <?php echo $this->_tpl_vars['absent_letter']; ?>

  </td>
</tr>
<tr>
  <td class="report_results_data">
     Truancy
  </td>
  <td class="report_row_data">
     <?php echo $this->_tpl_vars['truancy']; ?>

  </td>
</tr>
<tr>
  <td colspan="2" class="report_results_data">
     Leave
  </td>
  <td class="report_row_data">
     <?php echo $this->_tpl_vars['leave']; ?>

  </td>
</tr>
</table>

















