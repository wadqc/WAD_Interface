<?php /* Smarty version 2.6.7, created on 2006-05-17 15:30:02
         compiled from skill.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'skill.tpl', 3, false),)), $this); ?>
 <td class="table_data"> <?php echo $this->_tpl_vars['number']; ?>
 </td>
 <td class="table_data"> <?php echo $this->_tpl_vars['name']; ?>
 </td>
 <td class="table_data"> <select name="<?php echo $this->_tpl_vars['score']; ?>
"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['score_options'],'selected' => $this->_tpl_vars['default_score']), $this);?>
 </select></td>
 