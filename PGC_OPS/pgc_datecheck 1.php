<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php $_SESSION['$Logdate'] = date("Y-m-d");
echo date_default_timezone_get();
echo date("Y-m-d") . '     '.  date("h:i:sa") . '        ';
 
date_default_timezone_set('America/New_York');
echo date_default_timezone_get();
echo date("Y-m-d") . '     '.  date("h:i:sa");

 ?>
 

 date("h:i:sa");

 