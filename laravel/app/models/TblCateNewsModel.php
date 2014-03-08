<?php

class TblCateNewsModel extends Eloquent {

    protected $table = 'tblcatenews';
    public $timestamps = false;

    public function addnewCateNews($cateNewsName, $cateNewsDescription, $catenewsKeywords, $cateNewsParent, $cateNewsSlug) {
        $this->catenewsName = $cateNewsName;
        $this->catenewsDescription = $cateNewsDescription;
        $this->catenewsKeywords = $catenewsKeywords;
        $this->catenewsParent = $cateNewsParent;
        $this->catenewsSlug = $cateNewsSlug;
        $this->catenewsTime = time();
        $this->status = 0;
        $this->save();
    }

    public function updateCateNews($cateNewsID, $cateNewsName, $cateNewsDescriptions, $cateKeywords, $cateNewsParent, $cateNewsSlug, $cateNewsStatus) {
        // $tableAdmin = new TblAdminModel();
        $tableCateNews = $this->where('id', '=', $cateNewsID);
        $arraysql = array('id' => $cateNewsID);
        if ($cateNewsName != '') {
            $arraysql = array_merge($arraysql, array("catenewsName" => $cateNewsName));
        }if ($cateNewsDescriptions != '') {
            $arraysql = array_merge($arraysql, array("cateNewsDescriptions" => $cateNewsDescriptions));
        }if ($cateKeywords != '') {
            $arraysql = array_merge($arraysql, array("cateKeywords" => $cateKeywords));
        }
        if ($cateNewsParent != '') {
            $arraysql = array_merge($arraysql, array("catenewsParent" => $cateNewsParent));
        }
        if ($cateNewsSlug != '') {
            $arraysql = array_merge($arraysql, array("catenewsSlug" => $cateNewsSlug));
        }
        if ($cateNewsStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $cateNewsStatus));
        }

        $checku = $tableCateNews->update($arraysql);
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

    public function selectCateNew($sqlfun) {
        $results = DB::select($sqlfun);
        return ($results);
    }

    public function allCateNew($per_page) {
        $alladmin = DB::table('tblCateNews')->paginate($per_page);
        return $alladmin;
    }

    public function findCateNewsByID($id) {
        $adminarray = DB::table('tblCateNews')->where('id', '=', $id)->get();
        return $adminarray[0];
    }

}
