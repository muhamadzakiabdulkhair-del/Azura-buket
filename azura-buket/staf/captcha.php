<?php
session_start();

$karakter = 'abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
$captcha = '';

for ($i = 0; $i < 4; $i++) {
    $captcha .= $karakter[rand(0, strlen($karakter) - 1)];
}

$_SESSION['captcha'] = $captcha;

header('Content-type: image/png');

$image = imagecreate(120, 40);
$bg = imagecolorallocate($image, 255, 240, 244);       // pink blush
$textcolor = imagecolorallocate($image, 192, 57, 94);  // pink brand

imagestring($image, 5, 30, 10, $captcha, $textcolor);

imagepng($image);
imagedestroy($image);
?>
