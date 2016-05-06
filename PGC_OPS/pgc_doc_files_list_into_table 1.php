<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
/*require_once('pgc_check_login.php'); */
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
?>
<?php
    
	// App to identify files in a directory ... to ultimately populate libray table 
	mysql_select_db($database_PGC, $PGC);
    $insertSQL = "TRUNCATE TABLE pgc_doc_lib_list_insert";    
    $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
    // Define the full path to your folder from root 
    $path = "../Forms"; 

    // Open the folder 
    $dir_handle = @opendir($path) or die("Unable to open $path"); 

    // Loop through the files 
    while ($file = readdir($dir_handle)) { 

    if($file == "." || $file == ".." || $file == "index.php" ) 
    continue; 
    echo "<a href=\"$file\">$file</a><br />";  
    $insertSQL = sprintf("INSERT IGNORE INTO pgc_doc_lib_list_insert (doc_file_name, doc_display_name, doc_path) VALUES (%s, %s )",
    GetSQLValueString($file, "text"	),
	GetSQLValueString($file, "text"	),
	GetSQLValueString($path, "text"	)
		);
    $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
 	} 
    // Close 
    closedir($dir_handle); 
   
?>