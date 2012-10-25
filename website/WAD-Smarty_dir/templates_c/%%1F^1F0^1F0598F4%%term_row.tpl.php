<?php /* Smarty version 2.6.7, created on 2007-06-11 06:34:51
         compiled from term_row.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_select_date', 'term_row.tpl', 4, false),)), $this); ?>
  <tr>
    <td> <input type="checkbox" <?php echo $this->_tpl_vars['checked_term']; ?>
 name="<?php echo $this->_tpl_vars['term']; ?>
" value="on"> </td>
	<td class="table_data"><?php echo $this->_tpl_vars['term_name']; ?>
 </td>
    <td class="table_data">  <?php echo smarty_function_html_select_date(array('time' => $this->_tpl_vars['start_date'],'start_year' => $this->_tpl_vars['start_year'],'end_year' => $this->_tpl_vars['end_year'],'prefix' => $this->_tpl_vars['start_prefix'],'month_empty' => 'Month','day_empty' => 'Day','year_empty' => 'Year'), $this);?>
  </td>
    <td class="table_data">  <?php echo smarty_function_html_select_date(array('time' => $this->_tpl_vars['stop_date'],'start_year' => $this->_tpl_vars['start_year'],'end_year' => $this->_tpl_vars['end_year'],'prefix' => $this->_tpl_vars['stop_prefix'],'month_empty' => 'Month','day_empty' => 'Day','year_empty' => 'Year'), $this);?>
  </td>
    <td> <input type="checkbox" <?php echo $this->_tpl_vars['checked_lock']; ?>
 name="<?php echo $this->_tpl_vars['lock']; ?>
" value="on"> </td>
  </tr>