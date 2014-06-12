<?php

$tblStt = new \BackEnd\tblSettingModel();
$allsett = $tblStt->getSetting();
$cauhinhwebsite = unserialize($allsett->settingValue);
return array(
    'title-website' => $cauhinhwebsite['titlewebsite'],
    'meta-tag' => $cauhinhwebsite['tagline'],
    'meta-description' => $cauhinhwebsite['description'],
    'meta-keywordsearch' => $cauhinhwebsite['keywordsearch'],
    'mail-smtp' => $cauhinhwebsite['smtphost'],
    'mail-port' => $cauhinhwebsite['smtpport'],
    'mail-frommail' => $cauhinhwebsite['frommail'],
    'mail-fromname' => $cauhinhwebsite['fromname'],
    'mail-usernamemail' => $cauhinhwebsite['usernamemail'],
    'mail-passwordmail' => $cauhinhwebsite['passwordmail'],
    'pay-baokimuser' => $cauhinhwebsite['baokimuser'],
    'pay-nganluonguser' => $cauhinhwebsite['nganluonguser'],
    'pay-tiente' => $cauhinhwebsite['tiente'],
    'logowebsite' => $cauhinhwebsite['logowebsite'],
    'footer' => $cauhinhwebsite['footer'],
    'tencongty' => $cauhinhwebsite['tencongty'],
    'diachicongty' => $cauhinhwebsite['diachicongty'],
    'sodienthoaicongty' => $cauhinhwebsite['sodienthoaicongty'],
    'sodienthoaiddcongty' => $cauhinhwebsite['sodienthoaiddcongty'],
    'emailcongty' => $cauhinhwebsite['emailcongty'],
    'webcongty' => $cauhinhwebsite['webcongty'],
    'facebookfanpage' => $cauhinhwebsite['facebookfanpage'],
    'commentfb' => $cauhinhwebsite['commentfb'],
    'google-analytics' => $cauhinhwebsite['googleanc'],
    'google-maps' => $cauhinhwebsite['googlemaps'],
    'img-slider' => $cauhinhwebsite['slideimg'],
    'menu-header' => $cauhinhwebsite['menuheader'],
    'alll' => Auth::user()->id
);
