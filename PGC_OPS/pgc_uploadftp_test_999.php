<?
if(!isset($_POST["submit"])){?>

<form action="pgc_uploadftp_test_999.php" method="POST" enctype="multipart/form-data">
<table align="center">
<tr>
    <td align="right">
        Select your file:
    </td>
    <td>
    <input name="userfile" type="file" size="50">
    </td>
</tr>
</table>
<table align="center">
<tr>
<td align="center">
<input type="submit" name="submit" value="Upload image" />
</td>
</tr>

</table>
</form>
<?}
else 
{
	
set_time_limit(300);//for uploading big files
	
$paths='../pgcsoaring/doc_library';

$filep=$_FILES['userfile']['tmp_name'];

$ftp_server='ftp.pgcsoaring.org';

$ftp_user_name='pgcdoclib';

$ftp_user_pass='%stf27b60kts';

$name=$_FILES['userfile']['name'];



// set up a connection to ftp server
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// check connection and login result
if ((!$conn_id) || (!$login_result)) {
       echo "FTP connection has encountered an error!";
       echo "Attempted to connect to $ftp_server for user $ftp_user_name....";
       exit;
   } else {
       echo "Connected to $ftp_server, for user $ftp_user_name".".....";
   }

// upload the file to the path specified
$upload = ftp_put($conn_id, $paths.'/'.$name, $filep, FTP_BINARY);

// check the upload status
if (!$upload) {
       echo "FTP upload has encountered an error!";
   } else {
       echo "Uploaded file with name $name to $ftp_server ";
   }

// close the FTP connection
ftp_close($conn_id);	

}
?>