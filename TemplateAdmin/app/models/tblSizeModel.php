<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblSizeModel extends Eloquent {

    protected $table = 'tblsize';
    public $timestamps = false;

    public function addSize($sizeName, $sizeDescription,$sizeValue) {
        $this->sizeName = $sizeName;
        $this->sizeDescription = $sizeDescription;
        $this->sizeValue = $sizeValue;        
        $this->time = time();
        $this->status = 0;
        $check = $this->save();
        return $check;
    }

    public function updateSize($id,$sizeName, $sizeDescription,$sizeValue, $sizeStatus) {
        // $tableAdmin = new TblAdminModel();
        $tableSize = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($sizeName != '') {
            $arraysql = array_merge($arraysql, array("sizeName" => $sizeName));
        }
        if ($sizeDescription != '') {
            $arraysql = array_merge($arraysql, array("sizeDescription" => $sizeDescription));
        }
        if ($sizeValue != '') {
            $arraysql = array_merge($arraysql, array("sizeValue" => $sizeValue));
        }
        if ($sizeStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $sizeStatus));
        }


        $check = $tableSize->update($arraysql);
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteSize($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function selectAllSize($per_page,$orderby){
        $allSize = DB::table('tblsize')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allSize;
    }
    

    public function allSize($per_page) {
        $allSize = DB::table('tblsize')->paginate($per_page);
        return $allSize;
    }

    public function getSizeByID($id) {
        $objectSize = DB::table('tblsize')->where('id', '=', $id)->get();
        return $objectSize[0];
    }

    public function FindSize($keyword, $per_page, $orderby, $status) {
        $sizearray = '';
        if ($status == '') {
            $sizearray = DB::table('tblsize')->select('tblsize.*')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $sizearray = DB::table('tblsize')->select('tblsize.*')->where('tblsize.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $sizearray;
    }
    
    public function SearchSize($keyword, $per_page, $orderby){
        $sizearray = '';
        $sizearray = DB::table('tblsize')->select('tblsize.*')->where('tblsize.sizeName', 'LIKE', '%' . $keyword . '%')->orwhere('tblsize.sizeDescription', 'LIKE', '%' . $keyword . '%')->orwhere('tblsize.sizeValue', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        return $sizearray;
    }

}

