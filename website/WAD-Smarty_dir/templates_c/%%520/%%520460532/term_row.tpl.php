<?php /* Smarty version 2.4.2, created on 2005-02-06 17:42:01
         compiled from term_row.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_select_date', 'term_row.tpl', 4, false),)); ?>  <tr>
    <td> <input type="checkbox" <?php echo $this->_tpl_vars['checked']; ?>
 name="<?php echo $this->_tpl_vars['term']; ?>
" value="on"> </td>
	<td class="table_data"><?php echo $this->_tpl_vars['term_name']; ?>
 </td>
    <td class="table_data">  <?php echo $this->_plugins['function']['html_select_date'][0](array('time' => $this->_tpl_vars['start_date'],'start_year' => $this->_tpl_vars['start_year'],'end_year' => $this->_tpl_vars['end_year'],'prefix' => $this->_tpl_vars['start_prefix'],'label' => "false"), $this) ; ?>
  </td>
    <td class="table_data">  <?php echo $this->_plugins['function']['html_select_date'][0](array('time' => $this->_tpl_vars['stop_date'],'start_year' => $this->_tpl_vars['start_year'],'end_year' => $this->_tpl_vars['end_year'],'prefix' => $this->_tpl_vars['stop_prefix'],'label' => "false"), $this) ; ?>
  </td>
  </tr>