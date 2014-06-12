<?php

namespace BackEnd;

class tblPromotionModel extends \Eloquent {

    protected $table = 'tblpromotion';
    public $timestamps = false;

    public function insertPromotion($promotionName, $promotionContent, $promotionAmount, $promotionStatus) {
        $this->promotionName = $promotionName;
        $this->promotionContent = $promotionContent;
        $this->promotionAmount = $promotionAmount;
        $this->time = time();
        $this->status = $promotionStatus;
        $this->save();
    }

    public function updatePromotion($promotionID, $promotionName, $promotionContent, $promotionAmount, $promotionStatus) {
        // $tableAdmin = new TblAdminModel();
        $tablePromotion = $this->where('id', '=', $promotionID);
        $arraysql = array('id' => $promotionID);
        if ($promotionName != '') {
            $arraysql = array_merge($arraysql, array("promotionName" => $promotionName));
        }
        if ($promotionContent != '') {
            $arraysql = array_merge($arraysql, array("promotionContent" => $promotionContent));
        }
        if ($promotionAmount != '') {
            $arraysql = array_merge($arraysql, array("promotionAmount" => $promotionAmount));
        }
        if ($promotionStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $promotionStatus));
        }
        $checku = $tablePromotion->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletePromotion($promotionID) {
        $checkdel = $this->where('id', '=', $promotionID)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllPromotion($per_page) {
        $allTag = DB::table('tblpromotion')->paginate($per_page);
        return $allTag;
    }

    public function getPromotionByID($promotionID) {
        $objPromotion = DB::table('tblpromotion')->where('id', '=', $promotionID)->get();
        return $objPromotion;
    }

    public function getAllPromotionList() {
        $arrPromotion = DB::table('tblpromotion')->where('status', '=', 1)->get();
        return $arrPromotion;
    }

}
