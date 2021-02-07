<?php

require __DIR__ . '/vendor/autoload.php';

# Load API key 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$apiKey = $_ENV["SERPwOW_API_KEY"];

# Parameters 
$god = 'hephaestus';
$startPageNum = 1;
$endPageNum = 5;

foreach (range($startPageNum, $endPageNum) as $pageNum) {

  # Call web scraper API
  $response = request("https://api.serpwow.com/live/search?api_key={$apiKey}&q={$god}+statue&search_type=images&images_page={$pageNum}");
  
  # Save response
  $responseFile = "./google-images-pages-json/google-{$god}-page-{$pageNum}.json";
  file_put_contents($responseFile, $response);

  # Optional - load response from responseFile
  # $responseFile= "./google-images-pages-json/google-{$god}-page-{$pageNum}.json";
  # $response = file_get_contents($responseFile);

  $decodedResponse = json_decode($response, true);
  
  // TODO throw exception when we dont get anymore results

  # Find all image URLs from response 
  $images = $decodedResponse["image_results"];
  
  foreach ($images as $image) {

    $jpgExtPos = strpos($image["image"], ".jpg");
    $pngExtPos = strpos($image["image"], ".png");

    if ($jpgExtPos !== false || $pngExtPos !== false) {
      $imageUrls[] = $image["image"];
    }
  }

  # Save image URLs
  $urlsFileName = "./image-urls/image-urls-{$god}-{$pageNum}.csv";
  $filePath = fopen($urlsFileName, "w");
  fputcsv($filePath, $imageUrls, "\n");
  fclose($filePath);

  # Download images
  $imageNum = 1; 
  foreach ($imageUrls as $imageUrl) {

    $downloadedImage = request($imageUrl); 

    $jpgExtPos = strpos($imageUrl, ".jpg");
    $pngExtPos = strpos($imageUrl, ".png");
    
    if ($pngExtPos !== false) {
      $file = "./downloaded-images/{$god}-page-{$pageNum}-image-{$imageNum}.png";
    } else {
      $file = "./downloaded-images/{$god}-page-{$pageNum}-image-{$imageNum}.jpg";
    }
  
      
    file_put_contents($file, $downloadedImage); 
    echo "File downloaded!";
    $imageNum++;
  }
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