<?php

# Page to scrape - make this an argument for the script

foreach (range(1, 10) as $pageNum) {

  # Call web scraper API
  $scrapedGoogleImageSearchJSON = file_get_contents_curl("https://api.serpwow.com/live/search?api_key=&q=achilles+statue&search_type=images&images_page={$pageNum}");
  $scrapedGoogleImageSearchFileName = "./google-images-pages-json/google-achilles-page-{$pageNum}.json";
  file_put_contents($scrapedGoogleImageSearchFileName, $scrapedGoogleImageSearchJSON);

  // # Read in saved json file from scraper API
  // $scrapedGoogleImageSearchFileName = "./google-images-pages-json/google-artemis-page-{$pageNum}.json";
  // $scrapedGoogleImageSearchJSON = file_get_csontents($scrapedGoogleImageSearchFileName);

  $decodedSearchResults = json_decode($scrapedGoogleImageSearchJSON, true);
  
  // TODO throw exception when we dont get anymore results

  // # Create array with links to images
  $imageResults = $decodedSearchResults["image_results"];
  foreach ($imageResults as $imageResult) {

    $jpegPos = strpos($imageResult["image"], ".jpg");
    $pngPos = strpos($imageResult["image"], ".png");
    if ($jpegPos !== false || $pngPos !== false) {
      $imageUrls[] = $imageResult["image"];
    }

   
  }

  # Write links to csv file
  $fp = fopen("./image-urls/image-urls-achilles-{$pageNum}.csv", "w");
  fputcsv($fp, $imageUrls, "\n");
  fclose($fp);

  $imageNum = 1; 
  foreach ($imageUrls as $imageUrl) {
  
      
    $data = file_get_contents_curl($imageUrl); 

    $jpegPos = strpos($imageResult["image"], ".jpg");
    $pngPos = strpos($imageResult["image"], ".png");
    if ($pngPos !== false) {
      $fp = "./downloaded-images/achilles-page-{$pageNum}-image-{$imageNum}.png";
    } else {
      $fp = "./downloaded-images/achilles-page-{$pageNum}-image-{$imageNum}.jpg";
    }
  
      
    file_put_contents( $fp, $data ); 
    echo "File downloaded!";
    $imageNum++;
  }
}


function file_get_contents_curl($url) { 
  $ch = curl_init(); 

  curl_setopt($ch, CURLOPT_HEADER, 0); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
  curl_setopt($ch, CURLOPT_URL, $url); 

  $data = curl_exec($ch); 
  curl_close($ch); 

  return $data; 
}  