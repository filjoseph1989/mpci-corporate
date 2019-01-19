<?php
/********************************************************
 * File:        captcha.php                             *
 * Author:      Arvind Gupta (www.arvindgupta.co.in)    *
 * Date:        12-Mar-2009                             *
 * Description: This file can be embedded as image      *
 *              to show CAPTCHA/                        *
 ********************************************************/

# The number of characters you
# want your CAPTCHA text to have
define('CAPTCHA_STRENGTH', 5);

/****************************
 *        INITIALISE        *
 ****************************/
# Tell PHP we're going to use
# Session vars
session_start();

# Md5 to generate the random string
$mpci_random = md5(microtime());

# Trim required number of characters
$captcha_str = substr($mpci_random, 0, CAPTCHA_STRENGTH);

# Allocate new image
$width  = (CAPTCHA_STRENGTH * 10)+10;
$height = 20;

$captcha_img =ImageCreate($width, $height);

# ALLOCATE COLORS
# Background color-black
$back_color = ImageColorAllocate($captcha_img, 0, 0, 0);

# Text color-white
$text_color = ImageColorAllocate($captcha_img, 255, 255, 255);

# Line color-red
$line_color = ImageColorAllocate($captcha_img, 255, 0, 0);

/****************************
 *     DRAW BACKGROUND &    *
 *           LINES          *
 ****************************/
# Fill background color
ImageFill($captcha_img, 0, 0, $back_color);

# Draw lines accross the x-axis
for($i = 0; $i < $width; $i += 5)
    ImageLine($captcha_img, $i, 0, $i, 20, $line_color);

# Draw lines accross the y-axis
for($i = 0; $i < 20; $i += 5)
    ImageLine($captcha_img, 0, $i, $width, $i , $line_color);

/****************************
 *      DRAW AND OUTPUT     *
 *          IMAGE           *
 ****************************/
# Draw the random string
ImageString($captcha_img, 5, 5, 2, $captcha_str, $text_color);

# Carry the data (KEY) through session
$_SESSION['key'] = $captcha_str;

# Output image to browser
ImageJPEG($captcha_img);

# Free-Up resources
ImageDestroy($captcha_img);
# Send data type
header("Content-type: image/jpeg");

?>