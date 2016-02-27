<?php require_once('../Connections/PGC.php'); 
?>
<?php 
$date = date("Y-m-d") + 1; 
mysql_select_db($database_PGC, $PGC);

$runSQL = "INSERT INTO `pgcsoaringdb`.`pgc_field_duty` (`date`) VALUES ('$date')"; 
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
 ?>

