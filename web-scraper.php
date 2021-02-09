<?php

require __DIR__ . '/vendor/autoload.php';

use simplehtmldom\HtmlWeb;

$client = new HtmlWeb();

$file = fopen("./additional-files/scan_the_world_objects.csv", "r");

while (($line = fgetcsv($file)) !== FALSE) {
    $urls[] = $line[0];
}

fclose($file);

foreach ($urls as $url) {

    $html = $client->load($url);
 
    $numImagesDownloaded = 0;
    foreach($html->find('img[class=prdimg-gallery]') as $element) {
       

        $imageUrl = $element->src;
        $originalImageUrl = str_replace("/70X70-", "/720X720-", $imageUrl);
        $startImageNamePos = strpos($originalImageUrl, "/720X720-");
        $originalImageName = "720x720-" . substr($originalImageUrl, $startImageNamePos  + 9);

        
        $downloadedImage = request($originalImageUrl); 
  
        $image = "./scan-the-world-images/{$originalImageName}";
     
        file_put_contents($image, $downloadedImage); 
        $numImagesDownloaded++;
    }
    echo("All images from url: {$url} downloaded. Total images: {$numImagesDownloaded} \n");
}





function request($url) { 
    $ch = curl_init(); 
  
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_URL, $url); 
  
    $data = curl_exec($ch); 
    curl_close($ch); 
  
    return $data; 
  }  

