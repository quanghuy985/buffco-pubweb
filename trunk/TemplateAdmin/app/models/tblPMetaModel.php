<?php

class tblPMetaModel extends Eloquent {

    protected $table = 'tblpmeta';
    public $timestamps = false;

    public function insertPMeta($productID, $tagID) {
        $this->productID = $productID;
        $this->tagID = $tagID;        
        $this->time = time();
        $this->status = 0;
        $this->save();
    }

    public function updatePMeta($pMetaID,$productID, $tagID, $tagStatus) {
        // $tableAdmin = new TblAdminModel();
        $tablePMeta = $this->where('id', '=', $pMetaID);
        $arraysql = array('id' => $pMetaID);
        if ($productID != '') {
            $arraysql = array_merge($arraysql, array("productID" => $productID));
        }
        if ($tagID != '') {
            $arraysql = array_merge($arraysql, array("tagID" => $tagID));
        }   
        if ($tagStatus != '') {
            $arraysql = array_merge($arraysql, array("tagStatus" => $tagStatus));
        }
        $checku = $tablePMeta->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletePMeta($pMetaID) {
        $checkdel = $this->where('id', '=', $pMetaID)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllPMeta($per_page) {
        $allPMeta= DB::table('tblpmeta')->paginate($per_page);
        return $allPMeta;
    }

    public function getPMetaByID($pMetaID) {
        $objPMeta = DB::table('tblpmeta')->where('id', '=', $pMetaID)->get();
        return $objPMeta[0];
    }
    
     public function getProductID($productID) {
        $objPMeta = DB::table('tblpmeta')->where('productID', '=', $productID)->get();
        return $objPMeta[0];
    }
    
      public function getTagID($tagID) {
        $objPMeta = DB::table('tblpmeta')->where('tagID', '=', $tagID)->get();
        return $objPMeta[0];
    }

}
