<?php

namespace FontEnd;

use DB;

class SettingModel extends \Eloquent {

    protected $table = 'tbl_setting';
    public $timestamps = false;

    public function getSetting() {
        $arrSetting = $this->where('settingKey', '=', '_settingsite')->get();
        return $arrSetting;
    }

}
