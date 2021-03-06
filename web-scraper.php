<?php

require __DIR__ . '/vendor/autoload.php';
use simplehtmldom\HtmlWeb;

$client = new HtmlWeb();

# TODO: make this a cli application which takes filename as an option
$fileName = "./additional-files/scan_the_world_objects.csv";
$file = fopen($fileName, "r");

while (($line = fgetcsv($file)) !== FALSE) {
    $urls[] = $line[0];
}

fclose($file);

foreach ($urls as $url) {
    $html = $client->load($url);
    
    if ($html === null) {
        echo ("Could not download images from url: {$url}\n");
        continue;
    }
    
    $numImagesDownloaded = 0;
    foreach($html->find('img[class=prdimg-gallery]') as $element) {
        $imageUrl = $element->src;
        $originalImageUrl = str_replace("/70X70-", "/720X720-", $imageUrl);
        $downloadedImage = request($originalImageUrl); 

        $startImageNamePos = strpos($originalImageUrl, "/720X720-");
        $originalImageName = "720x720-" . substr($originalImageUrl, $startImageNamePos  + 9);
        $imageName = "./scan-the-world-images/{$originalImageName}";
     
        file_put_contents($imageName, $downloadedImage); 
        $numImagesDownloaded++;
    }
    echo("All images from url: {$url} downloaded. Total images: {$numImagesDownloaded} \n");
}

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

