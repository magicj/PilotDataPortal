<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
 
mysql_select_db($database_PGC, $PGC);


$query = "SELECT USER_ID, NAME FROM pgc_members WHERE active = 'YES'";

$result = mysql_query($query) or die('Error, query failed');

$tsv  = array();
$html = array();

while($row = mysql_fetch_array($result, MYSQL_NUM))
{
   $tsv[]  = implode(";\t", $row);
   $html[] = "<tr><td>" .implode("</td><td>", $row) .              "</td></tr>";
}

$tsv = implode("\r\n", $tsv);
$html = "<table>" . implode("\r\n", $html) . "</table>";

$fileName = 'PGC-ACTIVE-EMAIL-LIST.xls';
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$fileName");

echo $tsv;
//echo $html;

//include 'library/closedb.php';
?>
