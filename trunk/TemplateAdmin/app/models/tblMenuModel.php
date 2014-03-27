<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblMenuModel extends Eloquent {

    protected $guarded = array();
    protected $table = 'tblMenu';
    public $timestamps = false;
    public static $rules = array();

    public function addMenu($menuName, $menuURL, $menuParent, $menuPosition) {
        $this->menuName = $menuName;
        $this->menuURL = $menuURL;
        $this->menuParent = $menuParent;
        $this->menuPosition = $menuPosition;
        $this->time = time();
        $this->status = 0;
        $result = $this->save();
        return $result;
    }

    public function updateMenu($id, $menuName, $menuURL, $menuParent, $menuPosition, $status) {
        $objMenu = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($menuName != '') {
            $arraysql = array_merge($arraysql, array("menuName" => $menuName));
        }
        if ($menuURL != '') {
            $arraysql = array_merge($arraysql, array("menuURL" => $menuURL));
        }
        if ($menuParent != '') {
            $arraysql = array_merge($arraysql, array("menuParent" => $menuParent));
        }
        if ($menuPosition != '') {
            $arraysql = array_merge($arraysql, array("menuPosition" => $menuPosition));
        }
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $objMenu->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findMenuByID($id) {
        $objMenu = DB::table('tblMenu')->where('id', '=', $id)->get();
        return $objMenu;
    }

    public function allMenu($per_page) {
        $arrMenu = DB::table('tblMenu')->orderBy('id', 'desc')->paginate($per_page);
        return $arrMenu;
    }

    public function deleteMenuByID($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
