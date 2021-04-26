<?php

# Get all file from source dir
$sourceDir = "/home/a/Projects/web-scraper/web-scraper/fullbody";
$files = getFiles($sourceDir);
$numOfFiles = count($files);
echo "Total number of updated files needs to equal = 13708, actual = {$numOfFiles}";
die();

# Make target dirs
$targetDir = "base-dir";
$numOfDirs = intdiv(count($files),500) + 1;

foreach (range(1, $numOfDirs) as $dirName) {
    mkdir($base . $dirName);
}

echo "Do assertion on directories created here";

// Copy files from source to target
$filesToMove = [];
$dirName = 1;
foreach ($file as $files) {
    $filesToMove[] = $file;

    if (count($filesToMove) === 500) {
        $source = $sourceDir . $file; 
        $target = $targetDir . str($dirName) . $file;
        copy($source, $target);

        $dirName++;
        $filesToMove = [];
    }
}
    
echo "Do assertion on images in directories total and final one";

function getFiles($dir) {
    $files = scandir($dir);
    $files = array_diff($files, [".", ".."]);

    return $files;
}