<?php

namespace BackEnd;

use DB,
    BackEnd;

class tblColorModel extends \Eloquent {

    protected $table = 'tbl_product_color';
    public $timestamps = false;

    public function addColor($color_name, $color_code) {
        $this->color_name = $color_name;
        $this->color_code = $color_code;
        $result = $this->save();
        return $this;
    }

    public function updateColor($id, $color_name, $color_code) {
        $tableColor = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($color_name != '') {
            $arraysql = array_merge($arraysql, array("color_name" => $color_name));
        }
        if ($color_code != '') {
            $arraysql = array_merge($arraysql, array("color_code" => $color_code));
        }
        $checkupdate = $tableColor->update($arraysql);
        return $checkupdate;
    }

    public function deleteColor($id) {
        $checkdel = $this->where('id', '=', $id)->delete();

        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function selectAllColor($per_page) {
        $allColor = $this->orderBy('color_name')->paginate($per_page);
        return $allColor;
    }

    public function selectAllColorNoPaginate() {
        $allColor = $this->orderBy('color_name')->get();
        return $allColor;
    }

    public function selectColorEdit($id) {
        $colorEdit = $this->where('id', $id)->first();
        return $colorEdit;
    }

}
