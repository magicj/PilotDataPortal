<?php require_once('../Connections/PGC.php'); ?>
<?php
   function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  mysql_select_db($database_PGC, $PGC);
  
  $filename = "pgc_tow_pilot_duty_" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  $result = mysql_query("SELECT date_format(date,'%m/%d/%y') as `Date`, date_format(date,'%W') as `Day Of Week`, tp1 as `AM Tow pilot`, tp2 as `PM Towpilot`  FROM pgc_field_duty ORDER BY `Date` ASC") or die('Query failed!');
  while(false !== ($row = mysql_fetch_assoc($result))) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    array_walk($row, 'cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }
  exit;
?>

