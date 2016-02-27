<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
$MemberName = $_SESSION['MM_PilotName'];
date_default_timezone_set('America/New_York');
$date = date('Y-m-d H:i:s');
 
require_once('pgc_check_login.php');  
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}

 	// App to identify library folders
	mysql_select_db($database_PGC, $PGC);
    $insertSQL = "TRUNCATE TABLE pgc_doc_lib_folders";    
    $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
	
    // Define the full path to your folder from root 
    $path = "../doc_library/"; 

    // Open the folder 
    $dir_handle = @opendir($path) or die("Unable to open $path"); 

    // Loop through the files 
    while ($file = readdir($dir_handle)) { 

    if($file == "." || $file == ".." || $file == "index.php" ) 

        continue; 
/*        echo "<a href=\"$file\">$file</a><br />";  */
//		echo $file ."<br />"; 
		
   $insertSQL = sprintf("INSERT IGNORE INTO pgc_doc_lib_folders (folder_name) VALUES (%s)",
	GetSQLValueString($file, "text"	));
    $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

    } 
    // Close 
    closedir($dir_handle); 

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_doc_lib_folders ORDER BY folder_name ASC";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Document Library</title>
<style type="text/css">
<!--
body {
	background-color: #262E4A;
	text-align: center;
	color: #314F73;
}
a:link {
	color: #FFFF9B;
}
a:visited {
	color: #FFFF9B;
}

.JobHeader {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bolder;
	color: #FFF;
	font-style: italic;
	text-align: center;
}
.JobBanner {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	color: #FFF;
}
.JobGrid {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #FFF;
	background-color: #666666;
	text-align: left;
	text-transform: capitalize;
}
.JobLine {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #FFF;
}
.navbox {
	background-color: #525874;
	border-top-style: outset;
	border-right-style: outset;
	border-bottom-style: outset;
	border-left-style: outset;
	border-top-color: #999;
	border-right-color: #999;
	border-bottom-color: #999;
	border-left-color: #999;
}
-->
</style>
</head>

<body>
<table width="939" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
      <td width="900" height="5" align="center" bgcolor="#880000"><p class="JobBanner">PGC DOC LIBRARY UPLOAD</p></td>
  </tr>
    <tr>
      <td height="481" align="center" bgcolor="#1F3F5F">&nbsp;
          <table width="872" height="371" cellpadding="3" cellspacing="3">
              <tr>
                  <td width="763" bgcolor="#3C7591"><table width="860" height="380" align="center" cellpadding="3" cellspacing="3">
                      <tr>
                          <td height="171" align="center" bgcolor="#294D8D"><form action="pgc_doc_upload_selector_msg_test.php" method="post"
enctype="multipart/form-data">
                              <table width="372" height="37" align="center" cellpadding="2" cellspacing="2">
                                  <tr>
                                      <td height="31" align="center" bgcolor="#3366CC"><span class="JobHeader">BROWSE / SELECT PC FILE TO UPLOAD</span></td>
                                  </tr>
                          </table>
                              <p class="JobBanner">
                                  <input name="file" type="file" id="file" size="120" />
                              </p>
                              <table width="372" height="37" align="center" cellpadding="2" cellspacing="2">
                                  <tr>
                                      <td height="31" align="center" bgcolor="#3366CC"><span class="JobHeader">SELECT  PGC DOCUMENT LIBRARY FOLDER </span></td>
                                  </tr>
                              </table>
                              <p>
                                  <label for="pgc_folders"></label>
                                  <select name="pgc_folders" id="pgc_folders">
                                      <?php
do {  

?>
                                      <option value="<?php echo $row_Recordset1['folder_name']?>"<?php if (!(strcmp($row_Recordset1['folder_name'], $row_Recordset1['']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['folder_name']?></option>
                                      <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                                  </select>
                                  <br />
                                  <br />
                                  <input type="submit" name="submit" value="PGCfolders" />
                          </p>
                          <?php echo $SESSION['folder_name'] = $POST['pgc_folders']; ?>
                          </form>
                              &nbsp;</td>
                      </tr>
                  </table></td>
              </tr>
      </table>
        <p>&nbsp;</p></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
