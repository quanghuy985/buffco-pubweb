<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblAttachmentModel extends Eloquent {

    protected $table = 'tblAttachment';
    public $timestamps = false;

    public function addAttachment($destinyID, $attachmentName, $attachmentURL) {
        $this->destinyID = $destinyID;
        $this->attachmentName = $attachmentName;
        $this->attachmentURL = $attachmentURL;
        $this->time = time();
        $this->status = 0;
    }

    public function updateAttachment($attachmentID, $destinyID, $attachmentName, $attachmentURL) {
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

    public function getAttachmentByDestinyID($destinyID) {
        $arrAttachment = DB::table('tblAttachment')->where('destinyID', '=', $destinyID)->get();
        return $arrAttachment;
    }

}
