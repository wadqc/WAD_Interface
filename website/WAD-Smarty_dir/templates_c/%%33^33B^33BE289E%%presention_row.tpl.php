<?php /* Smarty version 2.6.7, created on 2010-01-20 14:04:45
         compiled from presention_row.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'presention_row.tpl', 10, false),)), $this); ?>
<TR <?php echo $this->_tpl_vars['bg_color']; ?>
>
  <td class="table_data">
     <font color="blue"><?php echo $this->_tpl_vars['first_name']; ?>
</font>
  </td>
  <td class="table_data">
     <font color="blue"><?php echo $this->_tpl_vars['last_name']; ?>
</font>
  </td>
  <td class="table_data">
     <select name="<?php echo $this->_tpl_vars['presention_L']; ?>
">
         <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['class_hours'],'selected' => $this->_tpl_vars['presention_L_id']), $this);?>

     </select>
  </td>
  <td class="table_data">
     <select name="<?php echo $this->_tpl_vars['presention_A']; ?>
">
         <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['class_hours'],'selected' => $this->_tpl_vars['presention_A_id']), $this);?>

     </select>
  </td>
  <td class="table_data">
     <select name="<?php echo $this->_tpl_vars['presention_AL']; ?>
">
         <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['class_hours'],'selected' => $this->_tpl_vars['presention_AL_id']), $this);?>

     </select>
  </td>
  <td class="table_data">
     <select name="<?php echo $this->_tpl_vars['presention_S']; ?>
">
         <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['class_hours'],'selected' => $this->_tpl_vars['presention_S_id']), $this);?>

     </select>
  </td>
 <td class="table_data">
     <select name="<?php echo $this->_tpl_vars['presention_H']; ?>
">
         <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['class_hours'],'selected' => $this->_tpl_vars['presention_H_id']), $this);?>

     </select>
  </td>
  <td class="table_data">
     <select name="<?php echo $this->_tpl_vars['presention_M']; ?>
">
         <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['class_hours'],'selected' => $this->_tpl_vars['presention_M_id']), $this);?>

     </select>
  </td>
  <td class="table_data">
     <select name="<?php echo $this->_tpl_vars['presention_LV']; ?>
">
         <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['class_hours'],'selected' => $this->_tpl_vars['presention_LV_id']), $this);?>

     </select>
  </td>
  <td>
    <input name="<?php echo $this->_tpl_vars['presention_comment']; ?>
" type="text" value="<?php echo $this->_tpl_vars['default_comment']; ?>
" size="50" maxlength="200">
  </td>
</tr>
