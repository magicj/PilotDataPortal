<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

define('EST_OFFSET',3*3600);
$Landtime = date("hi",TIME()+EST_OFFSET);

$PGCdate = date("Y-m-d");


$updateSQL = sprintf("Select * FROM pgc_flightsheet");
 
$updateSQL = sprintf("SELECT Pilot1, Count(Glider), Sum(`Time`) FROM pgc_flightsheet WHERE (Pilot1 <> '' OR Pilot2 <> '') AND Glider <> '' GROUP BY Pilot1");
					   
  mysql_select_db($database_PGC, $PGC);
  $result = mysql_query($updateSQL, $PGC) or die(mysql_error());

 /* Create XLS  ================ */ 
 

$tsv  = array();
$html = array();

while($row = mysql_fetch_array($result, MYSQL_NUM))
{
   $tsv[]  = implode("\t", $row);
   $html[] = "<tr><td>" .implode("</td><td>", $row) .              "</td></tr>";
}

$tsv = implode("\r\n", $tsv);
$html = "<table>" . implode("\r\n", $html) . "</table>";

$fileName = $PGCdate."(".$Landtime.")-PGC-Flightsheet.xls";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$fileName");

echo $tsv;
//echo $html;

//include 'library/closedb.php';
?>
