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
  
  $filename = "pgc_expired_signoffs_" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  $result = mysql_query("SELECT A.pilot_name, A.signoff_type, A.signoff_date, A.expire_date, A.instructor FROM pgc_pilot_signoffs A, pgc_members B WHERE (A.status = 'Expired-A' OR A.status = 'Expired-B') AND (A.pilot_name = B.NAME) AND (B.active = 'YES') ORDER BY A.signoff_type ASC, A.status ASC") or die('Query failed!');
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

