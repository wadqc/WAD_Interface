<?php /* Smarty version 2.4.2, created on 2005-02-06 17:39:40
         compiled from presention_row.tpl */ ?>
<TR <?php echo $this->_tpl_vars['bg_color']; ?>
>
  <td>
     <font color="blue"><?php echo $this->_tpl_vars['first_name']; ?>
</font>
  </td>
  <td>
     <font color="blue"><?php echo $this->_tpl_vars['last_name']; ?>
</font>
  </td>
  <td>
   <input type="checkbox" <?php echo $this->_tpl_vars['checked_L']; ?>
 name="<?php echo $this->_tpl_vars['presention_L']; ?>
" value="on">
  </td>
  <td>
   <input type="checkbox" <?php echo $this->_tpl_vars['checked_A']; ?>
 name="<?php echo $this->_tpl_vars['presention_A']; ?>
" value="on">
  </td>
  <td>
   <input type="checkbox" <?php echo $this->_tpl_vars['checked_AL']; ?>
 name="<?php echo $this->_tpl_vars['presention_AL']; ?>
" value="on">
  </td>
  <td>
   <input type="checkbox" <?php echo $this->_tpl_vars['checked_T']; ?>
 name="<?php echo $this->_tpl_vars['presention_T']; ?>
" value="on">
  </td>
  <td>
   <input type="checkbox" <?php echo $this->_tpl_vars['checked_LV']; ?>
 name="<?php echo $this->_tpl_vars['presention_LV']; ?>
" value="on">
  </td>
  <td>
    <input type="text" name="<?php echo $this->_tpl_vars['presention_comment']; ?>
" value="<?php echo $this->_tpl_vars['default_comment']; ?>
" size="50" maxlength="200">
  </td>
</tr>