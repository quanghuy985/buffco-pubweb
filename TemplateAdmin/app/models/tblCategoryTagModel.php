<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblCategoryTagModel extends Eloquent {

    protected $guarded = array();
    protected $table = 'tblCateTag';
    public $timestamps = false;
    public static $rules = array();

    public function addCateTag($cateTagName) {
        $this->cateTagName = $cateTagName;
        $this->time = time();
        $this->status = 0;
        $result = $this->save();
        return $result;
    }

    public function updateCateTag($cateTagID, $cateTagName, $cateStatus) {
        // $tableAdmin = new TblAdminModel();
        $tblCateTag = $this->where('id', '=', $cateTagID);
        $arraysql = array('id' => $cateTagID);
        if ($cateTagName != '') {
            $arraysql = array_merge($arraysql, array("cateTagName" => $cateTagName));
        }
        if ($cateStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $cateStatus));
        }
        $checku = $tblCateTag->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteCateTag($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function allCateTag($per_page) {
        $arrTag = DB::table('tblCateTag')->paginate($per_page);
        return $arrTag;
    }

    public function findCateTagByID($id) {
        $objTag = DB::table('tblCateTag')->where('id', '=', $id)->get();
        return $objTag;
    }

}
