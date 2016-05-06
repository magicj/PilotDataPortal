<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
print "Calling email test B       "; 
require_once('pgc_email_test_B.php'); 

?>
