<?php /* Smarty version 2.6.7, created on 2007-06-01 10:25:21
         compiled from parental_fmg.tpl */ ?>
    <table>
	    <tr bgcolor="#B8E7FF">
          <td class="table_data_blue"></td>
          <td class="table_data_blue"> Father</td>
		  <td class="table_data_blue"> Mother</td>
		  <td class="table_data_blue"> Guardian <?php echo $this->_tpl_vars['guardian_relation']; ?>
</td>
        </tr>
        <tr bgcolor="#B8E7FF">
          <td class="table_data_blue"> Firstname </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['father_firstname']; ?>
</td>
		  <td class="table_data"> <?php echo $this->_tpl_vars['mother_firstname']; ?>
</td>
		  <td class="table_data"> <?php echo $this->_tpl_vars['guardian_firstname']; ?>
</td>
        </tr>
        <tr>
          <td class="table_data_blue"> Middlename </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['father_middlename']; ?>
</td>
		  <td class="table_data"> <?php echo $this->_tpl_vars['mother_middlename']; ?>
</td>
		  <td class="table_data"> <?php echo $this->_tpl_vars['guardian_middlename']; ?>
</td>
        </tr>
        <tr bgcolor="#B8E7FF">
          <td class="table_data_blue"> Lastname </td>
          <td class="table_data"><?php echo $this->_tpl_vars['father_lastname']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['mother_lastname']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['guardian_lastname']; ?>
</td>
        </tr>
        <tr>
          <td class="table_data_blue"> Profession </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['father_profession']; ?>
</td>
		  <td class="table_data"> <?php echo $this->_tpl_vars['mother_profession']; ?>
</td>
		  <td class="table_data"> <?php echo $this->_tpl_vars['guardian_profession']; ?>
</td>
        </tr>
        <tr bgcolor="#B8E7FF">
          <td class="table_data_blue"> Home address </td>
          <td class="table_data"><?php echo $this->_tpl_vars['father_home_address']; ?>
 </td>
		  <td class="table_data"><?php echo $this->_tpl_vars['mother_home_address']; ?>
 </td>
		  <td class="table_data"><?php echo $this->_tpl_vars['guardian_home_address']; ?>
 </td>
        </tr>
		<tr>
          <td class="table_data_blue"> District </td>
          <td class="table_data"><?php echo $this->_tpl_vars['father_neighbourhood']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['mother_neighbourhood']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['guardian_neighbourhood']; ?>
</td>
        </tr>
        <tr bgcolor="#B8E7FF">
          <td class="table_data_blue"> Work address </td>
          <td class="table_data"><?php echo $this->_tpl_vars['father_work_address']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['mother_work_address']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['guardian_work_address']; ?>
</td>
        </tr>
        <tr>
          <td class="table_data_blue"> Home phone </td>
          <td class="table_data"><?php echo $this->_tpl_vars['father_home_phone']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['mother_home_phone']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['guardian_home_phone']; ?>
</td>
        </tr>
        <tr bgcolor="#B8E7FF">
          <td class="table_data_blue"> Work phone </td>
          <td class="table_data"><?php echo $this->_tpl_vars['father_work_phone']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['mother_work_phone']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['guardian_work_phone']; ?>
</td>
        </tr>
        <tr>
          <td class="table_data_blue"> Cell phone </td>
          <td class="table_data"><?php echo $this->_tpl_vars['father_cell_phone']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['mother_cell_phone']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['guardian_cell_phone']; ?>
</td>
        </tr>
        <tr bgcolor="#B8E7FF">
          <td class="table_data_blue"> Email address </td>
          <td class="table_data"><?php echo $this->_tpl_vars['father_email_address']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['mother_email_address']; ?>
</td>
		  <td class="table_data"><?php echo $this->_tpl_vars['guardian_email_address']; ?>
</td>
        </tr>
        <tr bgcolor="#c8c8c8">
          <td class="table_data"></td>
		  <td class="table_data_blue"> Siblings </td>
		  <td class="table_data_blue"> Siblings </td>
		  <td class="table_data_blue"> Siblings </td>
        </tr>
		<tr>
          <td class="table_data_blue"></td>
          <td align="left" valign="top" class="table_data">
             <table>
               <?php echo $this->_tpl_vars['father_siblings']; ?>

			 </table>
          </td>
          <td align="left" valign="top" class="table_data">
             <table>
               <?php echo $this->_tpl_vars['mother_siblings']; ?>

			 </table>
          </td>
          <td align="left" valign="top" class="table_data">
             <table>
               <?php echo $this->_tpl_vars['guardian_siblings']; ?>

			 </table>
          </td>
        </tr>



     </table>


