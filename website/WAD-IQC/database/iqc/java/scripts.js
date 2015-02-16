var oldcolor

function TrowOn(src,OnColor,old)
{
  src.style.cursor = 'hand';
  src.bgColor = OnColor;
  oldcolor = old;  
}


function TrowOff(src)
{
  src.style.cursor = 'default';
  src.bgColor = oldcolor;
}

function setfocus()
{
  document.student_id.focus();
  document.student_id.select();
}

function getkey(e)
{
  var code;
  

if (!e) 
  {
    var e = window.event;
  }
  if (e.keyCode) code = e.keyCode;
  else if (e.which) code = e.which;
  return code;
}

function goodchars_mark(e,v,n,row_max,col_max)
{
var key, keychar, goods, r, c, l, row, col, cel, row_int,col_int,field;
goods='0123456789';
key = getkey(e);
if (key == null) return true;
// get character
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();
goods = goods.toLowerCase();

//alert(key);

if ( (key==13)||(key==37)||(key==38)||(key==39)||(key==40) )
{
    
  l=n.length;
  r=n.indexOf('r');
  c=n.indexOf('c');
  
    
  row=n.slice(r+1,c);
  col=n.slice(c+1,l);
  row_int=parseInt(row);  
  col_int=parseInt(col);

  if ((key==13)||(key==40)) //down
  {
    if (row_int<row_max)
    {
      row_int+=1;
    }
  }  
  if (key==38) //up
  {
    if (row_int>0)
    {
      row_int-=1;
    }
  } 
  if (key==37) //left
  {
    if (col_int>0)
    {
      col_int-=1;
    }
  } 
  if (key==39) //right
  {
    if (col_int<col_max)
    {
      col_int+=1;
    }
  } 

  cel='r'+row_int+'c'+col_int;
  
  document.forms[0][cel].focus();
  return false;
}

// control keys
if ( key==null || key==0 || key==8 || key==9 || key==27 || key==46)
   return true;

if(v>=10)
{
  if ((v==10)&&(keychar==0||key==96))
  return true;
  
  // else return false
  alert("maximum value is 100");
  field= document.getElementById('n');
  field.value= '';
  //document.getElementById('n').reset(); 
  return false;
}

// check goodkeys
if (goods.indexOf(keychar) != -1)
	return true;

if ( (key==96)||(key==97)||(key==98)||(key==99)||(key==100)||(key==101)||(key==102)||(key==103)||(key==104)||(key==105) )
{
  return true;
}
// else return false
return false;
}

function goodchars_weight(e)
{
var key, keychar, goods;
goods='0123456789';
key = getkey(e);
if (key == null) return true;
// get character
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();
goods = goods.toLowerCase();

// control keys
if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
   return true;

// check goodkeys
if (goods.indexOf(keychar) != -1)
	return true;

// else return false
return false;
}

function move_selector(e)
{
var key, keychar;

key = getkey(e);
if (key == null) return true;
// get character
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();

if (key==13)
{
  document.forms[0].mark[1029][2].focus();
  return true;
}

}

function enter(e)
{
var key, keychar;

key = getkey(e);
if (key == null) return true;
// get character
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();

if (key==13)
{
  return false;
}
return true;

}

function selector_drop_list(gewenste_processen_id,niveau,status,selector_fk,analyse_level,v) 
{
  action='show_results.php?selector_fk='+selector_fk+'&analyse_level='+analyse_level+'&gewenste_processen_id='+gewenste_processen_id+'&niveau='+niveau+'&status='+status+'&v='+v;
  self.location.replace(action);
}

function processor_status_drop_list(date_filter,status)
{
  action='status-processor.php?date_filter='+date_filter+'&status='+status;
  self.location.replace(action);
}

function selector_status_drop_list(date_filter,status,querystring)
{
  action='status-collector.php?date_filter='+date_filter+'&status='+status+'&'+querystring;
  self.location.replace(action);
}

function dashboard_drop_list(group,querystring)
{
  action='show_dashboard.php?group='+group+'&'+querystring;
  self.location.replace(action);
}
