<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$_SESSION[last_query] = $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'];


if (isset($_POST['fd_name_sort'])) {
$_SESSION['fd_name_sort'] = $_POST['fd_name_sort'];
} ELSE {
//$_SESSION['fd_role'] = "AFM";
}

//$_SESSION['fd_date_sort'] = 'RECV';
if (isset($_POST['fd_date_sort'])) {
$_SESSION['fd_date_sort'] = $_POST['fd_date_sort'];
} ELSE {
//$_SESSION['fd_date_sort'] = 'RECV';
}

//$_SESSION['fd_role'] = "FM";
if (isset($_POST['fd_role'])) {
$_SESSION['fd_role'] = $_POST['fd_role'];
} ELSE {
//$_SESSION['fd_role'] = "FM";
}

//$_SESSION['fd_session'] = "S1";
if (isset($_POST['fd_session'])) {
$_SESSION['fd_session'] = $_POST['fd_session'];
} ELSE {
//$_SESSION['fd_session'] = "S1";
}
//echo $_SESSION['fd_role'];
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 20;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;


/////

// Update Duty Selection Table - this will add new members - will not update existing records ...
mysql_select_db($database_PGC, $PGC);
$query_fd_selections = "INSERT IGNORE INTO pgc_field_duty_selections (key_check, member_id, member_name, fd_role, session, modified_by)  
SELECT CONCAT(user_id,'Session1'), user_id, name, duty_role, '1', 'Admin Setup' FROM pgc_members WHERE active = 'YES'";
$fd_current_selections1 = mysql_query($query_fd_selections, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$query_fd_selections = "INSERT IGNORE INTO pgc_field_duty_selections (key_check, member_id, member_name, fd_role, session, modified_by)  
SELECT CONCAT(user_id,'Session2'), user_id, name, duty_role, '2', 'Admin Setup' FROM pgc_members WHERE active = 'YES'";
$fd_current_selections2 = mysql_query($query_fd_selections, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$query_fd_selections = "INSERT IGNORE INTO pgc_field_duty_selections (key_check, member_id, member_name, fd_role, session, modified_by)  
SELECT CONCAT(user_id,'Session3'), user_id, name, duty_role, '3', 'Admin Setup' FROM pgc_members WHERE active = 'YES'";
$fd_current_selections3 = mysql_query($query_fd_selections, $PGC) or die(mysql_error());

/* Refresh role */
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "UPDATE pgc_field_duty_selections t1 INNER JOIN pgc_members t2 ON t1.member_id = t2.user_id SET t1.fd_role = t2.duty_role";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());

/* Refresh status to capture new INACTIVE Members */
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "UPDATE pgc_field_duty_selections t1 INNER JOIN pgc_members t2 ON t1.member_id = t2.user_id SET t1.pgc_active = t2.active";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());

/* Refresh modified_date */
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 =  "UPDATE pgc_field_duty_selections SET modified_date = '2030-01-01 01:01:01' WHERE ((choice1 = '' OR choice1 IS NULL) AND (choice2 = '' OR choice2 IS NULL) AND (choice3 = '' OR choice3 IS NULL) AND (date_selected = '' OR date_selected IS NULL))"; 
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());

////

// Total number of times this date was assigned by session and role - FM or AF ...
mysql_select_db($database_PGC, $PGC);
$query_Recordset3 = "UPDATE pgc_field_duty_selections p1 INNER JOIN
(
    SELECT COUNT(date_selected) as count,date_selected, fd_role, session
    FROM pgc_field_duty_selections
    group by session, substring(fd_role,1,2), date_selected
)p2 
SET p1.selected_count=p2.count
WHERE p2.date_selected = p1.date_selected AND substring(p1.fd_role,1,2) = substring(p2.fd_role,1,2) AND p2.session = p1.session";
$Recordset3 = mysql_query($query_Recordset3, $PGC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
 
/////  Update Field Duty Table with Counts
mysql_select_db($database_PGC, $PGC);
$query_Recordset33 = "UPDATE pgc_field_duty SET afm_count = NULL ,fm_count = NULL ";
$Recordset33 = mysql_query($query_Recordset33, $PGC) or die(mysql_error());
$row_Recordset33 = mysql_fetch_assoc($Recordset33);
$totalRows_Recordset33 = mysql_num_rows($Recordset33);


/////  Update Field Duty Table with Counts
mysql_select_db($database_PGC, $PGC);
$query_Recordset33 = "UPDATE pgc_field_duty p1 INNER JOIN
(
    SELECT COUNT(date_selected) as dcount, date_selected, fd_role
    FROM pgc_field_duty_selections
    group by substring(fd_role,1,3), date_selected
)p2 
SET p1.afm_count=p2.dcount
WHERE p2.date_selected = p1.date AND substring(p2.fd_role,1,3) = 'AFM'";
$Recordset33 = mysql_query($query_Recordset33, $PGC) or die(mysql_error());
$row_Recordset33 = mysql_fetch_assoc($Recordset33);
$totalRows_Recordset33 = mysql_num_rows($Recordset33);

mysql_select_db($database_PGC, $PGC);
$query_Recordset33 = "UPDATE pgc_field_duty p1 INNER JOIN
(
    SELECT COUNT(date_selected) as dcount, date_selected, fd_role
    FROM pgc_field_duty_selections
    group by fd_role, date_selected
)p2 
SET p1.fm_count=p2.dcount
WHERE p2.date_selected = p1.date AND substring(p2.fd_role,1,2) = 'FM'";
$Recordset33 = mysql_query($query_Recordset33, $PGC) or die(mysql_error());
$row_Recordset33 = mysql_fetch_assoc($Recordset33);
$totalRows_Recordset33 = mysql_num_rows($Recordset33);

/////

/* Refresh  status for INACTIVE Members */
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "UPDATE pgc_field_duty_selections t1 INNER JOIN pgc_members t2 ON t1.member_id = t2.user_id SET t1.pgc_active = t2.active";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE (fd_role = 'AFM1' or fd_role = 'AFM2') ORDER BY session ASC, modified_date ASC, fd_role ASC";

// DATE SELECTED SORT
if ($_SESSION['fd_date_sort'] == 'RECV') { 
// AFM List
if ($_SESSION['fd_role'] == 'AFM') {
if ($_SESSION['fd_session'] == 'ALL') {
	
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE (fd_role = 'AFM1' or fd_role = 'AFM2'  )ORDER BY session ASC, modified_date ASC, fd_role ASC, pgc_active DESC, member_name ASC";
} elseif ($_SESSION['fd_session'] == 'S1') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '1' AND (fd_role = 'AFM1' or fd_role = 'AFM2'  ) ORDER BY session ASC, modified_date ASC, fd_role ASC, pgc_active DESC, member_name ASC";
    
} elseif ($_SESSION['fd_session'] == 'S2') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '2' AND (fd_role = 'AFM1' or fd_role = 'AFM2'  ) ORDER BY session ASC, modified_date ASC, fd_role ASC, pgc_active DESC, member_name ASC";
    
} elseif ($_SESSION['fd_session'] == 'S3') {
    $query_Recordset1 = "SELECT key_check, member_id,  pgc_active,member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '3' AND (fd_role = 'AFM1' or fd_role = 'AFM2' ) ORDER BY session ASC, modified_date ASC, fd_role ASC, pgc_active DESC, member_name ASC";
}
} // END AFM LIST

// FM LIST
if ($_SESSION['fd_role'] == 'FM')  {
if ($_SESSION['fd_session'] == 'ALL') {
	
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE (fd_role = 'FM1' or fd_role = 'FM2'  )ORDER BY session ASC, modified_date ASC, fd_role ASC, pgc_active DESC, member_name ASC";
} elseif ($_SESSION['fd_session'] == 'S1') {
	
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '1' AND (fd_role = 'FM1' or fd_role = 'FM2'  ) ORDER BY session ASC, modified_date ASC, fd_role ASC, pgc_active DESC, member_name ASC";
    
} elseif ($_SESSION['fd_session'] == 'S2') {
    $query_Recordset1 = "SELECT key_check, member_id,  pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '2' AND (fd_role = 'FM1' or fd_role = 'FM2'  ) ORDER BY session ASC, modified_date ASC, fd_role ASC, pgc_active DESC, member_name ASC";
    
} elseif ($_SESSION['fd_session'] == 'S3') {
    $query_Recordset1 = "SELECT key_check, member_id,  pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '3' AND (fd_role = 'FM1' or fd_role = 'FM2' ) ORDER BY session ASC, modified_date ASC, fd_role ASC, pgc_active DESC, member_name ASC";

}
} // END FM LIST
 
 // ALL / ALL LIST
if ($_SESSION['fd_session'] == 'ALL' && $_SESSION['fd_role'] == 'ALL') {
    $query_Recordset1 = "SELECT key_check, member_id,  pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE (fd_role = 'FM1' or fd_role = 'FM2' or fd_role = 'AFM1' or fd_role = 'AFM2') ORDER BY session ASC, fd_role ASC, modified_date ASC, pgc_active DESC, member_name ASC";
}
} // END DATE SELECTED SORT


// DATE ASSIGNED SORT
if ($_SESSION['fd_date_sort'] == 'ASSN') { 
// AFM List
if ($_SESSION['fd_role'] == 'AFM') {
if ($_SESSION['fd_session'] == 'ALL') {
    $query_Recordset1 = "SELECT key_check, member_id,  pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE (fd_role = 'AFM1' or fd_role = 'AFM2'  )ORDER BY session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
} elseif ($_SESSION['fd_session'] == 'S1') {
    $query_Recordset1 = "SELECT key_check, member_id,  pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '1' AND (fd_role = 'AFM1' or fd_role = 'AFM2'  ) ORDER BY session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
} elseif ($_SESSION['fd_session'] == 'S2') {
    $query_Recordset1 = "SELECT key_check, member_id,  pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '2' AND (fd_role = 'AFM1' or fd_role = 'AFM2'  ) ORDER BY session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
    } elseif ($_SESSION['fd_session'] == 'S3') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '3' AND (fd_role = 'AFM1' or fd_role = 'AFM2' ) ORDER BY session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
}
} // END AFM LIST

// FM LIST
if ($_SESSION['fd_role'] == 'FM')  {
if ($_SESSION['fd_session'] == 'ALL') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE (fd_role = 'FM1' or fd_role = 'FM2')ORDER BY session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
} elseif ($_SESSION['fd_session'] == 'S1') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '1' AND (fd_role = 'FM1' or fd_role = 'FM2') ORDER BY session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
} elseif ($_SESSION['fd_session'] == 'S2') {
    $query_Recordset1 = "SELECT key_check, member_id,  pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '2' AND (fd_role = 'FM1' or fd_role = 'FM2') ORDER BY session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
    } elseif ($_SESSION['fd_session'] == 'S3') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '3' AND (fd_role = 'FM1' or fd_role = 'FM2') ORDER BY session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
}
} // END FM LIST
 
 // ALL / ALL LIST
if ($_SESSION['fd_session'] == 'ALL' && $_SESSION['fd_role'] == 'ALL') {
    $query_Recordset1 = "SELECT key_check, member_id,  pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE (fd_role = 'FM1' or fd_role = 'FM2' or fd_role = 'AFM1' or fd_role = 'AFM2') ORDER BY session ASC, fd_role ASC, date_selected ASC, pgc_active DESC, member_name ASC";
}
} // END DATE SELECTED SORT

// MEMBER NAME SORT
if ($_SESSION['fd_date_sort'] == 'MNAME') { 
// AFM List
if ($_SESSION['fd_role'] == 'AFM') {
if ($_SESSION['fd_session'] == 'ALL') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE (fd_role = 'AFM1' or fd_role = 'AFM2'  )ORDER BY member_name ASC, session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
} elseif ($_SESSION['fd_session'] == 'S1') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '1' AND (fd_role = 'AFM1' or fd_role = 'AFM2'  ) ORDER BY member_name ASC,session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
} elseif ($_SESSION['fd_session'] == 'S2') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '2' AND (fd_role = 'AFM1' or fd_role = 'AFM2'  ) ORDER BY member_name ASC, session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
    } elseif ($_SESSION['fd_session'] == 'S3') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '3' AND (fd_role = 'AFM1' or fd_role = 'AFM2' ) ORDER BY member_name ASC, session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
}
} // END AFM LIST

// FM LIST
if ($_SESSION['fd_role'] == 'FM')  {
if ($_SESSION['fd_session'] == 'ALL') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE (fd_role = 'FM1' or fd_role = 'FM2')ORDER BY member_name ASC, session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
} elseif ($_SESSION['fd_session'] == 'S1') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '1' AND (fd_role = 'FM1' or fd_role = 'FM2') ORDER BY member_name ASC, session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
} elseif ($_SESSION['fd_session'] == 'S2') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '2' AND (fd_role = 'FM1' or fd_role = 'FM2') ORDER BY member_name ASC, session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
    } elseif ($_SESSION['fd_session'] == 'S3') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE `session` = '3' AND (fd_role = 'FM1' or fd_role = 'FM2') ORDER BY member_name ASC, session ASC, date_selected ASC, fd_role ASC, pgc_active DESC, member_name ASC";
}
} // END FM LIST
 
 // ALL / ALL LIST
if ($_SESSION['fd_session'] == 'ALL' && $_SESSION['fd_role'] == 'ALL') {
    $query_Recordset1 = "SELECT key_check, member_id, pgc_active, member_name, fd_role, `session`, choice1, choice2, choice3, modified_date, date_selected, selected_count FROM pgc_field_duty_selections WHERE (fd_role = 'FM1' or fd_role = 'FM2' or fd_role = 'AFM1' or fd_role = 'AFM2') ORDER BY member_name ASC, session ASC, fd_role ASC, date_selected ASC, pgc_active DESC, member_name ASC";
}
} // END MEMBER NAME SORT

$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_SESSION['key_check'])) {
  $colname_Recordset2 = $_SESSION['key_check'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = sprintf("SELECT choice1 FROM pgc_field_duty_selections WHERE key_check = %s UNION SELECT choice2 FROM pgc_field_duty_selections WHERE key_check = %s", GetSQLValueString($colname_Recordset2, "text"),GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_PGC, $PGC);
$query_Recordset3 = "SELECT DISTINCT Count(date_selected), date_selected FROM pgc_field_duty_selections WHERE date_selected <> '' GROUP BY date_selected  ";
$Recordset3 = mysql_query($query_Recordset3, $PGC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
body {
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style16 {
	color: #FFFFFF;
	font-size: 16px;
	font-weight: bold;
}
a:link {
	color: #E6E3DF;
}
a:visited {
	color: #E6E3DF;
}
a:active {
	color: #FFFFCC;
}
.style19 {color: #CCCCCC; font-style: italic; font-weight: bold; }
.style20 {	font-size: 16px;
	font-weight: bold;
	color: #FFCCCC;
}
.style24 {font-size: 16px; font-weight: bold; color: #CCCCCC; }
.style28 {font-size: 12px}
.style23 {font-size: 16px; font-weight: bold; color: #FFCCCC; font-style: italic; }
.style44 {color: #999999;
	font-weight: bold;
}
.style32 {
	font-weight: bold;
	color: #FFFFFF;
	font-size: 14px;
}
.style43 {
	font-size: 18px;
	font-weight: bold;
	color: #FFF;
}
#form1 table tr .style20
{
	color: #FFF;
}
-->
</style></head>

<body>
<p>&nbsp;</p>
<table width="900" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
      <tr>
    <td width="1002"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="190" bgcolor="#3E3E5E"><table width="99%" height="171" border="0" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="25"><div align="center">
              <table width="99%" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                          <td height="93" bgcolor="#333366"><div align="center">
                                <p class="style24">FIELD DUTY - MEMBER REQUESTED / ASSIGNED DUTY DAYS </p>
                                <form id="form1" name="form1" method="post" action="pgc_fd_member_selected_view.php">
                                      <table width="868" align="center" cellpadding="2" cellspacing="0">
                                            <tr>
                                                  <td width="94">&nbsp;</td>
                                                  <td width="94">&nbsp;</td>
                                                  <td width="94"><select name="fd_session" id="fd_session">
                                                        <option value="S1" <?php if (!(strcmp("S1", $_SESSION['fd_session']))) {echo "selected=\"selected\"";} ?>>Session 1</option>
                                                        <option value="S2" <?php if (!(strcmp("S2", $_SESSION['fd_session']))) {echo "selected=\"selected\"";} ?>>Session 2</option>
                                                        <option value="S3" <?php if (!(strcmp("S3", $_SESSION['fd_session']))) {echo "selected=\"selected\"";} ?>>Session 3</option>
                                                        <option value="ALL" <?php if (!(strcmp("ALL", $_SESSION['fd_session']))) {echo "selected=\"selected\"";} ?>>ALL</option>
                                                  </select></td>
                                                  <td width="1" class="style32">&nbsp;</td>
                                                  <td width="155"><select name="fd_role" id="fd_role">
                                                        <option value="AFM" <?php if (!(strcmp("AFM", $_SESSION['fd_role']))) {echo "selected=\"selected\"";} ?>>Asst Field Managers</option>
                                                        <option value="FM" <?php if (!(strcmp("FM", $_SESSION['fd_role']))) {echo "selected=\"selected\"";} ?>>Field Managers</option>
                                                        <option value="ALL" <?php if (!(strcmp("ALL", $_SESSION['fd_role']))) {echo "selected=\"selected\"";} ?>>ALL</option>
                                                  </select></td>
                                                  <td width="1">&nbsp;</td>
                                                  <td width="156"><select name="fd_date_sort" id="fd_date_sort">
                                                        <option value="RECV" <?php if (!(strcmp("RECV", $_SESSION['fd_date_sort']))) {echo "selected=\"selected\"";} ?>>Entered Date / Time</option>
                                                        <option value="ASSN" <?php if (!(strcmp("ASSN", $_SESSION['fd_date_sort']))) {echo "selected=\"selected\"";} ?>>Date Assigned</option>
<option value="MNAME" <?php if (!(strcmp("MNAME", $_SESSION['fd_date_sort']))) {echo "selected=\"selected\"";} ?>>Member Name</option>
                                                  </select></td>
                                                  <td width="1">&nbsp;</td>
                                                  <td width="103"><input type="submit" name="Submit" value="Set Filter" /></td>
                                                  <td width="152" align="center" bgcolor="#333333" class="style16"><a href="pgc_field_duty_list_basic.php">FD SCHEDULE</a></td>
                                                  </tr>
                                </table>
                          </form>
                          </div></td>
                    </tr>
              </table>
        </div></td>
      </tr>
      
      <tr>
        <td height="93" align="center" valign="top"><table border="0" cellpadding="4" cellspacing="2">
              <tr class="style43">
                    <td align="center" valign="middle" bgcolor="#1C2F5B">Member Name</td>
                    <td align="center" valign="middle" bgcolor="#1C2F5B">Active</td>
                    <td align="center" valign="middle" bgcolor="#1C2F5B">Role</td>
                    <td align="center" valign="middle" bgcolor="#1C2F5B">Session</td>
                    <td align="center" valign="middle" bgcolor="#1C2F5B">Choice 1</td>
                    <td align="center" valign="middle" bgcolor="#1C2F5B">Choice 2</td>
                    <td align="center" valign="middle" bgcolor="#1C2F5B">Choice 3</td>
                    <td align="center" valign="middle" bgcolor="#1C2F5B">SET</td>
                    <td align="center" valign="middle" bgcolor="#1C2F5B">Date Assigned</td>
                    <td align="center" valign="middle" bgcolor="#1C2F5B">CNT</td>
                    <td align="center" valign="middle" bgcolor="#1C2F5B">OVER</td>
                    <td align="center" valign="middle" bgcolor="#1C2F5B">Entered  Date / Time</td>
              </tr>
              <?php do { ?>
                    <tr>
                          <td bgcolor="#1E3260"><a href="mailto:<?php echo $row_Recordset1['member_id']; ?>"><?php echo $row_Recordset1['member_name']; ?></a></td>

                          <?php if ($row_Recordset1['pgc_active'] ==  'NO'  )   {?>
                          <td align="center" bgcolor="#FF0000"><?php echo $row_Recordset1['pgc_active']; ?></td>
                          <?php } else { ?>
                          <td align="center" bgcolor="#1E3260"><?php echo $row_Recordset1['pgc_active']; ?></td>
                          <?php } ?>

                          <td align="center" bgcolor="#1E3260"><?php echo $row_Recordset1['fd_role']; ?></td>
                          <td align="center" bgcolor="#27427E"><?php echo $row_Recordset1['session']; ?></td>
                          
                         <?php if ($row_Recordset1['choice1'] == $row_Recordset1['date_selected'] && $row_Recordset1['choice1'] <> '' )   {?>
                          <td bgcolor="#370000"><?php echo $row_Recordset1['choice1']; ?></td>
                         <?php } else { ?>
                           <td bgcolor="#333333"><?php echo $row_Recordset1['choice1']; ?></td>
                         <?php } ?>
                                                
                                                
                          <?php if ($row_Recordset1['choice2'] == $row_Recordset1['date_selected'] && $row_Recordset1['choice1'] <> '' )   {?>
                          <td bgcolor="#370000"><?php echo $row_Recordset1['choice2']; ?></td>
                         <?php } else { ?>
                           <td bgcolor="#333333"><?php echo $row_Recordset1['choice2']; ?></td>
                         <?php } ?>
                                    
                          <?php if ($row_Recordset1['choice3'] == $row_Recordset1['date_selected'] && $row_Recordset1['choice1'] <> '' )   {?>
                          <td bgcolor="#370000"><?php echo $row_Recordset1['choice3']; ?></td>
                         <?php } else { ?>
                           <td bgcolor="#333333"><?php echo $row_Recordset1['choice3']; ?></td>
                         <?php } ?>
                                    
        
                                               
                          
                          <td bgcolor="#5E0000"><a href="pgc_fd_member_selected_edit.php?key_check=<?php echo $row_Recordset1['key_check']; ?>">>>></a></td>
                          
                          <td align="center" bgcolor="#370000"><a href="pgc_field_duty_update_admin.php?dutydate=<?php echo $row_Recordset1['date_selected'] ; ?>"><?php echo $row_Recordset1['date_selected']; ?></a></td>
                          
                          
                        
                              
                          <td width="3" align="center" bgcolor="#27427E"><?php echo $row_Recordset1['selected_count']; ?></td>
                          <td align="center" valign="middle" bgcolor="#5E0000"><a href="pgc_fd_member_selected_overide.php?key_check=<?php echo $row_Recordset1['key_check']; ?>"><<<</a></td>
                          <td bgcolor="#27427E"><?php echo $row_Recordset1['modified_date']; ?></td>
                    </tr>
                    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </table></p>
        <table border="0">
              <tr>
                    <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="First.gif" /></a>
                                <?php } // Show if not first page ?></td>
                    <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="Previous.gif" /></a>
                                <?php } // Show if not first page ?></td>
                    <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="Next.gif" /></a>
                                <?php } // Show if not last page ?></td>
                    <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="Last.gif" /></a>
                                <?php } // Show if not last page ?></td>
              </tr>
        </table></td>
      </tr>
      <tr>
        <td height="33"><div align="center" class="style20">
            <p><a href="pgc_fd_menu.php" class="style16">BACK TO FD MENU</a></p>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
