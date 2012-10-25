<?php /* Smarty version 2.6.7, created on 2007-06-03 11:31:54
         compiled from score_select.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Skills</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#F3F6FF">
<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
 </h1>
<form action="<?php echo $this->_tpl_vars['action']; ?>
" method="POST">

<table>
<tr>
  <td align="center" bgcolor="#ff5c30">
    <input type="submit" name="Save" value="Save" class="table_data_blue">
  </td>
</tr>
<tr>
  <td align="center" bgcolor="#ff5c30">
    <input type=button value="Exit" class="table_data_blue" onClick="javascript:window.close();">
   </td>
</tr>
</table>



<table>
  <tbody>
    <tr>
      <td>
	    <table border bgcolor="#f3f6ff" frame="border" NOSAVE>
          <?php echo $this->_tpl_vars['subject_list']; ?>

        </table>
      </td>
      <td width="50pixel">  </td>
      <td align="right" valign="top">
	    <table border bgcolor="#f3f6ff" frame="border" NOSAVE>
          <?php echo $this->_tpl_vars['explenation_list']; ?>

        </table>
     </td>
	 <td align="right" valign="top">
	    <table border bgcolor="#f3f6ff" frame="border" NOSAVE>
          <?php echo $this->_tpl_vars['explenation_list_score']; ?>

        </table>
     </td>
    </tr>
  </tbody>
</table>


</form>






</body>
</html>