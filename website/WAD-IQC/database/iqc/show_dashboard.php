<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



// group : 0=ongegroepeerd, 1=categorie, 2=modaliteit, 3=lokatie
if (!empty($_GET['group']))
{
  $group=$_GET['group'];
} elseif (!empty($_POST['group']))
{
  $group=$_POST['group'];
} else
{
  $group = 0;
}


if (!empty($_GET['categorie_fk']))
{
  $categorie=$_GET['categorie_fk'];
} else {
  $categorie = 0;
}

if (!empty($_GET['modaliteit']))
{
  $modaliteit=$_GET['modaliteit'];
} else {
  $modaliteit = '';
}

if (!empty($_GET['lokatie']))
{
  $lokatie=$_GET['lokatie'];
} else {
  $lokatie = '';
}


$table_selector='selector';
$table_selector_categorie='selector_categorie';
$table_gewenste_processen='gewenste_processen';

$table_study='study';
$table_series='series';
$table_instance='instance';
$table_resultaten_floating='resultaten_floating';
$table_resultaten_char='resultaten_char';
$table_resultaten_boolean='resultaten_boolean';
$table_resultaten_object='resultaten_object';
$table_gewenste_processen='gewenste_processen';
$table_selector='selector';
$table_resultaten_status='resultaten_status';



$v=$_GET['v'];


$selector_Stmt="select $table_selector.*,g.creation_time,sc.omschrijving as categorie
                from $table_selector
                left join
                  selector_categorie sc
                on $table_selector.selector_categorie_fk=sc.pk
                left join
                  (select * from $table_gewenste_processen where status=5 order by pk desc) g
                on $table_selector.pk=g.selector_fk where 1=1 %s group by $table_selector.pk";


$subquery_category = "and $table_selector.selector_categorie_fk=%s";
$subquery_modality = "and $table_selector.modaliteit='%s'";
$subquery_location = "and $table_selector.lokatie='%s'";


$selector_category_Stmt="select sc.*,g.creation_time
                from $table_selector_categorie sc
                left join $table_selector s
                   on sc.pk=s.selector_categorie_fk
                left join
                  (select * from gewenste_processen where status=5 order by pk desc) g
                on s.pk=g.selector_fk
                group by sc.pk
                order by sc.omschrijving";

$selector_modality_Stmt="select modaliteit,max(g.creation_time) as creation_time
                from $table_selector s
                left join
                  (select * from $table_gewenste_processen where status=5 order by pk desc) g
                on s.pk=g.selector_fk
                where modaliteit > ''
                group by modaliteit
                order by modaliteit";

$selector_location_Stmt="select lokatie,max(creation_time) as creation_time
                from $table_selector s
                left join
                  (select * from $table_gewenste_processen where status=5 order by pk desc) g
                on s.pk=g.selector_fk
                where lokatie > ''
                group by lokatie
                order by lokatie";



// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


$subquery=array();
if($categorie>0) {
  array_push($subquery,sprintf($subquery_category,$categorie));
};
if($modaliteit!='') {
  array_push($subquery,sprintf($subquery_modality,$modaliteit));
};
if($lokatie!='') {
  array_push($subquery,sprintf($subquery_location,$lokatie));
};
$subquery_str=implode(" and ",$subquery);


switch ($group) {
    case 0: // ongegroepeerd
        $query=sprintf($selector_Stmt,$subquery_str);
        break;
    case 1: // gegroepeerd op categorie
        $query=sprintf($selector_category_Stmt);
        break;
    case 2: // gegroepeerd op modaliteit
        $query=sprintf($selector_modality_Stmt);
        break;
    case 3: // gegroepeerd op lokatie
        $query=sprintf($selector_location_Stmt);
        break;
}

if (!($result_selector= $link->query($query))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $query)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}


$GET=$_GET;
// haal group uit GET-string, en geef overige GET-variabelen door
unset($GET['group']);
$querystring = http_build_query($GET, '', '&');



$table_data = new Smarty_NM();
$table_data->assign("group_options",$groups_list);
$table_data->assign("group_select",$group);
$table_data->assign("querystring",$querystring);
$dashboard_filter=$table_data->fetch("dashboard_filter.tpl");



switch ($group) {
    case 0:
        $table_selector=''; 

        $status=5;

        $j=0;
        while (($field_selector = $result_selector->fetch_object()))
        {
           $qc_status = -1;
           $selectoren = array($field_selector->pk);
           if(!empty($selectoren)) {
              $gewenste_processen = gewenste_processen($link,$selectoren);
              if(!empty($gewenste_processen)) {
                 $qc_status = qc_status($link,$gewenste_processen);
              }
           }

           $b=($j%2);
           $bgcolor=''; 
           if ($b==0)
           {
             $bgcolor='#B8E7FF';
           }

           $table_data = new Smarty_NM();

           if ($j==0) //define header data
           {
             $table_selector=$table_data->fetch("dashboard_header.tpl");
           }

           $action=sprintf("show_results.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=-1&status=$status&v=$v&t=%d",$field_selector->pk,$field_selector->analyselevel,time()); 

           $table_data->assign("bgcolor",$bgcolor);
           $table_data->assign("selector",$field_selector->name);
           $table_data->assign("description",$field_selector->description);
           $table_data->assign("category",$field_selector->categorie);
           $table_data->assign("modality",$field_selector->modaliteit);
           $table_data->assign("location",$field_selector->lokatie);
           $table_data->assign("datetime",$field_selector->creation_time);
           $status_array = check_status($qc_status);
           $table_data->assign("status_img",$status_array['img']);
           $table_data->assign("status_txt",$status_array['txt']);

           $days_since_last_qc=(strtotime(date(now))-strtotime($field_selector->creation_time))/(60*60*24);
           if(!empty($gewenste_processen)) {
              if($days_since_last_qc>$field_selector->qc_frequentie) {
                 $table_data->assign("qc_frequency",round($days_since_last_qc-$field_selector->qc_frequentie)." dagen te laat");
                 $table_data->assign("waarde_class","table_data_red");
              } else {
                 $table_data->assign("qc_frequency","ok");
                 $table_data->assign("waarde_class","table_data_green");
              }
           }

           $table_data->assign("action_selector",$action);

           $table_selector.=$table_data->fetch("dashboard_row.tpl");

           $j++;
        }
        break;
    case 1:
        $table_selector=''; 

        $status=5;

        $j=0;
        while (($field_category = $result_selector->fetch_object()))
        {
           $qc_status = -1;
           $qc_freq_status = true;
           $gewenste_processen = array();
           $selectoren = selectors($link,$group,$field_category->pk);
           if(!empty($selectoren)) {
              $gewenste_processen = gewenste_processen($link,$selectoren);
              if(!empty($gewenste_processen)) {
                 $qc_status = qc_status($link,$gewenste_processen);
                 $qc_freq_status = check_qc_frequency($link,$gewenste_processen);
              }
           }

           $b=($j%2);
           $bgcolor=''; 
           if ($b==0)
           {
             $bgcolor='#B8E7FF';
           }

           $table_data = new Smarty_NM();

           if ($j==0) //define header data
           {
             $table_selector=$table_data->fetch("dashboard_header_category.tpl");
           }

           $action=sprintf("show_dashboard.php?group=0&categorie_fk=%d",$field_category->pk);

           $table_data->assign("bgcolor",$bgcolor);
           $table_data->assign("category",$field_category->omschrijving);
           $table_data->assign("datetime",$field_category->creation_time);
           $status_array = check_status($qc_status);
           $table_data->assign("status_img",$status_array['img']);
           $table_data->assign("status_txt",$status_array['txt']);

           if(!empty($gewenste_processen)) {
              if(!$qc_freq_status) {
                 $table_data->assign("qc_frequency","1 of meerdere qc's te laat");
                 $table_data->assign("waarde_class","table_data_red");
              } else {
                 $table_data->assign("qc_frequency","ok");
                 $table_data->assign("waarde_class","table_data_green");
              }
           }

           $table_data->assign("action_category",$action);

           $table_selector.=$table_data->fetch("dashboard_row_category.tpl");

           $j++;
        }
        break;
    case 2:
        $table_selector=''; 

        $status=5;

        $j=0;
        while (($field_modality = $result_selector->fetch_object()))
        {
           $qc_status = -1;
           $qc_freq_status = true;
           $gewenste_processen = array();
           $selectoren = selectors($link,$group,$field_modality->modaliteit);
           if(!empty($selectoren)) {
              $gewenste_processen = gewenste_processen($link,$selectoren);
              if(!empty($gewenste_processen)) {
                 $qc_status = qc_status($link,$gewenste_processen);
                 $qc_freq_status = check_qc_frequency($link,$gewenste_processen);
              }
           }

           $b=($j%2);
           $bgcolor=''; 
           if ($b==0)
           {
             $bgcolor='#B8E7FF';
           }

           $table_data = new Smarty_NM();

           if ($j==0) //define header data
           {
             $table_selector=$table_data->fetch("dashboard_header_modality.tpl");
           }

           $action=sprintf("show_dashboard.php?group=0&modaliteit=%s",$field_modality->modaliteit);

           $table_data->assign("bgcolor",$bgcolor);
           $table_data->assign("modality",$field_modality->modaliteit);
           $table_data->assign("datetime",$field_modality->creation_time);
           $status_array = check_status($qc_status);
           $table_data->assign("status_img",$status_array['img']);
           $table_data->assign("status_txt",$status_array['txt']);

           if(!empty($gewenste_processen)) {
              if(!$qc_freq_status) {
                 $table_data->assign("qc_frequency","1 of meerdere qc's te laat");
                   $table_data->assign("waarde_class","table_data_red");
            } else {
                 $table_data->assign("qc_frequency","ok");
                 $table_data->assign("waarde_class","table_data_green");
              }
           }

           $table_data->assign("action_modality",$action);

           $table_selector.=$table_data->fetch("dashboard_row_modality.tpl");

           $j++;
        }
        break;
    case 3:
        $table_selector=''; 

        $status=5;

        $j=0;
        while (($field_location = $result_selector->fetch_object()))
        {
           $qc_status = -1;
           $qc_freq_status = true;
           $gewenste_processen = array();
           $selectoren = selectors($link,$group,$field_location->lokatie);
           if(!empty($selectoren)) {
              $gewenste_processen = gewenste_processen($link,$selectoren);
              if(!empty($gewenste_processen)) {
                 $qc_status = qc_status($link,$gewenste_processen);
                 $qc_freq_status = check_qc_frequency($link,$gewenste_processen);
              }
           }

           $b=($j%2);
           $bgcolor=''; 
           if ($b==0)
           {
             $bgcolor='#B8E7FF';
           }

           $table_data = new Smarty_NM();

           if ($j==0) //define header data
           {
             $table_selector=$table_data->fetch("dashboard_header_location.tpl");
           }

           $action=sprintf("show_dashboard.php?group=0&lokatie=%s",$field_location->lokatie);

           $table_data->assign("bgcolor",$bgcolor);
           $table_data->assign("location",$field_location->lokatie);
           $table_data->assign("datetime",$field_location->creation_time);
           $status_array = check_status($qc_status);
           $table_data->assign("status_img",$status_array['img']);
           $table_data->assign("status_txt",$status_array['txt']);

           if(!empty($gewenste_processen)) {
              if(!$qc_freq_status) {
                 $table_data->assign("qc_frequency","1 of meerdere qc's te laat");
                 $table_data->assign("waarde_class","table_data_red");
              } else {
                 $table_data->assign("qc_frequency","ok");
                 $table_data->assign("waarde_class","table_data_green");
              }
           }

           $table_data->assign("action_location",$action);

           $table_selector.=$table_data->fetch("dashboard_row_location.tpl");

           $j++;
        }
        break;
}





$result_selector->close();  

$data = new Smarty_NM();
$data->assign("Title","Results dashboard");
$data->assign("header","");
$data->assign("dashboard_filter",$dashboard_filter);
$data->assign("selector_list",$table_selector);

$data->display("dashboard.tpl");





function selectors($link,$group,$item) {

   $selectorlist = array();

   switch($group) {
      case 1:
         // group = 1: categorie
         $query = "select pk from selector where selector_categorie_fk=$item";
         break;
      case 2:
         // group = 2: modaliteit
         $query = "select pk from selector where modaliteit='$item'";
         break;
      case 3:
         // group = 3: lokatie
         $query = "select pk from selector where lokatie='$item'";
         break;
   }

   if (!($result=$link->query($query))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $query)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
   }

   while ($field = $result->fetch_object()) {
      if($field->pk>0) {
         array_push($selectorlist,$field->pk);
      }
   }

   return $selectorlist;

}


function gewenste_processen($link,$selectorarray) {

   // voorkom query-fout wanneer selectorarray leeg is.
   if(empty($selectorarray)) {
      return -1;
   }

   $selectorlist = implode(",",$selectorarray);

   $query = "select g.pk
             from selector s
             left join
                (select * from gewenste_processen where status=5 order by pk desc) g
             on s.pk=g.selector_fk where s.pk in ($selectorlist) group by s.pk";

   if (!($result=$link->query($query))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $query)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
   }

   $gewenste_processen = array();
   while ($field = $result->fetch_object()) {
      if($field->pk>0) {
         array_push($gewenste_processen,$field->pk);
      }
   }

   return $gewenste_processen;
}


function qc_status($link,$gewenste_processen_array) {

   if(empty($gewenste_processen_array)) {
      return -1;
   }

   $gewenste_processen = implode(",",$gewenste_processen_array);

   // check eerst alle float waarden
   $query = "SELECT * from gewenste_processen inner join resultaten_floating on gewenste_processen.pk=resultaten_floating.gewenste_processen_fk 
             where
             gewenste_processen.pk in ($gewenste_processen)";

   if (!($result=$link->query($query))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $query)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
   }

   $status = 0;
   // status flags:
   // 0 = acceptabel / groen
   // 1 = boven acceptabel, onder kritisch --> warning / oranje
   // 2 = boven kritisch --> error / rood

   while ($field = $result->fetch_object()) {
      if ( ( ($field->waarde > $field->grens_acceptabel_boven)
           || ($field->waarde < $field->grens_acceptabel_onder))
           && ($field->grens_acceptabel_boven!='') 
           && ($field->grens_acceptabel_onder!='') ) {
         $status = $status | 1;
      };
      if ( ( ($field->waarde > $field->grens_kritisch_boven)
           || ($field->waarde < $field->grens_kritisch_onder))
           && ($field->grens_kritisch_boven!='') 
           && ($field->grens_kritisch_onder!='') ) {
         $status = $status | 2;
         break;
      };
   }


   // check vervolgens alle booleans
   // FIXME: criterium nog niet geimplementeerd


   // check tenslotte alle chars
   $query = "SELECT * from gewenste_processen inner join resultaten_char on gewenste_processen.pk=resultaten_char.gewenste_processen_fk 
             where
             gewenste_processen.pk in ($gewenste_processen)";

   if (!($result=$link->query($query))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $query)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
   }

   while ($field = $result->fetch_object()) {
      if ( ($field->waarde != $field->criterium) && ($field->criterium != '') ) {
         $status = $status | 2;
         break;
      };
   }

   return $status;
}


function check_status($status) {
      $status_array = array();
      $status_array['img'] = 'empty.png';
      $status_array['txt'] = 'niet van toepassing';
      switch($status) {
          case -1:
              break;
          case 0:
              $status_array['img'] = "green.png";
              $status_array['txt'] = "acceptabel";
              break;
          case 1:
              $status_array['img'] = "yellow.png";
              $status_array['txt'] = "waarschuwing";
              break;
          case 2:  // fout
          case 3:  // waarschuwing + fout
              $status_array['img'] = "red.png";
              $status_array['txt'] = "fout";
              break;
      }
      return $status_array;
}


function check_qc_frequency($link,$gewenste_processen_array) {

   if(empty($gewenste_processen_array)) {
      return -1;
   }

   $gewenste_processen = implode(",",$gewenste_processen_array);

   $query = "SELECT creation_time,qc_frequentie from gewenste_processen 
             inner join selector on gewenste_processen.selector_fk=selector.pk
             where gewenste_processen.pk in ($gewenste_processen)";

   if (!($result=$link->query($query))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $query)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
   }

   $qc_freq_status = true;
   while ($field = $result->fetch_object()) {
      if( (strtotime(date(now))-strtotime($field->creation_time))/(60*60*24) > $field->qc_frequentie) {
         $qc_freq_status = false;
      }
   }

   return $qc_freq_status;
}



?>
