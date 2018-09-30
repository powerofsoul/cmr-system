<?php
$requestType = $_POST["requestType"];
if($requestType == "write"){
    $records = $_POST["records"];
    echo $records;
    $recordsFile = fopen("records.json", "w") or die("Unable to open file!");
    
    fwrite($recordsFile, $records);
    fclose($recordsFile);

    echo date('D M d Y H:i:s O', filemtime("records.json"));
}
else if($requestType == "read"){
    $file = fopen("records.json", "r") or die("Unable to open file!");
    echo fread($file,filesize("records.json"));
    fclose($file);
}
else if($requestType == "lastModified"){
    if (file_exists("records.json")) {
        echo date('D M d Y H:i:s O', filemtime("records.json"));
    }
}
?>