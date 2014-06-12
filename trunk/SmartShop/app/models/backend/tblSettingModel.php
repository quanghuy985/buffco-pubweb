<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblSettingModel extends \Eloquent {

    protected $table = 'tbl_setting';
    public $timestamps = false;

    public function saveSetting($param) {
        $check = $this->where('settingKey', '=', '_settingsite')->update(array('settingValue' => $param, 'time' => time()));
        return $check;
    }

    public function getSetting() {
        $arrSetting = $this->where('settingKey', '=', '_settingsite')->first();
        return $arrSetting;
    }

}
