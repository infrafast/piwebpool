<?php
use GDText\Box;
use GDText\Color;

$img = imagecreatefromjpeg('image.jpg');

$textbox = new Box($img);
$textbox->setFontSize(12);
$textbox->setFontFace('arial.ttf');
$textbox->setFontColor(new Color(0, 0, 0));
$textbox->setBox(
    50,  // distance from left edge
    50,  // distance from top edge
    200, // textbox width
    100  // textbox height
);

// now we have to align the text horizontally and vertically inside the textbox
$textbox->setTextAlign('center', 'top');
// it accepts multiline text
$textbox->draw("This is\na string of text");