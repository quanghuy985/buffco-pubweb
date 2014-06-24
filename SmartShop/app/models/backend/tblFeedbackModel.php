<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblFeedbackModel extends \Eloquent {

    protected $table = 'tbl_feed_back';
    public $timestamps = false;

    public function addFeedback($feedbackUserEmail, $feedbackUserName, $feedbackSubject, $feedbackContent) {
        $this->feedbackUserEmail = $feedbackUserEmail;
        $this->feedbackUserName = $feedbackUserName;
        $this->feedbackSubject = $feedbackSubject;
        $this->feedbackContent = $feedbackContent;
        $this->time = time();
        $this->status = 0;
        $result = $this->save();
        return $result;
    }

    public function updateFeedback($feedbackID, $feedbackStatus) {
        // $tableAdmin = new TblAdminModel();
        $checkdel = $this->where('id', '=', $feedbackID)->update(array('status' => $feedbackStatus));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteFeedback($feedbackID) {
        // $tableAdmin = new TblAdminModel();
        $checkdel = $this->where('id', '=', $feedbackID)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function selectFeedback($sqlfun) {
        $results = \DB::select($sqlfun);
        return ($results);
    }

    public function allFeedback($per_page) {
        $arrFeedback = $this->orderBy('status')->orderBy('time', 'desc')->paginate($per_page);
        return $arrFeedback;
    }

    public function fillterFeedback($per_page, $from, $to) {
        $arrFeedback = $this->orderBy('status')->orderBy('time', 'desc')->whereBetween('time', array($from, $to))->paginate($per_page);
        return $arrFeedback;
    }

    public function searchFeedback($per_page, $keyword) {
        $arrFeedback = $this->orderBy('status')->orderBy('time', 'desc')->where('feedbackUserEmail', 'LIKE', '%' . $keyword . '%')->orWhere('feedbackUserName', 'LIKE', '%' . $keyword . '%')->orWhere('feedbackSubject', 'LIKE', '%' . $keyword . '%')->orWhere('feedbackContent', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $arrFeedback;
    }

    public function searchFillterFeedback($per_page, $from, $to, $status) {
        $arrFeedback = \DB::table('tbl_feed_back');
        if ($from != 'null') {
            $arrFeedback->where('time', '>', $from);
        }
        if ($to != 'null') {
            $arrFeedback->where('time', '<', $to);
        }
        if ($status != 'null') {
            $arrFeedback->where('status', '=', $status);
        }
        $arrFeedbackRt = $arrFeedback->orderBy('status')->orderBy('time', 'desc')->paginate($per_page);
        return $arrFeedbackRt;
    }

    public function getFeedbackbyID($feedbackID) {
        $objectFeedback = \DB::table('tbl_feed_back')->where('id', '=', $feedbackID)->get();
        return $objectFeedback;
    }

    public function findFeedback($keyword, $per_page, $orderby, $status) {
        $arrFeedback = DB::table('tbl_feed_back')->where('tbl_feed_back.id', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_feed_back.feedbackUserEmail', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_feed_back.feedbackUserName', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_feed_back.feedbackSubject', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_feed_back.feedbackContent', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        return $arrFeedback;
    }

}
