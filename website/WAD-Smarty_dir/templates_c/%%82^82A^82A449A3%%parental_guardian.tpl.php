<?php /* Smarty version 2.6.7, created on 2007-07-08 12:31:05
         compiled from parental_guardian.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'parental_guardian.tpl', 9, false),)), $this); ?>
    <table>
	    <tr>
          <td colspan="2" align="right" class="table_data_blue"> Guardian </td>
        </tr>
        <tr>
          <td class="table_data_blue">Relation to Student</td>
          <td class="table_data">
            <select name="relation">
              <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['relation_to_student_options'],'selected' => $this->_tpl_vars['relation_to_student_id']), $this);?>

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
          <td class="table_data_blue"> District </td>
          <td class="table_data">
            <select name="guardian_neighbourhood">
              <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['neighbourhood_options'],'selected' => $this->_tpl_vars['guardian_neighbourhood_id']), $this);?>

            </select>
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


