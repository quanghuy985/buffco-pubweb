<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblColorModel extends \Eloquent {

    protected $table = 'tblcolor';
    public $timestamps = false;

    public function selectAll() {
        $allColor = $this->where('status', '=', 1)->get();
        return $allColor;
    }

    public function selectColorbyId($id) {
        $allColor = $this->where('status', '=', 1)->where('id', '=', $id)->get();
        return $allColor;
    }

    public function getColorByColorCode($colorCode) {
        $allColor = $this->where('colorCode', '=', $colorCode)->get();
        return $allColor;
    }

    public function addColor($colorName, $colorCode) {
        $this->colorName = $colorName;
        $this->colorCode = $colorCode;
        $this->time = time();
        $this->status = 1;
        $result = $this->save();
        return $result;
    }

    public function editColor($id, $colorName, $colorCode, $status) {
        $tableColor = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($colorName != '') {
            $arraysql = array_merge($arraysql, array("colorName" => $colorName));
        }
        if ($colorCode != '') {
            $arraysql = array_merge($arraysql, array("colorCode" => $colorCode));
        }

        $arraysql = array_merge($arraysql, array("time" => time()));
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }


        $checkupdate = $tableColor->update($arraysql);
        if ($checkupdate > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteColor($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
