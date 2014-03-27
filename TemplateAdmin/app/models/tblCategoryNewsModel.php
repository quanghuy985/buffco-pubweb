<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblCategoryNewsModel extends Eloquent {

    public function addCategoryNews($cateNewsName, $cateNewsDescription, $cateNewsParent, $cateNewsSlug) {
        $this->catenewsName = $cateNewsName;
        $this->catenewsDescription = $cateNewsDescription;
        $this->catenewsParent = $cateNewsParent;
        $this->catenewsSlug = $cateNewsSlug;
        $this->time = time();
        $this->status = 0;
    }

    public function updateCategoryNews($cateNewsID, $cateNewsName, $cateNewsDescription, $cateNewsParent, $cateNewsSlug, $status) {
        $objCategoryNews = $this->where('id', '=', $cateNewsID);
        $arraysql = array('id' => $cateNewsID);
        if ($cateNewsName != '') {
            $arraysql = array_merge($arraysql, array("catenewsName" => $cateNewsName));
        }
        if ($cateNewsDescription != '') {
            $arraysql = array_merge($arraysql, array("catenewsDescription" => $cateNewsDescription));
        }
        if ($cateNewsParent != '') {
            $arraysql = array_merge($arraysql, array("catenewsParent" => $cateNewsParent));
        }
        if ($cateNewsSlug != '') {
            $arraysql = array_merge($arraysql, array("catenewsSlug" => $cateNewsSlug));
        }
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $objCategoryNews->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteCateNews($cateNewsId) {
        $checkdel = $this->where('id', '=', $cateNewsId)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteCateNewsChild($id) {
        $checkdel = $this->where('cateNewsParent', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findCateNews($keyword, $per_page) {
        $cateArray = DB::table('tblCateNews')->where('catenewsName', 'LIKE', '%' . $keyword . '%')->orWhere('catenewsSlug', 'LIKE', '%' . $keyword . '%')->orWhere('catenewsTime', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $cateArray;
    }

}
