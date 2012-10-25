<?php /* Smarty version 2.6.7, created on 2005-05-18 11:27:05
         compiled from report_skill_score.tpl */ ?>
<table width="100%" bgcolor="black">
  <?php echo $this->_tpl_vars['skill_score_header']; ?>

  <tr align="center" valign="center" bgcolor="white">
    <td border="0" width="100%" colspan="<?php echo $this->_tpl_vars['colspan']; ?>
" align="center" valign="center" bgcolor="white">
      <table width="100%" bgcolor="black" >
        <?php echo $this->_tpl_vars['explanation_table_data']; ?>

	  </table>
    </td>
  </tr>
  <tr><?php echo $this->_tpl_vars['row_score']; ?>
</tr>
  <tr><?php echo $this->_tpl_vars['row_score_description']; ?>
</tr>
</table>