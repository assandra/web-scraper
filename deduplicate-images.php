<?php

$fullBodyImages = scandir('/home/a/Projects/dggan-pytorch-2d-images/data/structured-scan-the-world/train/full-bodys/');
$bustBodyImages = scandir('/home/a/Projects/dggan-pytorch-2d-images/data/structured-scan-the-world/train/busts/');

// Read all bust images names in
foreach($bustBodyImages as $bustBodyImage) {
   # var_dump($bustBodyImage);
    foreach($fullBodyImages as $fullBodyImage) {
        if ($bustBodyImage == $fullBodyImage) {
            $filePath = "/home/a/Projects/dggan-pytorch-2d-images/data/structured-scan-the-world/train/full-bodys/" . $bustBodyImage;
            var_dump($bustBodyImage);
           # unlink($filePath);
        }
    }
}
# unlink("/home/a/Projects/dggan-pytorch-2d-images/data/structured-scan-the-world/test/full-bodys/720x720-untitled44.jpg");


  


        // loop through each file in folder 
        // See if one exists already
        // If so, delete it
    



