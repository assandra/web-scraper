<?php

$imgcreate = imagecreatefrompng('forest.png');
if($imgcreate && imagefilter($imgcreate, IMG_FILTER_GRAYSCALE))
{
    echo 'Grayscale image generated.';
    imagepng($imgcreate, 'forest_gray.png');
}
else
{
    echo 'Grayscale conversion of image failed.';
}
imagedestroy($imgcreate);