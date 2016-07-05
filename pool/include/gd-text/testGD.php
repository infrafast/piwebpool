<?php

require "src/Box.php";
require "src/Color.php";
require "src/TextWrapping.php";
require "src/HorizontalAlignment.php";
require "src/VerticalAlignment.php";

use GDText\Box;
use GDText\Color;
$im = imagecreatetruecolor(500, 500);
$backgroundColor = imagecolorallocate($im, 0, 18, 64);
imagefill($im, 0, 0, $backgroundColor);

$box = new Box($im);
$box->setFontFace('arial.ttf'); // http://www.dafont.com/pacifico.font
$box->setFontSize(80);
$box->setFontColor([255, 255, 255]);
$box->setTextShadow([0, 0, 0, 50], 0, -2);
$box->setLeading(0.7);
$box->setBox(20, 20, 460, 460);
$box->setTextAlign('center', 'center');
$box->draw("Pacifico");

header("Content-type: image/png");
imagepng($im);