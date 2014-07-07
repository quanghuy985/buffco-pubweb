<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SettingController extends \BaseController {

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('checkrole');
    }

    public function postUpdateSetting() {
        $paramseting = array(
            'titlewebsite' => \Input::get('titlewebsite'),
            'tagline' => \Input::get('tagline'),
            'description' => \Input::get('description'),
            'keywordsearch' => \Input::get('keywordsearch'),
            'smtphost' => \Input::get('smtphost'),
            'smtpport' => \Input::get('smtpport'),
            'frommail' => \Input::get('frommail'),
            'fromname' => \Input::get('fromname'),
            'usernamemail' => \Input::get('usernamemail'),
            'passwordmail' => \Input::get('passwordmail'),
            'baokimuser' => \Input::get('baokimuser'),
            'nganluonguser' => \Input::get('nganluonguser'),
            'tiente' => \Input::get('tiente'),
            'logowebsite' => \Input::get('logowebsite'),
            'footer' => \Input::get('footer'),
            'tencongty' => \Input::get('tencongty'),
            'diachicongty' => \Input::get('diachicongty'),
            'sodienthoaicongty' => \Input::get('sodienthoaicongty'),
            'sodienthoaiddcongty' => \Input::get('sodienthoaiddcongty'),
            'emailcongty' => \Input::get('emailcongty'),
            'webcongty' => \Input::get('webcongty'),
            'facebookfanpage' => \Input::get('facebookfanpage'),
            'commentfb' => \Input::get('commentfb'),
            'googleanc' => \Input::get('googleanc'),
            'googlemaps' => \Input::get('googlemaps'),
            'slideimg' => \Input::get('slideimg'),
            'menuheader' => \Input::get('menuheader'),
        );
        $tblSettingModel = new tblSettingModel();
        $check = $tblSettingModel->saveSetting(serialize($paramseting));
        return \Redirect::action('\BackEnd\SettingController@getUpdateSetting');
    }

    public function getUpdateSetting() {
        $tblSettingModel = new \BackEnd\tblSettingModel();
        $arrSetting = $tblSettingModel->getSetting();
        $arrSetting = unserialize($arrSetting->settingValue);
        $tblMenu = new \BackEnd\Menu();
        $arrGroupMenu = $tblMenu->get_menu_groups();
        return \View::make('backend.setting.setting')->with('arrSetting', $arrSetting)->with('arrgmenu', $arrGroupMenu)->with('active_menu', 'settingview');
    }

}
