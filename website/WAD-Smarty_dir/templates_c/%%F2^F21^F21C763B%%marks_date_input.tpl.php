<?php /* Smarty version 2.6.7, created on 2007-06-01 09:43:19
         compiled from marks_date_input.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_select_date', 'marks_date_input.tpl', 2, false),)), $this); ?>
<td <?php echo $this->_tpl_vars['colspan']; ?>
 class="table_data_blue_wrap" width="15">
  <?php echo smarty_function_html_select_date(array('time' => $this->_tpl_vars['time_mark'],'start_year' => $this->_tpl_vars['year_start'],'end_year' => $this->_tpl_vars['year_stop'],'prefix' => $this->_tpl_vars['mark_prefix'],'month_empty' => 'Month','day_empty' => 'Day','year_empty' => 'Year'), $this);?>

</td>