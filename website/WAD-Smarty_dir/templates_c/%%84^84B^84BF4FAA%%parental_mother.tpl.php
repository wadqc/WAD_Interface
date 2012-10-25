<?php /* Smarty version 2.6.7, created on 2007-07-08 12:25:59
         compiled from parental_mother.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'parental_mother.tpl', 39, false),)), $this); ?>
    <table>
	    <tr>
          <td colspan="2" align="center" class="table_data_blue"> Mother </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Firstname </td>
          <td class="table_data">
           <input   name="mother_firstname" type="text" value="<?php echo $this->_tpl_vars['default_mother_firstname']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Middlename </td>
          <td class="table_data">
            <input   name="mother_middlename" type="text" value="<?php echo $this->_tpl_vars['default_mother_middlename']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Lastname </td>
          <td class="table_data">
            <input   name="mother_lastname" type="text" value="<?php echo $this->_tpl_vars['default_mother_lastname']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Profession </td>
          <td class="table_data">
            <input   name="mother_profession" type="text" value="<?php echo $this->_tpl_vars['default_mother_profession']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Home address </td>
          <td class="table_data">
           <input   name="mother_home_address" type="text" value="<?php echo $this->_tpl_vars['default_mother_home_address']; ?>
" size="30"> </input>
          </td>
        </tr>
		<tr>
          <td class="table_data_blue"> District </td>
          <td class="table_data">
            <select name="mother_neighbourhood">
              <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['neighbourhood_options'],'selected' => $this->_tpl_vars['mother_neighbourhood_id']), $this);?>

            </select>
         </td>
		</tr>
        <tr>
          <td class="table_data_blue"> Work address </td>
          <td class="table_data">
            <input   name="mother_work_address" type="text" value="<?php echo $this->_tpl_vars['default_mother_work_address']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Home phone </td>
          <td class="table_data">
            <input   name="mother_home_phone" type="text" value="<?php echo $this->_tpl_vars['default_mother_home_phone']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Work phone </td>
          <td class="table_data">
            <input   name="mother_work_phone" type="text" value="<?php echo $this->_tpl_vars['default_mother_work_phone']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Cell phone </td>
          <td class="table_data">
            <input   name="mother_cell_phone" type="text" value="<?php echo $this->_tpl_vars['default_mother_cell_phone']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Email address </td>
          <td class="table_data">
            <input   name="mother_email_address" type="text" value="<?php echo $this->_tpl_vars['default_mother_email_address']; ?>
" size="30"> </input>
          </td>
        </tr>
     </table>


