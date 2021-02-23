<?php

$fileName = "./additional-files/reduced_scan_the_world_objects.csv";
$file = fopen($fileName, "r");

while (($line = fgetcsv($file)) !== FALSE) {
    $objectUrl = $line[1];
    $object = request($objectUrl);

    $startObjectNamePos = strrpos($objectUrl, "/");
    $objectName = substr($objectUrl, $startObjectNamePos  + 1);
    $objectName = "./scan-the-world-objects/{$objectName}";
 
    file_put_contents($objectName, $object); 
}

fclose($file);


# TODO: move out to a trait
function request($url) { 
    $ch = curl_init(); 
  
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_URL, $url); 
  
    $data = curl_exec($ch); 
    curl_close($ch); 
  
    return $data; 
  }  
