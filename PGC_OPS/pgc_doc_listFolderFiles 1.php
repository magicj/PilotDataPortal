<?php
function pgc_doc_listFolderFiles($dir){
    $ffs = scandir($dir);
    echo '<ol>';
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..' && $ff != '_notes'){
            echo '<li>'.$ff;
            if(is_dir($dir.'/'.$ff)) pgc_doc_listFolderFiles($dir.'/'.$ff);
            echo '</li>';
        }
    }
    echo '</ol>';
}

pgc_doc_listFolderFiles("../doc_library/");
?>