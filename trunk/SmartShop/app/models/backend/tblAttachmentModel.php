<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblAttachmentModel extends \Eloquent {

    protected $table = 'tblAttachment';
    public $timestamps = false;

    public function addAttachment($destinyID, $attachmentURL) {
        $this->destinyID = $destinyID;
        $this->attachmentURL = $attachmentURL;
        $this->time = time();
        $this->status = 0;
        $result = $this->save();
        return $result;
    }

    public function updateAttachment($attachmentID, $destinyID, $attachmentName, $attachmentURL, $status) {
        $objAttachment = $this->where('id', '=', $attachmentID);
        $arraysql = array('id' => $attachmentID);
        if ($destinyID != '') {
            $arraysql = array_merge($arraysql, array("destinyID" => $destinyID));
        }
        if ($attachmentName != '') {
            $arraysql = array_merge($arraysql, array("attachmentName" => $attachmentName));
        }
        if ($attachmentURL != '') {
            $arraysql = array_merge($arraysql, array("attachmentURL" => $attachmentURL));
        }
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $objAttachment->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAttachmentByProductId($destinyID) {
        $arrAttachment = DB::table('tblAttachment')->where('destinyID', '=', $destinyID)->get();
        return $arrAttachment;
    }

    public function deleteAttachmentByID($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

//    public function deleteAttachmentByDestinyID($id) {
//        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
//        if ($checkdel > 0) {
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
    public function deleteAttachmentByDestinyID($destinyID) {
        $checkdel = $this->where('destinyID', '=', $destinyID)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function allAttachmentPanigate($per_page) {
        $arrAttachment = DB::table('tblAttachment')->paginate($per_page);
        return $arrAttachment;
    }

}
