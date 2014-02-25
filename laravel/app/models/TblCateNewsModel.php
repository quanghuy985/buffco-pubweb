<?php

class TblCateNewsModel extends Eloquent {

    protected $table = 'tblcatenews';
    public $timestamps = false;

    public function addnewCateNews($cateNewsName, $cateNewsParent, $cateNewsSlug) {
        $this->catenewsName = $cateNewsName;
        $this->catenewsParent = $cateNewsParent;
        $this->catenewsSlug = $cateNewsSlug;
        $this->catenewsTime = time();
        $this->status = 0;
        $this->save();
    }

    public function updateCateNews($cateNewsID, $cateNewsName, $cateNewsParent, $cateNewsSlug, $cateNewsStatus) {
        // $tableAdmin = new TblAdminModel();
        $tableCateNews = $this->where('id', '=', $cateNewsID);
        $arraysql = array('id' => $cateNewsID);
        if ($cateNewsName != '') {
            $arraysql = array_merge($arraysql, array("catenewsName" => $cateNewsName));
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
        $checkdel = $this->where('id', '=', $cateNewsId)->update(array('status' => 0));
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
        $alladmin = $this->paginate($per_page);
        return $alladmin;
    }

}
