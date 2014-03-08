<?php

class TblFeedbackModel extends Eloquent {

    protected $guarded = array();
    public static $rules = array();
    protected $table = 'tblFeedback';
    public $timestamps = false;

    public function addnewCateNews($feedbackUserEmail, $feedbackUserName, $feedbackSubject, $feedbackContent) {
        $this->feedbackUserEmail = $feedbackUserEmail;
        $this->feedbackUserName = $feedbackUserName;
        $this->feedbackSubject = $feedbackSubject;
        $this->feedbackContent = $feedbackContent;
        $this->feedbackTime = time();
        $this->status = 0;
        $this->save();
    }

    // Chuyen trang thai feedback tu chua doc (status = 0) -> doc roi(status = 1), tu doc roi sang da tra loi(status = 2)
    public function updateFeedback($feedbackID, $feedbackStatus) {
        // $tableAdmin = new TblAdminModel();
        $checkdel = $this->where('id', '=', $feedbackID)->update(array('status' => $feedbackStatus));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function selectFeedback($sqlfun) {
        $results = DB::select($sqlfun);
        return ($results);
    }

    public function allFeedback($per_page) {
        $alladmin = $this->paginate($per_page);
        return $alladmin;
    }

    public function getFeedbackbyID($feedbackID) {
        $objectFeedback = DB::table('tblFeedback')->where('id', '=', $feedbackID)->get();
        return $objectFeedback[0];
    }

    public function findFeedback($keyword, $per_page, $orderby, $status) {
        $adminarray = DB::table('tblFeedback')->where('tblFeedback.id', 'LIKE', '%' . $keyword . '%')->orWhere('tblFeedback.feedbackUserEmail', 'LIKE', '%' . $keyword . '%')->orWhere('tblFeedback.feedbackUserName', 'LIKE', '%' . $keyword . '%')->orWhere('tblFeedback.feedbackSubject', 'LIKE', '%' . $keyword . '%')->orWhere('tblFeedback.feedbackContent', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        return $adminarray;
    }

}
