<?php /* Smarty version 2.6.7, created on 2007-06-01 10:30:09
         compiled from presention_subject_select.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_select_date', 'presention_subject_select.tpl', 31, false),)), $this); ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Attendance General</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#F3F6FF">


<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
 </h1>
<form action=<?php echo $this->_tpl_vars['date_action']; ?>
 method="POST">

<table>
<tr>
  <td align="center" bgcolor="#ff5c30">
    <input type="submit" name="Save" value="Save" class="table_data_blue">
  </td>
  <td colspan="3" align="center" class="table_data">
    <?php echo $this->_tpl_vars['calendar_day']; ?>

  </td>
</tr>
<tr>
  <td align="center" bgcolor="#ff5c30"><input type=button value="Exit" class="table_data_blue" onClick="javascript:window.close();"> </td>
  <td  class="table_data">
   <input type="image" name="down" value="down" src="./buttons/arrow_down.jpg">
  </td>
  <td align="center" bgcolor="#ff5c30">
     <?php echo smarty_function_html_select_date(array('time' => $this->_tpl_vars['presention_date'],'start_year' => $this->_tpl_vars['start_year'],'end_year' => $this->_tpl_vars['end_year'],'prefix' => 'presention_'), $this);?>

     <input type="submit" name="Go" value="Go" class="table_data_blue">&nbsp;
  </td>
  <td  class="table_data">
    <input type="image" name="up" value="up" src="./buttons/arrow_up.jpg">
  </td>
</tr>
</table>

<table border  bgcolor="#f3f6ff" frame="border" NOSAVE>
  <?php echo $this->_tpl_vars['subject_list']; ?>

</table>

</form>


</body>
</html>