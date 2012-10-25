<?php /* Smarty version 2.6.7, created on 2007-06-01 09:56:43
         compiled from marks_table.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>Grades Table</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
  <script type="text/javascript" language="JavaScript" src="./java/scripts.js"></script>
</head>
<body bgcolor="#f3f6ff" onkeypress="return move_selector(event)">
<h1 class="table_data_blue_header" ><?php echo $this->_tpl_vars['header']; ?>
 Class average: <?php echo $this->_tpl_vars['average']; ?>
</h1>
<form action="<?php echo $this->_tpl_vars['marks_action']; ?>
" method="POST" onkeypress="return move_selector(event)">

<table>
<tr>
  <td align="left" valign="top">
     <table NOSAVE="true" border="true" bgcolor="#f3f6ff" frame="border" >
       <tr style="height:30px"><?php echo $this->_tpl_vars['submit_button']; ?>
<td class="table_data_blue_scroll"><input <?php echo $this->_tpl_vars['checked_new_row']; ?>
 type="checkbox" name="new row" value="on" align="middle">New&nbsp;row</td><td colspan="1" class="table_data_blue_header_scroll"></td></tr>
       <tr style="height:30px"><td class="table_data_blue_scroll" align="center" bgcolor="#ff5c30"> <input class="table_data_blue_scroll" type=button value="Exit" onClick="javascript:window.close();"> <td class="table_data_blue_scroll"><img src="./logo_pictures/print_icon.jpg" align="left" border=0><a href="<?php echo $this->_tpl_vars['print_action']; ?>
" target="_blank" class="table_data_select">print</a></td><td width="6*" class="table_data_blue_scroll"></td></tr>
       <tr style="height:70px"><td colspan="2" class="table_data_blue_header_scroll"></td><td class="table_data_blue_scroll">Date</td></tr>
       <tr style="height:25px"><td colspan="2" class="table_data_blue_header_scroll"></td><td class="table_data_blue_scroll">Weight</td></tr>
       <tr style="height:25px"><td class="table_data_blue_header_scroll">First&nbsp;Name</td><td class="table_data_blue_header_scroll">Last&nbsp;Name</td><td class="table_data_blue_header_scroll">Report</td></tr>
       <?php echo $this->_tpl_vars['student_report_only']; ?>

	 </table>
  </td>
  <td align="left" valign="top">
    <div id="d1" style="width:800px; overflow:scroll;">
      <table NOSAVE="true" border="true" bgcolor="#f3f6ff" frame="border">
        <tr style="height:30px"><?php echo $this->_tpl_vars['description']; ?>
<td row_span="4" class="table_data_blue_header_scroll"></td></tr>
        <tr style="height:30px"><?php echo $this->_tpl_vars['description_input']; ?>
</tr>
        <tr style="height:70px"><?php echo $this->_tpl_vars['date_input']; ?>
</tr>
        <tr style="height:25px"><?php echo $this->_tpl_vars['weigth_input']; ?>
</tr>
        <tr style="height:25px"><?php echo $this->_tpl_vars['mr']; ?>
</tr>
        <?php echo $this->_tpl_vars['student_marks_only']; ?>

	  </table>
   </div>
  </td>
</tr>
</table>

</form>
</body>
</HTML>