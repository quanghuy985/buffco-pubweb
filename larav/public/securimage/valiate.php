<?php

$captcha = @$_GET['ct_captcha']; // the user's entry for the captcha code

require_once dirname(__FILE__) . '/securimage.php';
$securimage = new Securimage();

if ($securimage->check($captcha) == false) {
    echo 'FALSE';
} else {
    echo 'TRUE';
}
?>
