# Get all file
$dir = "tag-classified-busts";
$files = getFiles();



function getFiles($dir) {
    $files = scandir($dir);
    $files = array_diff($files, [".", ".."]);

    return $files;
}