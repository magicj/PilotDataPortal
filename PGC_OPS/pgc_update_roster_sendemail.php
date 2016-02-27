<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
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
// Check Saved and entered values ...
$updateSQL = sprintf("SELECT * FROM pgc_member_roster where customer=%s",
            GetSQLValueString($_SESSION['MM_PilotName'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result3 = mysql_query($updateSQL, $PGC) or die(mysql_error());
  $row_Recordset3 = mysql_fetch_assoc($Result3 );
  $totalRows_Recordset3 = mysql_num_rows($Result3);


$message = " " . $_SESSION['MM_PilotName'] . "\n\n" . " The PDP detected a change to your member roster information as indicated below." . "\n\n". " This information is being forwarded to the PGC Treasurer to update billing system contact information." . "\n\n". " Contact the PGC Webmaster or a PGC BOD member if you did not initiate this action." . "\n\n" . " Data Item          New Value                                      Old Value" ."\r"  . " =========          ==========                                     ==========" ."\n\n";



$made_change = 'no'; 
If ($totalRows_Recordset3 > 0) {

 
$A = 'phone';
$B = 'phone2'; 
If ($row_Recordset3[$A] != $row_Recordset3[$B] ) {
$message = $message . " Home Phone:       " . str_pad($row_Recordset3[$A], 45) . "   " . $row_Recordset3[$B] . "\n\n";
$made_change = 'yes';
 } 
 
$A = 'alt_phone';
$B = 'alt_phone2'; 
If ($row_Recordset3[$A] != $row_Recordset3[$B] ) {
$message = $message . " Work Phone:       " . str_pad($row_Recordset3[$A], 45) . "   " . $row_Recordset3[$B] ."\n\n";
$made_change = 'yes';
 }
 
 
$A = 'cell_number';
$B = 'cell_number2'; 
If ($row_Recordset3[$A] != $row_Recordset3[$B] ) {
$message = $message . " Cell Phone:       " . str_pad($row_Recordset3[$A], 45) . "   ". $row_Recordset3[$B] ."\n\n";
$made_change = 'yes';
 }
 
$A = 'street';
$B = 'street2'; 
If ($row_Recordset3[$A] != $row_Recordset3[$B] ) {
$message = $message . " Street Address:   " . str_pad($row_Recordset3[$A], 45) . "   " . $row_Recordset3[$B] ."\n\n";
$made_change = 'yes';
 }
 
$A = 'city';
$B = 'city2'; 
If ($row_Recordset3[$A] != $row_Recordset3[$B] ) {
$message = $message . " City:             " . str_pad($row_Recordset3[$A], 45) . "   " . $row_Recordset3[$B] ."\n\n";
$made_change = 'yes';
}
 
$A = 'state';
$B = 'state2'; 
If ($row_Recordset3[$A] != $row_Recordset3[$B] ) {
$message = $message . " State:            " . str_pad($row_Recordset3[$A], 45) . "   " . $row_Recordset3[$B] ."\n\n";
$made_change = 'yes';
 }  
 
  
$A = 'zip';
$B = 'zip2'; 
If ($row_Recordset3[$A] != $row_Recordset3[$B] ) {
$message = $message . " Zip Code:         " . str_pad($row_Recordset3[$A], 45) ."   " . $row_Recordset3[$B] ."\n\n";
$made_change = 'yes';
 }

$message = $message . " *** Auto email message from the PGC Pilot Data Portal ***" ; 

 if ($made_change == 'yes') {
		$webmaster = "todd.koch@@verizon.net";
		$treasurer = "Treasurer.PGC@gmail.com";
		
		$to = $treasurer . "," . $webmaster . "," . $_SESSION['MM_Username'];
		    
		$subject = "PGC Change Member Roster Information";
				
	    $email = $_REQUEST['email'];
				
		$headers = "From: PGC Pilot Data Portal";
				
		$sent = mail($to, $subject, $message, $headers) ;
}		
							
		$MM_redirectMailSuccess = "../07_members_only_pw.php";
		header("Location: " . $MM_redirectMailSuccess );
		
		
}
// Clear Values 
$updateSQL = sprintf("UPDATE pgc_member_roster SET customer2='', phone2='', alt_phone2='', street2='', city2='', state2='', zip2='', email2='', customer_type2='', cell_number2='', pgc_start_date2='', glider_license2='' WHERE customer=%s",
                        GetSQLValueString($_SESSION['MM_PilotName'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

//mysql_free_result($updateSQL);

?>
