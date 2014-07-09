<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblAttachmentProjectModel extends \Eloquent {

    protected $table = 'tblattachmentproject';
    public $timestamps = false;

    public function addAttachment($projectID, $attachmentURL) {
        $this->projectID = $projectID;
        $this->attachmentURL = $attachmentURL;
        $this->time = time();
        $this->status = 1;
        $result = $this->save();
        return $result;
    }

    public function getAttachmentByProjectId($projectID) {
        $arrAttachment = DB::table('tblattachmentproject')->where('projectID', '=', $projectID)->get();
        return $arrAttachment;
    }

    public function deleteAttachmentByProjectID($projectID) {
        $checkdel = $this->where('projectID', '=', $projectID)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
