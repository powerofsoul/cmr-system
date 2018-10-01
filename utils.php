<?php
$requestType = $_GET["requestType"];
if($requestType == "write"){
    $records = $_GET["records"];
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
}else if($requestType == "getTagHref"){
    $tagFile = fopen("tags.json", "r") or die("Unable to open file!");
    $tagFileContent = fread($tagFile,filesize("tags.json"));
    echo $tagFileContent;
}else if($requestType == "writeTag"){
    $file = fopen("tags.json", "r") or die("Unable to open file!");
    $tags =  fread($file, filesize("tags.json"));
    fclose($file);

    $json = json_decode($tags,true);  
    $json[$_GET["tagName"]] = $_GET["tagValue"];
    $json = json_encode($json);
    
    $file = fopen("tags.json", "w") or die("Unable to open file!");
    
    fwrite($file, $json);
    fclose($file);
}
?>