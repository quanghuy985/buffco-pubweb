<?php

namespace BackEnd;

class tblTagModel extends \Eloquent {

    protected $table = 'tbltag';
    public $timestamps = false;

    public function insertTag($tagKey, $tagSlug) {
        $this->tagKey = $tagKey;
        $this->tagSlug = $tagSlug;
        $this->time = time();
        $this->status = 1;
        $check = $this->save();
        return $check;
    }

    public function updateTag($tagID, $tagName, $tagDescription, $catetagID, $tagStatus) {
        // $tableAdmin = new TblAdminModel();
        $tableTag = $this->where('id', '=', $tagID);
        $arraysql = array('id' => $tagID);
        if ($tagName != '') {
            $arraysql = array_merge($arraysql, array("tagName" => $tagName));
        }
        if ($tagDescription != '') {
            $arraysql = array_merge($arraysql, array("tagDescription" => $tagDescription));
        }
        if ($catetagID != '') {
            $arraysql = array_merge($arraysql, array("catetagID" => $catetagID));
        }
        if ($tagStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $tagStatus));
        }
        $checku = $tableTag->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteTag($tagID) {
        $checkdel = $this->where('id', '=', $tagID)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllTag($per_page) {
        $allTag = DB::table('tbltag')->paginate($per_page);
        return $allTag;
    }

    public function getAllTagDistint() {
        $allTag = DB::table('tbltag')->groupBy('tagKey')->get();
        return $allTag;
    }

    public function getTagByID($tagID) {
        $objTag = DB::table('tbltag')->where('id', '=', $tagID)->get();
        return $objTag;
    }

    public function getTagByCateID($cateID) {
        $arrTag = DB::table('tbltag')->where('catetagID', '=', $cateID)->get();
        return $arrTag;
    }

    public function getAll() {
        $all = $this->where('status', '=', 1)->get();
        return $all;
    }

}
