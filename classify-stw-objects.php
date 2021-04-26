<?php

$dir = "/home/a/Projects/web-scraper/web-scraper/new-scan-the-world-files/";
$files = getFiles($dir);

$fullBodyFiles = fopen("/home/a/Projects/web-scraper/web-scraper/structured-stw-files/full-bodies.csv", "w");
$bustFiles = fopen("/home/a/Projects/web-scraper/web-scraper/structured-stw-files/busts.csv", "w");
$randomFiles = fopen("/home/a/Projects/web-scraper/web-scraper/structured-stw-files/random.csv", "w");

foreach ($files as $file) {
      $filePath = $dir . $file;
      $file = fopen($filePath, "r");
   
      echo "Running for file: {$filePath}";
      while (($line = fgetcsv($file)) !== FALSE) {
        $tags = getTags($line[5]);

        if (in_array("bust", $tags) || in_array("head", $tags) || in_array("figure", $tags)) {
            fwrite($bustFiles, implode(',', $line) . "\n");
            continue;
        }

        if (in_array("sculpture", $tags) || in_array("fullbody", $tags) || in_array("figure", $tags) || in_array("statue", $tags)) {
            fwrite($fullBodyFiles, implode(',', $line) . "\n");
            continue;
        }

        fwrite($randomFiles, implode(',', $line) . "\n");

      }
  fclose($file);
}

fclose($fullBodyFiles);
fclose($bustFiles);
fclose($randomFiles);


function getFiles($dir) {
    $files = scandir($dir); 
    $files = array_diff($files, [".", ".."]);
  
    echo "Total number of updated files needs to equal = 58, actual = " . count($files) . "\n"; 
    return $files;
}

function getTags($tags) {
    $removeChars = ["[", "]", "'", " "];
    $tags = explode(",", str_replace($removeChars, '', $tags));
    
    return $tags;    
}
    
