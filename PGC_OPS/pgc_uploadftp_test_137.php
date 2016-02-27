<?php
 // FTP access parameters
$host = 'ftp.pgcsoaring.org';
$usr = 'pgcdoclib';
$pwd = '%stf27b60kts';


 // file to move:
$local_file = '1mailtest.php';
$ftp_path = '../pgcsoaring/doc_library/1mailtest.php';
 
// connect to FTP server (port 21)
$conn_id = ftp_connect($host, 21) or die ("Cannot connect to host");
 
// send access parameters
ftp_login($conn_id, $usr, $pwd) or die("Cannot login");
 
// turn on passive mode transfers (some servers need this)
// ftp_pasv ($conn_id, true);
 
// perform file upload
// ftp_put($conn,"target.txt","source.txt",FTP_ASCII);
$upload = ftp_put($conn_id, $ftp_path, $local_file, FTP_ASCII);

// upload the file to the path specified
//$upload = ftp_put($conn_id, $paths.'/'.$name, $filep, FTP_BINARY);//
 
// check upload status:
print (!$upload) ? 'Cannot upload' : 'Upload complete';
print "\n";
 
/*
** Chmod the file (just as example)
*/
 
// If you are using PHP4 then you need to use this code:
// (because the "ftp_chmod" command is just available in PHP5+)
 
// close the FTP stream
ftp_close($conn_id);

?>