<?php /* Smarty version 2.6.7, created on 2005-05-26 12:34:47
         compiled from view_id_card.tpl */ ?>
<table width="100%" border="1">
  <tr>
    <td>


<table width="100%">
  <tr align="left" valign="center">
    <td valign="top">
       <img src="<?php echo $this->_tpl_vars['picture_student']; ?>
" align="top" border="0">
    </td>
	<td valign="top">
      <table>
        <tr>
          <td align="left" class="id_card_header_data"> <?php echo $this->_tpl_vars['id_card_header']; ?>
</td>
        </tr>
	    <tr>
          <td height="1p"> </td>
        </tr>
        <tr>
          <td class="table_data_blue"> <?php echo $this->_tpl_vars['student_firstname']; ?>
 </td>
        </tr>
	    <tr>
          <td class="table_data_blue"> <?php echo $this->_tpl_vars['student_lastname']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> <?php echo $this->_tpl_vars['student_sex']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> <?php echo $this->_tpl_vars['student_date_of_birth']; ?>
</td>
        </tr>
        <tr>
          <td class="table_data_blue"> <?php echo $this->_tpl_vars['student_address']; ?>
 </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top">
      <img src="<?php echo $this->_tpl_vars['picture_barcode']; ?>
" align="left" border="0">
    </td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" class="table_data">
      <?php echo $this->_tpl_vars['barcode']; ?>

    </td>
  </tr>
</table>


    </td>
  </tr>
</table>

