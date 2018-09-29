<?php
$records = $_POST["records"];
echo $records;
$recordsFile = fopen("records.txt", "w") or die("Unable to open file!");
 
fwrite($recordsFile, $records);
fclose($recordsFile);
?>