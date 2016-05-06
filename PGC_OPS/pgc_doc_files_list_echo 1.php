<?php

    // Define the full path to your folder from root 
    $path = "../doc_library/"; 

    // Open the folder 
    $dir_handle = @opendir($path) or die("Unable to open $path"); 

    // Loop through the files 
    while ($file = readdir($dir_handle)) { 

    if($file == "." || $file == ".." || $file == "index.php" ) 

        continue; 
/*        echo "<a href=\"$file\">$file</a><br />";  */
		echo $file ."<br />"; 

    } 
    // Close 
    closedir($dir_handle); 
?>