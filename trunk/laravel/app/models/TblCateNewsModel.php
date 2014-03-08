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
            $arraysql = array_merge($arraysql, array("cateNewsDescription" => $cateNewsDescriptions));
        }if ($cateKeywords != '') {
            $arraysql = array_merge($arraysql, array("catenewsKeywords" => $cateKeywords));
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

    public function getAllCategoryNew($start, $per_page) {
        $results = DB::select("select a.catenewsName as N1,a.catenewsName as catenewsName,a.catenewsDescription as catenewsDescription,a.catenewsKeywords as catenewsKeywords,a.catenewsParent as catenewsParent,a.id as id,a.catenewsSlug as catenewsSlug,a.catenewsTime as catenewsTime,a.status as status FROM `tblcatenews` as a where a.catenewsParent=0
        UNION ALL
        select a.catenewsName as N1,b.catenewsName as catenewsName,b.catenewsDescription as catenewsDescription,b.catenewsKeywords as catenewsKeywords,b.catenewsParent as catenewsParent,b.id as id,b.catenewsSlug as catenewsSlug ,b.catenewsTime as catenewsTime,b.status as status  FROM `tblcatenews` as a INNER JOIN `tblcatenews` as b On a.id = b.catenewsParent
        ORDER BY N1,catenewsParent
        LIMIT ?,?", array($start, $per_page));
        return $results;
    }

    public function getAllCategoryNewPagin($per_page) {
        $results1 = DB::select("select a.catenewsName as N1,a.catenewsName as catenewsName,a.catenewsDescription as catenewsDescription,a.catenewsKeywords as catenewsKeywords,a.catenewsParent as catenewsParent,a.id as id,a.catenewsSlug as catenewsSlug,a.catenewsTime as catenewsTime,a.status as status FROM `tblcatenews` as a where a.catenewsParent=0
        UNION ALL
        select a.catenewsName as N1,b.catenewsName as catenewsName,b.catenewsDescription as catenewsDescription,b.catenewsKeywords as catenewsKeywords,b.catenewsParent as catenewsParent,b.id as id,b.catenewsSlug as catenewsSlug ,b.catenewsTime as catenewsTime,b.status as status  FROM `tblcatenews` as a INNER JOIN `tblcatenews` as b On a.id = b.catenewsParent
        ORDER BY N1,catenewsParent");
        return Paginator::make($results1, count($results1), $per_page);
    }

}
