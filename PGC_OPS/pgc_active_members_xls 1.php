<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>

<?php

/* Sync roster table up with member table - i.e. add new members  */
$insertSQL = "INSERT IGNORE INTO pgc_member_roster(customer)Select NAME FROM pgc_members";
$ResultA = mysql_query($insertSQL, $PGC) or die(mysql_error());
/* Refresh E-mail address in roster table */   
$updateSQL = "UPDATE pgc_member_roster A, pgc_members B SET A.email = B.USER_ID, A.active = B.active WHERE A.customer = B.NAME";
$ResultB = mysql_query($updateSQL, $PGC) or die(mysql_error());
?>
<?php

   function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  mysql_select_db($database_PGC, $PGC);
  
  $filename = "pgc_active_member_roster_" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  $result = mysql_query("SELECT customer, phone, alt_phone, street, city, `state`, zip, email, customer_type, cell_number FROM pgc_member_roster WHERE active = 'YES' ORDER BY customer ASC") or die('Query failed!');
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

