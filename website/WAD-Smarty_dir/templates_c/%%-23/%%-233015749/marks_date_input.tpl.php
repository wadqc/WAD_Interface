<?php /* Smarty version 2.4.2, created on 2005-02-09 12:20:24
         compiled from marks_date_input.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_select_date', 'marks_date_input.tpl', 2, false),)); ?><td <?php echo $this->_tpl_vars['colspan']; ?>
 class="table_data" width="15">
  <?php echo $this->_plugins['function']['html_select_date'][0](array('time' => $this->_tpl_vars['time_mark'],'start_year' => $this->_tpl_vars['year_start'],'end_year' => $this->_tpl_vars['year_stop'],'prefix' => $this->_tpl_vars['mark_prefix'],'label' => "false"), $this) ; ?>

</td>