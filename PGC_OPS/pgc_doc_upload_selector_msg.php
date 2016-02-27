<?php require_once('../Connections/PGC.php'); ?>
<?php 
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 

$PGCmemberName = $_SESSION['MM_PilotName'];
date_default_timezone_set('America/New_York');
$PGCuploadDate = date('Y-m-d H:i:s');
 

// FTP access parameters
$host = 'ftp.pgcsoaring.org';
$usr = 'pgcdoclib';
$pwd = '%stf27b60kts';

if (isset($_POST['pgc_folders'])) {
$_SESSION['folder_name'] = isset($_POST['pgc_folders']) ? $_POST['pgc_folders'] : false;
$directory = isset($_POST['pgc_folders']) ? $_POST['pgc_folders'] : false;
$_POST['target_directory'] = $directory;
}
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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
	text-align: left;
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
.docupload {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: italic;
	font-weight: bold;
	color: #000;
}
.JobHeader1 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bolder;
	color: #FFF;
	font-style: italic;
	text-align: center;
}
.DocButton {	font-family: Verdana, Geneva, sans-serif;
	font-weight: bold;
	text-align: center;
}
-->
</style>
</head>

<body>
<table width="939" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
      <td width="900" height="5" align="center" bgcolor="#294D8D"><p class="JobBanner">PGC DOC LIBRARY UPLOAD</p></td>
  </tr>
    <tr>
      <td height="481" align="center" bgcolor="#1F3F5F">&nbsp;
          <table width="872" height="371" cellpadding="3" cellspacing="3">
              <tr>
                  <td width="763" bgcolor="#3C7591"><table width="860" height="380" align="center" cellpadding="3" cellspacing="3">
                      <tr>
                          <td height="171" align="center" bgcolor="#294D8D"><span class="JobHeader1">
<?php
if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
  }
else
  {
  echo "Uploading: " . $_FILES["file"]["name"] . "<br> <br>";
  $PGCfileName = $_FILES["file"]["name"];
  $PGCfileLink = "/doc_library/". $directory . "/" .$_FILES["file"]["name"];
  echo "Type: " . $_FILES["file"]["type"] . "<br> <br>";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br> <br>";
  }
?>
<?php
// file to move:
$local_file = $_FILES["file"]["tmp_name"];

// Include logic to check file type .... only allow PDF, EXCEL, TXT 
// 

// Include Path to PGC Library 
$ftp_path = '../pgcsoaring/doc_library/' . $directory .'/' . $_FILES["file"]["name"];
$uploadPath = "../pgcsoaring/doc_library/" . $directory . "/";
$ftp_path = 'doc_library/' . $directory .'/' . $_FILES["file"]["name"];
$uploadPath = "doc_library/" . $directory . "/";
echo "Upload Path: " . $uploadPath ."<br>";
echo "Directory: " . $directory ."<br>";
 
// connect to FTP server (port 21)
$conn_id = ftp_connect($host, 21) or die ("Cannot connect to host");
 
// send access parameters
ftp_login($conn_id, $usr, $pwd) or die("Cannot login");
 
// turn on passive mode transfers (some servers need this)
// ftp_pasv ($conn_id, true);
 
// perform file upload
$upload = ftp_put($conn_id, $ftp_path, $local_file, FTP_BINARY);

// check upload status:
print (!$upload) ? 'Cannot upload' : 'Upload complete';

if ($upload) {
echo "<br> <br>" . "UPDATING RECORD INFORMATION <br> <br>";
}
	
if (1 == 1) { 
if ($upload) {
	
	$_POST['date_posted'] = '';
	$_POST['doc_reader'] = '';
	$_POST['doc_display'] = 'YES';
	$_POST['combo_key'] = '';
	$_POST['target_directory'] = $directory;

if (empty($_POST['displayName']) ) {
	$_POST['displayName'] = $PGCfileName;
}
	
$insertSQL = sprintf("INSERT INTO pgc_doc_lib_list (doc_file_name, doc_display_name, doc_category, doc_sub_category, doc_source, doc_posted, date_posted, doc_modified_id, doc_reader, doc_display, doc_path, doc_upload_folder, doc_upload_link, combo_key) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       //GetSQLValueString($_POST['rec_id'], "int"),
                       GetSQLValueString($PGCfileName, "text"),
                       GetSQLValueString($_POST['displayName'], "text"),
                       GetSQLValueString($_POST['pgc_category'], "text"),
                       GetSQLValueString($_POST['pgc_sub_category'], "text"),
                       GetSQLValueString($PGCmemberName, "text"),
                       GetSQLValueString($PGCuploadDate, "date"),
                       GetSQLValueString($_POST['date_posted'], "text"),
                       GetSQLValueString($PGCmemberName, "text"),
                       GetSQLValueString($_POST['doc_reader'], "text"),
                       GetSQLValueString($_POST['doc_display'], "text"),
 			           GetSQLValueString($_POST['target_directory'], "text"),
					   GetSQLValueString($_POST['target_directory'], "text"),
					   GetSQLValueString($PGCfileLink, "text"),
                       GetSQLValueString($_POST['combo_key'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "pgc_docs_menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
}

// close the FTP stream
ftp_close($conn_id);
?>
                          </span></td>
                      </tr>
                  </table></td>
              </tr>
      </table>
          <table width="150" border="1" cellpadding="2" cellspacing="2">
              <tr>
                  <td bgcolor="#3366CC" class="DocButton"><a href="pgc_docs_menu.php" class="DocButton">ADMIN MEMU</a></td>
              </tr>
          </table>
        <p>&nbsp;</p></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
