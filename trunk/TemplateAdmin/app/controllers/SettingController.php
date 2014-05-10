<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SettingController extends BaseController {

    public function postUpdateSetting() {
        $paramseting = array(
            'titlewebsite' => Input::get('titlewebsite'),
            'tagline' => Input::get('tagline'),
            'description' => Input::get('description'),
            'keywordsearch' => Input::get('keywordsearch'),
            'smtphost' => Input::get('smtphost'),
            'smtpport' => Input::get('smtpport'),
            'frommail' => Input::get('frommail'),
            'fromname' => Input::get('fromname'),
            'usernamemail' => Input::get('usernamemail'),
            'passwordmail' => Input::get('passwordmail'),
            'baokimuser' => Input::get('baokimuser'),
            'nganluonguser' => Input::get('nganluonguser'),
            'tiente' => Input::get('tiente'),
            'logowebsite' => Input::get('logowebsite'),
            'footer' => Input::get('footer'),
            'tencongty' => Input::get('tencongty'),
            'diachicongty' => Input::get('diachicongty'),
            'sodienthoaicongty' => Input::get('sodienthoaicongty'),
            'sodienthoaiddcongty' => Input::get('sodienthoaiddcongty'),
            'emailcongty' => Input::get('emailcongty'),
            'webcongty' => Input::get('webcongty'),
            'facebookfanpage' => Input::get('facebookfanpage'),
            'commentfb' => Input::get('commentfb'),
            'googleanc' => Input::get('googleanc'),
            'googlemaps' => Input::get('googlemaps'),
        );
        $tblSettingModel = new tblSettingModel();
        $check = $tblSettingModel->saveSetting(serialize($paramseting));
//        $arrSetting = $tblSettingModel->getSetting();
//        $arrSetting = unserialize($arrSetting[0]->settingValue);
        // return View::make('backend.setting.setting')->with('arrSetting', $arrSetting);
        return Redirect::action('SettingController@getUpdateSetting');
    }

    public function getUpdateSetting() {

        $tblSettingModel = new tblSettingModel();
        $arrSetting = $tblSettingModel->getSetting();
        $arrSetting = unserialize($arrSetting[0]->settingValue);
        return View::make('backend.setting.setting')->with('arrSetting', $arrSetting);
    }

}
