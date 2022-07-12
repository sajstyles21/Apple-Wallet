<?php
 $zip = new ZipArchive;  
 $res = $zip->open('Apple-Wallet.zip');  
 if ($res === TRUE) {  
     $zip->extractTo('/');  
     $zip->close();  
     echo 'ok';  
 } else {  
     echo 'failed';  
 }  
