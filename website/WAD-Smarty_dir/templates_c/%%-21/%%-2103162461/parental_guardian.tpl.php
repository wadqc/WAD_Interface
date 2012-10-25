<?php /* Smarty version 2.4.2, created on 2005-02-04 19:52:31
         compiled from parental_guardian.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'parental_guardian.tpl', 9, false),)); ?>    <table>
	    <tr>
          <td colspan="2" align="right" class="table_data_blue"> Guardian </td>
        </tr>
        <tr>
          <td class="table_data_blue">Relation to Student</td>
          <td class="table_data">
            <select name="relation">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['relation_to_student_options'],'selected' => $this->_tpl_vars['relation_to_student_id']), $this) ; ?>

            </select>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Firstname </td>
          <td class="table_data">
           <input   name="guardian_firstname" type="text" value="<?php echo $this->_tpl_vars['default_guardian_firstname']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Middlename </td>
          <td class="table_data">
            <input   name="guardian_middlename" type="text" value="<?php echo $this->_tpl_vars['default_guardian_middlename']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Lastname </td>
          <td class="table_data">
            <input   name="guardian_lastname" type="text" value="<?php echo $this->_tpl_vars['default_guardian_lastname']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Profession </td>
          <td class="table_data">
            <input   name="guardian_profession" type="text" value="<?php echo $this->_tpl_vars['default_guardian_profession']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Home address </td>
          <td class="table_data">
           <input   name="guardian_home_address" type="text" value="<?php echo $this->_tpl_vars['default_guardian_home_address']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Work address </td>
          <td class="table_data">
            <input   name="guardian_work_address" type="text" value="<?php echo $this->_tpl_vars['default_guardian_work_address']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Neighbourhood </td>
          <td class="table_data">
            <input   name="guardian_neighbourhood" type="text" value="<?php echo $this->_tpl_vars['default_guardian_neighbourhood']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Home phone </td>
          <td class="table_data">
            <input   name="guardian_home_phone" type="text" value="<?php echo $this->_tpl_vars['default_guardian_home_phone']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Work phone </td>
          <td class="table_data">
            <input   name="guardian_work_phone" type="text" value="<?php echo $this->_tpl_vars['default_guardian_work_phone']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Cell phone </td>
          <td class="table_data">
            <input   name="guardian_cell_phone" type="text" value="<?php echo $this->_tpl_vars['default_guardian_cell_phone']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Email address </td>
          <td class="table_data">
            <input   name="guardian_email_address" type="text" value="<?php echo $this->_tpl_vars['default_guardian_email_address']; ?>
" size="30"> </input>
          </td>
        </tr>
     </table>


