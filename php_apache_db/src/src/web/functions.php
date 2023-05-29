<?php
require '../../vendor/autoload.php';
define("WIDTH", 200);
define("HEIGHT", 125);

function get_db()
{
    $mongo = new MongoDB\Client("mongodb://root:password@mongo:27017");

    $db = $mongo->wai;

    return $db;
}
function hidden() {
    $wynik = null;
    if(empty($_SESSION['username'])) {
        $wynik = "hidden";
    }
    return $wynik;
}
function jpgToPng($string) {
    $i = 0;
    while($string[$i] != ".") {
        $i++;
    }
    $string[++$i] = "p";
    $string[++$i] = "n";
    return $string;
}
function zamienNaPng($dir, $name) {
    $path = $dir.$name;
    $name = jpgToPng($name);
    imagepng(imagecreatefromstring(file_get_contents($path)), $dir.$name);
    unlink($path);
}
function utworzMiniature($srcPath, $name, $wtr, $priv) {
    $srcPath = jpgToPng($srcPath);
    $name = jpgToPng($name);
    $size = getimagesize($srcPath);
    $width = $size[0];
    $height = $size[1];
    $filename = $name;
    if ($priv == 1) {
        $dest = "obrazy/".$_SESSION['username']."/watermark/".$filename;
    }
    else $dest = "obrazy/watermark/".$filename;
    $img = imagecreatefrompng($srcPath);
    $file = fopen($dest, "w");
    $color = imagecolorallocate($img, 70, 24, 70);
    imagestring($img, 5, 0, 0, $wtr, $color);
    imagepng($img, $file, null);
    fclose($file);

    $markedPath = $dest;
    if ($priv == 1) {
        $dest = "obrazy/".$_SESSION['username']."/miniaturki/".$filename;
    }
    else $dest = "obrazy/miniaturki/".$filename;
    $img = imagecreatefrompng($markedPath);
    $file = fopen($dest, "w");
    imagepng($img, $file, null);
    $img = imagecreatefrompng($dest);
    $file = fopen($dest, "w");
    $W = WIDTH; $H = HEIGHT;
    if($img) {
        $img = imagescale($img, $W, $H);
        imagepng($img, $file, null);
    }
    else {
        setcookie("miniaturka", 1, time() + 3, "/");
    }
    fclose($file);
    imagedestroy($img);
}
?>