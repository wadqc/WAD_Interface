<?php /* Smarty version 2.6.7, created on 2012-06-09 21:19:49
         compiled from file_new.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title><?php echo $this->_tpl_vars['title']; ?>
</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
</h1>

<form enctype="multipart/form-data" action="<?php echo $this->_tpl_vars['action_new_file']; ?>
" method="POST" >
<table>
  <tr>
    <td class="table_data_blue"> description</td>
    <td class="table_data">
         <input   name="description" type="text" value="<?php echo $this->_tpl_vars['default_description']; ?>
" size="30"> </input>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> filename </td>
    <td class="table_data">
         <?php echo $this->_tpl_vars['default_filename']; ?>

    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> filename pad </td>
    <td class="table_data">
         <input type="hidden" name="MAX_FILE_SIZE" value="1000000000" ></input><input name="uploadedfile" type="file" size="30"></input>

    </td>
  </tr>
</table>
<input type="submit" name="action" value="<?php echo $this->_tpl_vars['submit_value']; ?>
">


</form>
</body>
</HTML>


