<?php
$requestMethod = $_POST["requestType"];

$requestMethod();

function write(){
    $records = $_POST["records"];
    $recordsFile = fopen("records.json", "w") or die("Unable to open file!");
    
    fwrite($recordsFile, $records);
    fclose($recordsFile);

    echo date('D M d Y H:i:s O', filemtime("records.json"));
}

function read(){
    $file = fopen($_POST["file"], "r") or die("Unable to open file!");
    echo fread($file,filesize($_POST["file"]));
    fclose($file);
}

function lastModified(){
    if (file_exists("records.json")) {
        echo date('D M d Y H:i:s O', filemtime("records.json"));
    }
}

function getTagHref(){
    $tagFile = fopen("tags.json", "r") or die("Unable to open file!");
    $tagFileContent = fread($tagFile,filesize("tags.json"));
    echo $tagFileContent;
}
    
function archiveTag(){
    $previewTag = $_POST["previewTag"];
    $items = $_POST["items"];
    $id = $_POST["id"];
    
    if(file_exists("archive.json")){
        $file = fopen("archive.json", "r") or die("Unable to open file!");
        $archive =  fread($file, filesize("archive.json"));
        fclose($file);
    }else{
        $archive = "[]";
    }
    $json = json_decode($archive,true);  
    array_push($json, $previewTag);
    $json = json_encode($json);
    echo $json;
    $file = fopen("archive.json", "w") or die("Unable to open file!");

    fwrite($file, $json);
    fclose($file);
    if(!file_exists("archive"))
        mkdir("archive");
    $archiveItemFile = fopen("archive\\". $id .".json", "w");
    
    fwrite($archiveItemFile, json_encode($items));
    fclose($archiveItemFile);
}
?>