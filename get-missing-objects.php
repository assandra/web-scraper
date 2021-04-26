<?php

// Get original urls from scan the world file
$originalFileName = "./additional-files/scan_the_world_objects.csv";
$originalFile = fopen($originalFileName, "r");

while (($line = fgetcsv($originalFile)) !== FALSE) {
    $originalUrls[] = $line[0];
}

fclose($originalFile);

$originalUrlsCount = count($originalUrls);
var_dump("Total number of original urls needs to equal = 4258, actual = {$originalUrlsCount}"); 

// Loop over all updated files 
$updatedFilesDir = "/home/a/Projects/web-scraper/new-scan-the-world-files/";
$updatedFiles = scandir($updatedFilesDir); 
$updatedFiles = array_diff($updatedFiles, [".", ".."]);
$updatedFilesCount = count($updatedFiles);
var_dump("Total number of updated files needs to equal = 58, actual = {$updatedFilesCount}"); 
$results = fopen("missing-object-files.csv", "w");
foreach ($updatedFiles as $file) {

    // Read each file in
    $fileName = $updatedFilesDir . $file;
    $file = fopen($fileName, "r");

    var_dump("CHECKING FOR FILE: {$fileName}");
    while (($line = fgetcsv($file)) !== FALSE) {

        // Get the object url out
        $objectUrl =  $line[1];

        // Check if in array
        if (in_array($objectUrl, $originalUrls)) {
            var_dump("OBJECT ALREADY RECEIVED: {$objectUrl}"); 
        } else {
            // if not add to file
            var_dump("NEW OBJECT: {$objectUrl}");
            fwrite($results, $objectUrl . "\n");
        }
    }

    fclose($file);
}

fclose($results);

