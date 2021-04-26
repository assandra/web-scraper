<?php

$imageDir = '/home/a/Projects/dggan-pytorch-2d-images/data/scan-the-world-main-images/images';


$imageFiles = scandir($imageDir);
shuffle($imageFiles);

# Chop list into a training set and a testing set
$training = array_slice($imageFiles, 0, 10000);
$testing = array_slice($imageFiles, 10000, 1004);

# Move all files to the correct folder
foreach ($testing as $imgTest) {

    if ((strpos($imgTest, '.jpg') !== false) || (strpos($imgTest, '.JPG') !== false)) {
        $source = $imageDir . DIRECTORY_SEPARATOR  . $imgTest;
        $des = '/home/a/Projects/dggan-pytorch-2d-images/data/structured-scan-the-world/test/full-bodys/' . $imgTest;
        copy($source, $des);
    }
   
}

# Move all files to the correct folder
foreach ($training as $imgTrain) {

    if ((strpos($imgTrain, '.jpg') !== false) || (strpos($imgTrain, '.JPG') !== false)) {
        $source = $imageDir . DIRECTORY_SEPARATOR . $imgTrain;
        $des = '/home/a/Projects/dggan-pytorch-2d-images/data/structured-scan-the-world/train/full-bodys/' . $imgTrain;
        copy($source, $des);
    }

}

