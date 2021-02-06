<?php

$row = 1;

if (($handle = fopen("imageProperties.csv", "r")) !== FALSE) {
   
    while (($data = fgetcsv($handle, 10816, "\n")) !== FALSE) {
        $jpegPos = strpos($data[0], "JPEG image data");
        $pngPos = strpos($data[0], "PNG image data");

        if ($pngPos !== false) {
            
          $pngImageFiles[] = substr($data[0], 0, strpos($data[0], ":"));
        } 
       
        else if ($jpegPos === false && $pngPos === false) {
            $corruptedImageFiles[] = substr($data[0], 0, strpos($data[0], ":"));
        }

    }
    fclose($handle);
}

$fp = fopen("./corruptedFiles.txt", "w");
fputcsv($fp, $corruptedImageFiles, "\n");
fclose($fp);

$fp = fopen("./pngFiles.txt", "w");
fputcsv($fp, $pngImageFiles, "\n");
fclose($fp);


# For each file in list
foreach ($pngImageFiles as $pngImageFile) {
    # Find in directory
    if (file_exists($pngImageFile)) {
        var_dump('We shouldnt get here');
        $fileName = substr($pngImageFile, 0, strpos($pngImageFile, ".jpg"));
        $fileNameWithExtension = $fileName . '.png';
        var_dump($fileNameWithExtension);
        rename($pngImageFile, $fileNameWithExtension);
    }

}






// if ($handle = opendir('./downloaded-images')) {
//     while (false !== ($fileName = readdir($handle))) {
//             var_dump($fileName);
//         // foreach ($pngImageFiles as $pngImageFile) {
//         //     $newName = str_replace("SKU#","",$fileName);
//         //     rename($fileName, $newName);
//         // }
       
//     }
//     closedir($handle);
// }