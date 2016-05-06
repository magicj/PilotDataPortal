<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php //error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
 // FTP access parameters
$host = 'ftp.pgcsoaring.org';
$usr = 'pgcdoclib';
$pwd = '%stf27b60kts';
$_SESSION['folder_name'] = isset($_POST['pgc_folders']) ? $_POST['pgc_folders'] : false;
$directory = isset($_POST['pgc_folders']) ? $_POST['pgc_folders'] : false;

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
      <td height="481" align="center" bgcolor="#1F3F5F">
      
          <p><span class="JobHeader">
    <?php
      
      if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
  }
else
  {
  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
  echo "Type: " . $_FILES["file"]["type"] . "<br>";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
  echo "Stored in: " . $_FILES["file"]["tmp_name"] . "<br>" ;
  
  }
?>
    <?php
 // file to move:
$local_file = $_FILES["file"]["tmp_name"];
echo $local_file . "<br>";

$ftp_path = '../pgcsoaring/doc_library/' . $directory .'/' . $_FILES["file"]["name"];
//$ftp_path = '../pgcsoaring/doc_library/' . $_FILES["file"]["name"];
 
echo '<br>' .  $_FILES["file"]["name"] .'<br>';
echo "<br>". $ftp_path . "<br>";
 
// connect to FTP server (port 21)
$conn_id = ftp_connect($host, 21) or die ("Cannot connect to host");
 
// send access parameters
ftp_login($conn_id, $usr, $pwd) or die("Cannot login");
 
// turn on passive mode transfers (some servers need this)
// ftp_pasv ($conn_id, true);
 
// perform file upload
// ftp_put($conn,"target.txt","source.txt",FTP_ASCII);
$upload = ftp_put($conn_id, $ftp_path, $local_file, FTP_BINARY);

// upload the file to the path specified
//$upload = ftp_put($conn_id, $paths.'/'.$name, $filep, FTP_BINARY);//
 
// check upload status:
print (!$upload) ? 'Cannot upload' : 'Upload complete';
print "\n";
echo $_SESSION['folder_name'];
 
/*
** Chmod the file (just as example)
*/
 
// If you are using PHP4 then you need to use this code:
// (because the "ftp_chmod" command is just available in PHP5+)
 
// close the FTP stream
ftp_close($conn_id);
?>
        </span></p></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
